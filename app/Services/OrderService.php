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
    public function generateInvoiceNo()
    {
        $todayDateStr = date('dmY');
        $prefix = "INV-{$todayDateStr}-";

        $todayCount = Order::whereDate('created_at', date('Y-m-d'))->count();
        $seq = $todayCount + 1;
        $invoiceNo = $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);

        while (Order::where('invoice_no', $invoiceNo)->exists()) {
            $seq++;
            $invoiceNo = $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
        }

        return $invoiceNo;
    }

    public function createOrder(Request $request, $customerId, $invoicePrefix = 'INV-')
    {
        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            throw new \Exception('Keranjang pesanan tidak boleh kosong.');
        }

        // Initialize Order object
        $order = Order::create([
            'customer_id' => $customerId,
            'invoice_no' => $this->generateInvoiceNo(),
            'subtotal' => 0,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 0,
            'payment_status' => 'PENDING',
        ]);

        $grand_total = 0;
        
        // Loop through cart items
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;
            
            // Manage uploaded design file per item
            $designFilePath = null;
            if ($request->hasFile("design_files.{$item['id']}")) {
                $file = $request->file("design_files.{$item['id']}");
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $file->storeAs('designs', $fileName, 'public');
                $designFilePath = 'designs/' . $fileName;
            }

            // Calculate total quantity for this cart item to determine tiered unit price
            $sizes = $item['sizes'] ?? [];
            $totalItemQty = array_sum($sizes);
            $unitPrice = $product->getPriceForQty($totalItemQty > 0 ? $totalItemQty : 1);
            if ($unitPrice <= 0 && isset($item['base_price'])) {
                $unitPrice = (float) $item['base_price'];
            }

            $sizeAddonsMap = $item['size_addons'] ?? [];

            // Distribute Order items per size explicitly allocated
            foreach ($sizes as $sizeId => $totalSizeQty) {
                if ($totalSizeQty <= 0) continue;
                
                $size = Size::find($sizeId);
                if (!$size) continue;
                
                $addonsForThisSize = $sizeAddonsMap[$sizeId] ?? [];

                if (!empty($addonsForThisSize)) {
                    // Calculate the max addon qty requested for this size
                    $maxAddonQty = 0;
                    foreach ($addonsForThisSize as $addonData) {
                        if (isset($addonData['qty']) && (int)$addonData['qty'] > $maxAddonQty) {
                            $maxAddonQty = (int)$addonData['qty'];
                        }
                    }
                    $maxAddonQty = min($totalSizeQty, $maxAddonQty > 0 ? $maxAddonQty : $totalSizeQty);
                    $qtyWithoutAddon = $totalSizeQty - $maxAddonQty;

                    // 1. Create OrderItem for portion WITH addons
                    if ($maxAddonQty > 0) {
                        $itemTotal = $unitPrice * $maxAddonQty;
                        $orderItemWithAddon = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'product_name' => $product->product_name,
                            'qty' => $maxAddonQty,
                            'size_id' => $sizeId,
                            'size_name' => $size->name,
                            'base_price' => $unitPrice,
                            'unit_price' => $unitPrice,
                            'total_price' => $itemTotal,
                            'notes' => $request->notes ?? '',
                            'design_file' => $designFilePath,
                        ]);
                        $grand_total += $itemTotal;

                        foreach ($addonsForThisSize as $addonPayload) {
                            $addon = Addon::find($addonPayload['id']);
                            if (!$addon) continue;
                            
                            $qtyAddon = $addonPayload['qty'] ?? $maxAddonQty;
                            $addonType = $addonPayload['type'] ?? 'add';
                            $fullAddonName = ($addonType === 'subtract' ? '[-] ' : '') . $addon->name . " ({$qtyAddon} pcs pada {$size->name})";
                            
                            $addon_line_total = ($addonPayload['price'] ?? 0) * $qtyAddon;
                            $storedAddonPrice = ($addonType === 'subtract') ? -$addon_line_total : $addon_line_total;

                            $grand_total += $storedAddonPrice;

                            OrderItemAddon::create([
                                'order_item_id' => $orderItemWithAddon->id,
                                'addon_id' => $addon->id,
                                'addon_name' => $fullAddonName,
                                'addon_price' => $storedAddonPrice
                            ]);
                        }
                    }

                    // 2. Create OrderItem for portion WITHOUT addons (if remaining qty exists)
                    if ($qtyWithoutAddon > 0) {
                        $itemTotalNoAddon = $unitPrice * $qtyWithoutAddon;
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'product_name' => $product->product_name,
                            'qty' => $qtyWithoutAddon,
                            'size_id' => $sizeId,
                            'size_name' => $size->name,
                            'base_price' => $unitPrice,
                            'unit_price' => $unitPrice,
                            'total_price' => $itemTotalNoAddon,
                            'notes' => $request->notes ?? '',
                            'design_file' => $designFilePath,
                        ]);
                        $grand_total += $itemTotalNoAddon;
                    }

                } else {
                    // Standard single OrderItem creation when no addons for this size
                    $item_total = $unitPrice * $totalSizeQty;
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'qty' => $totalSizeQty,
                        'size_id' => $sizeId,
                        'size_name' => $size->name,
                        'base_price' => $unitPrice,
                        'unit_price' => $unitPrice,
                        'total_price' => $item_total,
                        'notes' => $request->notes ?? '',
                        'design_file' => $designFilePath,
                    ]);
                    
                    $grand_total += $item_total;

                    // Fallback for global item addons (legacy compatibility)
                    if (!empty($item['addons'])) {
                        foreach ($item['addons'] as $addonPayload) {
                            $addon = Addon::find($addonPayload['id']);
                            if (!$addon) continue;
                            
                            $qtyAddon = $addonPayload['qty'] ?? 1;
                            $addonType = $addonPayload['type'] ?? 'add';
                            $fullAddonName = ($addonType === 'subtract' ? '[-] ' : '') . $addon->name;
                            if (isset($addonPayload['qty'])) {
                                $fullAddonName .= " ({$qtyAddon} pcs" . (isset($addonPayload['size_name']) ? " pada {$addonPayload['size_name']}" : "") . ")";
                            }

                            $addon_line_total = ($addonPayload['price'] ?? 0) * $qtyAddon;
                            $storedAddonPrice = ($addonType === 'subtract') ? -$addon_line_total : $addon_line_total;

                            $grand_total += $storedAddonPrice;

                            OrderItemAddon::create([
                                'order_item_id' => $orderItem->id,
                                'addon_id' => $addon->id,
                                'addon_name' => $fullAddonName,
                                'addon_price' => $storedAddonPrice
                            ]);
                        }
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
