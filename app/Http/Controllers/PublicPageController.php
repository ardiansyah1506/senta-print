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

    public function storeOrder(Request $request) {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'cart' => 'required|json'
        ]);

        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang pesanan tidak boleh kosong.');
        }

        $anonUser = User::firstOrCreate(
            ['username' => $request->no_whatsapp],
            ['nama' => $request->nama_pemesan, 'password' => bcrypt('sentaprint'), 'role' => 'customer']
        );

        $order = Order::create([
            'customer_id' => $anonUser->id,
            'invoice_no' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
            'subtotal' => 0,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 0,
            'payment_status' => 'PENDING',
        ]);

        $grand_total = 0;
        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $base_price = $product->price ?? 0;
            $grand_total += $item['total_price'];
            
            $designFilePath = null;
            if ($request->hasFile("design_files.{$item['id']}")) {
                $file = $request->file("design_files.{$item['id']}");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/designs', $fileName);
                $designFilePath = 'designs/' . $fileName;
            }

            foreach ($item['sizes'] as $sizeId => $qty) {
                if ($qty <= 0) continue;
                $size = \App\Models\Size::find($sizeId);
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'qty' => $qty,
                    'size_id' => $sizeId,
                    'size_name' => $size->name,
                    'unit_price' => $item['base_price'],
                    'total_price' => $item['base_price'] * $qty,
                    'notes' => $request->notes,
                    'design_file' => $designFilePath,
                ]);

                foreach ($item['addons'] as $addonPayload) {
                    $addon = \App\Models\Addon::find($addonPayload['id']);
                    $fullAddonName = $addon->name;
                    if (!empty($addonPayload['size_id']) && $addonPayload['size_id'] == $sizeId) {
                        $fullAddonName .= " (untuk " . $size->name . ")";
                    }
                    
                    OrderItemAddon::create([
                        'order_item_id' => $orderItem->id,
                        'addon_id' => $addon->id,
                        'addon_name' => $fullAddonName,
                        'addon_price' => $addonPayload['price'] * $addonPayload['qty']
                    ]);
                }
            }
        }

        $order->update(['subtotal' => $grand_total, 'grand_total' => $grand_total]);

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Nomor Invoice Anda: ' . $order->invoice_no);
    }
}
