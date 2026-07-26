<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Production;
use App\Models\ProductionStep;

class OrderController extends Controller
{
    public function index() { 
        $orders = Order::with(['customer', 'items.product', 'production.logs.step'])
            ->latest()
            ->paginate(10);

        foreach ($orders as $order) {
            $order->wa_link = $this->buildWaLink($order);
        }

        return view('admin.kelola-pesanan', compact('orders')); 
    }

    public function show($id) {
        $order = Order::with(['customer', 'items.product', 'items.addons', 'production.logs.step'])->findOrFail($id);
        $order->wa_link = $this->buildWaLink($order);
        return view('admin.show-pesanan', compact('order'));
    }

    public function confirmPayment($id) {
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
                    'status' => 'completed'
                ]);
            }
        }

        return back()->with('success', 'Pembayaran pesanan ' . $order->invoice_no . ' berhasil dikonfirmasi & diteruskan ke Produksi!');
    }

    public function update(Request $request, $id) {
        $order = Order::findOrFail($id);
        if ($request->has('status')) $order->status = $request->status;
        if ($request->has('payment_status')) $order->payment_status = $request->payment_status;
        $order->save();
        return back()->with('success', 'Status pesanan diperbarui');
    }

    public function destroy($id) {
        Order::findOrFail($id)->delete();
        return back()->with('success', 'Pesanan dihapus');
    }

    private function buildWaLink($order) {
        if (!$order->customer || !$order->customer->phone) return '#';

        $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer->phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $customerName = $order->customer->name ?? 'Kak';
        $invoiceNo = $order->invoice_no;
        $grandTotal = 'Rp ' . number_format($order->grand_total, 0, ',', '.');
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
            $text = "Halo Kak {$customerName},\n\nTerima kasih telah memesan di Senta Print!\nNomor Invoice Anda: *{$invoiceNo}*\nTotal Biaya: *{$grandTotal}*\n\nSilakan melakukan pembayaran/DP agar pesanan Anda dapat segera kami proses ke tahap produksi. Anda dapat melacak pesanan kapan saja di website kami dengan Nomor Invoice & WA ini.\n\nTerima kasih!";
        }

        return 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($text);
    }
}
