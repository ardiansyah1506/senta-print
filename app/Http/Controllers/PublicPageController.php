<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddon;
use App\Models\User;

class PublicPageController extends Controller
{
    public function index() {
        return view('index');
    }

    public function buatPesanan() {
        $categories = Category::with(['products', 'sizes', 'addons'])->get();
        return view('public-pesan', compact('categories'));
    }

    public function storeOrder(Request $request, \App\Services\OrderService $orderService) {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'cart' => 'required|string'
        ]);

        $anonUser = User::firstOrCreate(
            ['username' => $request->no_whatsapp],
            ['nama' => $request->nama_pemesan, 'password' => bcrypt('sentaprint'), 'role' => 'customer']
        );

        try {
            $order = $orderService->createOrder($request, $anonUser->id, 'INV-PUB-');
            return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Nomor Invoice Anda: ' . $order->invoice_no);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
