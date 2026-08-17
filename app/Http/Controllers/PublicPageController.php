<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PublicPageController extends Controller
{
    public function index() {
        return view('index');
    }

    public function buatPesanan() {
        return view('public-pesan');
    }

    public function storeOrder(Request $request, \App\Services\OrderService $orderService) {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $rawPhone = trim($request->no_whatsapp);
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);

        // 1. Find or create Customer record (checks phone matching raw or clean digits)
        $customer = Customer::where('phone', $rawPhone)
            ->orWhere('phone', $cleanPhone)
            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'name' => trim($request->nama_pemesan),
                'phone' => $rawPhone,
            ]);
        }

        // 2. Find or create User account for customer portal
        $user = User::where('phone', $rawPhone)
            ->orWhere('phone', $cleanPhone)
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => trim($request->nama_pemesan),
                'phone' => $rawPhone,
                'email' => $cleanPhone . '@customer.sentaprint.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);
        }

        try {
            $order = Order::create([
                'customer_id' => $customer->id,
                'invoice_no' => $orderService->generateInvoiceNo(),
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'grand_total' => 0,
                'payment_status' => 'PENDING',
                'notes' => $request->notes ?? ''
            ]);

            return redirect()->route('public.order.buat')->with('order_success', [
                'invoice_no' => $order->invoice_no,
                'nama_pemesan' => trim($request->nama_pemesan),
                'no_whatsapp' => $rawPhone,
                'total_price' => 0,
                'total_qty' => 0,
                'created_at' => $order->created_at->format('d M Y H:i'),
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function searchOrder(Request $request) {
        $request->validate([
            'invoice_no' => 'required|string'
        ]);

        $invoiceNo = trim($request->invoice_no);
        $order = Order::where('invoice_no', $invoiceNo)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Invoice "' . $invoiceNo . '" tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'invoice_no' => $order->invoice_no,
            'message' => 'Invoice ditemukan. Silakan masukkan nomor WhatsApp Anda untuk memverifikasi pesanan.'
        ]);
    }

    public function verifyAndTrackOrder(Request $request) {
        $request->validate([
            'invoice_no' => 'required|string',
            'no_whatsapp' => 'nullable|string'
        ]);

        $invoiceNo = trim($request->invoice_no);
        $inputPhoneClean = preg_replace('/[^0-9]/', '', $request->no_whatsapp);

        $order = Order::with(['customer', 'items.addons', 'production.logs.step', 'production.logs.photos'])
            ->where('invoice_no', $invoiceNo)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Invoice tidak ditemukan.'
            ], 404);
        }

        $customerPhoneClean = preg_replace('/[^0-9]/', '', $order->customer->phone ?? '');
        $user = auth()->user();
        $isAuthorizedUser = $user && ($user->role === 'admin' || $user->name === $order->customer->name || preg_replace('/[^0-9]/', '', $user->phone ?? '') === $customerPhoneClean);

        if (!$isAuthorizedUser && $customerPhoneClean !== $inputPhoneClean && $order->customer->phone !== trim($request->no_whatsapp ?? '')) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak cocok dengan pemilik Invoice ini.'
            ], 403);
        }

        $allMasterSteps = \App\Models\ProductionStep::orderBy('sort_order', 'asc')->get();
        $completedLogsMap = [];
        if ($order->production && $order->production->logs) {
            foreach ($order->production->logs as $log) {
                $completedLogsMap[$log->production_step_id] = [
                    'notes' => $log->notes,
                    'created_at' => $log->created_at->format('d M Y, H:i'),
                    'photos' => $log->photos->map(fn($p) => asset('storage/' . $p->file_path))->toArray()
                ];
            }
        }

        $completedIds = array_keys($completedLogsMap);
        $nextRequiredStep = $allMasterSteps->first(fn($s) => !in_array($s->id, $completedIds));

        $sequentialSteps = $allMasterSteps->map(function($st) use ($completedLogsMap, $nextRequiredStep) {
            $isDone = isset($completedLogsMap[$st->id]);
            $isActive = ($nextRequiredStep && $nextRequiredStep->id == $st->id);
            
            return [
                'id' => $st->id,
                'name' => $st->name,
                'status' => $isDone ? 'completed' : ($isActive ? 'active' : 'pending'),
                'notes' => $isDone ? $completedLogsMap[$st->id]['notes'] : null,
                'created_at' => $isDone ? $completedLogsMap[$st->id]['created_at'] : null,
                'photos' => $isDone ? $completedLogsMap[$st->id]['photos'] : []
            ];
        });

        $currentStepName = 'Menunggu Pembayaran';
        if ($order->status === 'completed') {
            $currentStepName = 'Selesai / Siap Dikirim';
        } elseif ($nextRequiredStep) {
            $currentStepName = $nextRequiredStep->name;
        } elseif ($allMasterSteps->isNotEmpty() && empty($nextRequiredStep)) {
            $currentStepName = 'Seluruh Tahap Selesai';
        }

        $paymentStatus = strtoupper($order->payment_status ?? 'PENDING');

        $itemsSummary = $order->items->map(function($item) {
            $basePrice = (float)($item->base_price > 0 ? $item->base_price : $item->unit_price);
            $subtotalBaju = $basePrice * $item->qty;

            $addonsDetail = $item->addons->map(function($addon) {
                return [
                    'name' => $addon->addon_name,
                    'price' => (float)$addon->addon_price
                ];
            });

            $totalAddonCost = $addonsDetail->sum('price');
            $lineTotalFinal = $subtotalBaju + $totalAddonCost;

            return [
                'product_name' => $item->product_name,
                'size_name' => $item->size_name,
                'qty' => (int)$item->qty,
                'base_price' => $basePrice,
                'subtotal_baju' => $subtotalBaju,
                'total_addon' => $totalAddonCost,
                'total_price' => $lineTotalFinal,
                'addons' => $addonsDetail,
                'design_file' => $item->design_file ? asset('storage/' . $item->design_file) : null
            ];
        });

        return response()->json([
            'success' => true,
            'order' => [
                'invoice_no' => $order->invoice_no,
                'customer_name' => $order->customer->name,
                'phone' => $order->customer->phone,
                'payment_status' => $paymentStatus,
                'current_production_step' => $currentStepName,
                'subtotal' => (float)$order->subtotal,
                'grand_total' => (float)$order->grand_total,
                'created_at' => $order->created_at->format('d M Y H:i'),
                'sequential_steps' => $sequentialSteps,
                'items' => $itemsSummary
            ]
        ]);
    }
}
