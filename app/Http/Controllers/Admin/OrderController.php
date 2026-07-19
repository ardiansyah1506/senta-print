<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() { 
        $orders = \App\Models\Order::with(['customer', 'items.product'])->latest()->paginate(10);
        return view('admin.kelola-pesanan', compact('orders')); 
    }

    public function show($id) {
        $order = \App\Models\Order::with(['customer', 'items.product', 'items.addons'])->findOrFail($id);
        return view('admin.show-pesanan', compact('order'));
    }

    public function update(Request $request, $id) {
        $order = \App\Models\Order::findOrFail($id);
        if ($request->has('status')) $order->status = $request->status;
        if ($request->has('payment_status')) $order->payment_status = $request->payment_status;
        $order->save();
        return back()->with('success', 'Status pesanan diperbarui');
    }

    public function destroy($id) {
        \App\Models\Order::findOrFail($id)->delete();
        return back()->with('success', 'Pesanan dihapus');
    }
}
