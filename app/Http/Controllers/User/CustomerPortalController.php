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
    
    public function storeOrder(Request $request) {
        $request->validate([
            'deadline' => 'nullable|date',
            'notes' => 'nullable|string',
            'cart' => 'required|string',
        ]);
        
        $cart = json_decode($request->cart, true);
        if (empty($cart)) return back()->with('error', 'Keranjang kosong.');

        $order = \App\Models\Order::create([
            'customer_id' => auth()->id(), // assuming user id maps directly or via relation. In this simpler implementation, users table is the customer.
            'invoice_no' => 'INV-ST-' . date('YmdHis'),
            'subtotal' => 0,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 0,
            'payment_status' => 'unpaid'
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
                $orderItem = \App\Models\OrderItem::create([
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
                    // Append qty and size to addon name for historical context
                    $fullAddonName = $addon->name;
                    $fullAddonName .= ' (' . $addonPayload['qty'] . ' pcs';
                    if (!empty($addonPayload['size_name'])) {
                        $fullAddonName .= ' pada ' . $addonPayload['size_name'];
                    }
                    $fullAddonName .= ')';

                    \App\Models\OrderItemAddon::create([
                        'order_item_id' => $orderItem->id,
                        'addon_id' => $addon->id,
                        'addon_name' => $fullAddonName,
                        'addon_price' => $addonPayload['price'] * $addonPayload['qty']
                    ]);
                }
            }
        }
        
        $order->update(['subtotal' => $grand_total, 'grand_total' => $grand_total]);
        
        return redirect()->route('user.order.history')->with('success', 'Pesanan berhasil dibuat!');
    }
    
    public function trackOrder() { return view('user.lacak-pesanan'); }
    public function orderHistory() { return view('user.riwayat-pesanan'); }
}
