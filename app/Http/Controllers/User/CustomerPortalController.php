<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerPortalController extends Controller
{
    public function createOrder() {
        $categories = \App\Models\Category::with(['products', 'sizes', 'addons'])->get();
        return view('user.buat-pesanan', compact('categories'));
    }
    
    public function storeOrder(Request $request, \App\Services\OrderService $orderService) {
        $request->validate([
            'deadline' => 'nullable|date',
            'notes' => 'nullable|string',
            'cart' => 'required|string',
        ]);
        
        try {
            $order = $orderService->createOrder($request, auth()->id(), 'INV-ST-');
            return redirect()->route('user.order.history')->with('success', 'Pesanan berhasil dibuat! Nomor Invoice Anda: ' . $order->invoice_no);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function trackOrder() { return view('user.lacak-pesanan'); }
    public function orderHistory() { return view('user.riwayat-pesanan'); }
}
