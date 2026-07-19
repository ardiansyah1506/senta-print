<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddon;
use App\Models\Product;
use App\Models\Size;
use App\Models\Addon;
use Illuminate\Http\Request;

class OrderService
{
    /**
     * Parse the cart from the request, process each item, calculate totals,
     * manage file uploads for custom designs, and insert database records.
     */
    public function createOrder(Request $request, $customerId, $invoicePrefix = 'INV-')
    {
        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            throw new \Exception('Keranjang pesanan tidak boleh kosong.');
        }

        // Initialize Order object
        $order = Order::create([
            'customer_id' => $customerId,
            'invoice_no' => $invoicePrefix . date('Ymd') . '-' . rand(1000, 9999),
            'subtotal' => 0,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 0,
            'payment_status' => 'PENDING',
        ]);

        $grand_total = 0;
        
        // Loop through logic
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;
            
            // Manage uploaded design file per item
            $designFilePath = null;
            if ($request->hasFile("design_files.{$item['id']}")) {
                $file = $request->file("design_files.{$item['id']}");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/designs', $fileName);
                $designFilePath = 'designs/' . $fileName;
            }

            // Distribute Order items per size explicitly allocated
            foreach ($item['sizes'] as $sizeId => $qty) {
                if ($qty <= 0) continue;
                
                $size = Size::find($sizeId);
                if (!$size) continue;
                
                $item_total = $item['base_price'] * $qty;
                
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'qty' => $qty,
                    'size_id' => $sizeId,
                    'size_name' => $size->name,
                    'unit_price' => $item['base_price'],
                    'total_price' => $item_total,
                    'notes' => $request->notes ?? '', // 'notes' field mostly used loosely
                    'design_file' => $designFilePath,
                ]);
                
                $grand_total += $item_total;

                // Bind generic add-ons (if selected by customer logic payload)
                if (!empty($item['addons'])) {
                    foreach ($item['addons'] as $addonPayload) {
                        $addon = Addon::find($addonPayload['id']);
                        if (!$addon) continue;
                        
                        $qtyAddon = $addonPayload['qty'] ?? 1;
                        $fullAddonName = $addon->name;
                        
                        // Standardizing Addon name details depending on available logic
                        if (isset($addonPayload['qty'])) {
                            $fullAddonName .= " ({$qtyAddon} pcs" . (isset($addonPayload['size_name']) ? " pada {$addonPayload['size_name']}" : "") . ")";
                        }

                        $addon_line_total = $addonPayload['price'] * $qtyAddon;
                        $grand_total += $addon_line_total;

                        OrderItemAddon::create([
                            'order_item_id' => $orderItem->id,
                            'addon_id' => $addon->id,
                            'addon_name' => $fullAddonName,
                            'addon_price' => $addon_line_total
                        ]);
                    }
                }
            }
        }

        // Commit totals dynamically
        $order->update([
            'subtotal' => $grand_total, 
            'grand_total' => $grand_total
        ]);

        return $order;
    }
}
