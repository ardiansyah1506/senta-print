<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Production;
use App\Models\ProductionStep;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->input('filter_type', 'all');
        $month = (int) $request->input('month', date('n'));
        $year = (int) $request->input('year', date('Y'));
        $startDateStr = $request->input('start_date');
        $endDateStr = $request->input('end_date');
        $search = trim($request->input('search', ''));

        $query = Order::with(['customer', 'items.product', 'items.addons', 'production.logs.step', 'production.logs.photos']);

        $startDate = null;
        $endDate = null;

        if ($filterType === 'range' && $startDateStr && $endDateStr) {
            $startDate = Carbon::parse($startDateStr)->startOfDay();
            $endDate = Carbon::parse($endDateStr)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($filterType === 'month') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDateStr && $endDateStr) {
            $startDate = Carbon::parse($startDateStr)->startOfDay();
            $endDate = Carbon::parse($endDateStr)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $filterType = 'range';
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        foreach ($orders as $order) {
            $order->wa_link = $this->buildWaLink($order);
        }

        return view('admin.kelola-pesanan', compact(
            'orders', 'filterType', 'month', 'year', 'startDateStr', 'endDateStr', 'search', 'startDate', 'endDate'
        ));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.addons', 'production.logs.step'])->findOrFail($id);
        $order->wa_link = $this->buildWaLink($order);

        return view('admin.show-pesanan', compact('order'));
    }

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'PAID';
        $order->status = 'production';
        $order->save();

        // Initialize production if not created
        $production = Production::firstOrCreate(
            ['order_id' => $order->id],
            ['started_at' => now()]
        );

        // Attach first step log if no log exists
        if ($production->logs()->count() === 0) {
            $firstStep = ProductionStep::orderBy('sort_order', 'asc')->first();
            if ($firstStep) {
                $production->logs()->create([
                    'production_step_id' => $firstStep->id,
                    'notes' => 'Pembayaran dikonfirmasi. Pesanan diteruskan ke tahap produksi.',
                    'created_by' => auth()->id() ?? 1,
                    'status' => 'completed',
                ]);
            }
        }

        return back()->with('success', 'Pembayaran pesanan '.$order->invoice_no.' berhasil dikonfirmasi & diteruskan ke Produksi!');
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($request->has('status')) {
            $order->status = $request->status;
        }
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }
        $order->save();

        return back()->with('success', 'Status pesanan diperbarui');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return back()->with('success', 'Pesanan dihapus');
    }

    private function buildWaLink($order)
    {
        if (! $order->customer || ! $order->customer->phone) {
            return '#';
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer->phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62'.substr($cleanPhone, 1);
        }

        $customerName = $order->customer->name ?? 'Kak';
        $invoiceNo = $order->invoice_no;
        $grandTotal = 'Rp '.number_format($order->grand_total, 0, ',', '.');
        $paymentStatus = strtoupper($order->payment_status ?? 'PENDING');

        // Active production step name
        $currentStepName = 'Menunggu Pembayaran';
        if ($order->production && $order->production->logs->isNotEmpty()) {
            $lastLog = $order->production->logs->last();
            if ($lastLog && $lastLog->step) {
                $currentStepName = $lastLog->step->name;
            }
        }

        if ($order->status === 'completed' || $order->status === 'finished') {
            $text = "Halo Kak {$customerName},\n\nKabar gembira! Pesanan Anda (Invoice: *{$invoiceNo}*) di Senta Print telah selesai diproduksi dan siap dikirim/diambil.\n\nTerima kasih telah mempercayakan konveksi Anda kepada Senta Print!";
        } elseif ($paymentStatus === 'PAID' || $paymentStatus === 'LUNAS' || $order->status === 'production') {
            $text = "Halo Kak {$customerName},\n\nUpdate pesanan Anda (Invoice: *{$invoiceNo}*) di Senta Print! Pembayaran telah dikonfirmasi dan saat ini pesanan Anda sedang diproses pada tahap produksi: *{$currentStepName}*.\n\nAnda dapat memantau perkembangan foto pengerjaan di menu Lacak Pesanan pada website kami. Terima kasih!";
        } else {
            $userPhone = $order->customer->phone ?? $cleanPhone;
            $text = "Halo Kak {$customerName},\n\nTerima kasih telah memesan di Senta Print!\nNomor Invoice Anda: *{$invoiceNo}*\n\n🔑 *Informasi Akun Anda:*\nAnda dapat login ke website Senta Print menggunakan:\n• Username (No. WA): *{$userPhone}*\n• Password Default: *password*\n\nTotal Biaya: *{$grandTotal}*\n\nSilakan melakukan pembayaran/DP agar pesanan Anda dapat segera kami proses ke tahap produksi. Anda dapat melacak pesanan kapan saja di website kami dengan Nomor Invoice & WA ini.\n\nTerima kasih!";
        }

        return 'https://wa.me/'.$cleanPhone.'?text='.urlencode($text);
    }
}
