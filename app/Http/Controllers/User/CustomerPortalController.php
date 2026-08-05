<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Customer;
use App\Models\ProductionStep;
use App\Services\OrderService;

class CustomerPortalController extends Controller
{
    public function createOrder() {
        $categories = Category::with(['products.prices', 'sizes', 'addons'])->get();
        return view('user.buat-pesanan', compact('categories'));
    }
    
    public function storeOrder(Request $request, OrderService $orderService) {
        $request->validate([
            'deadline' => 'nullable|date',
            'notes' => 'nullable|string',
            'cart' => 'required|string',
        ]);
        
        try {
            $user = auth()->user();
            $rawPhone = trim($user->phone ?? '');
            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);

            $customerQuery = Customer::where(function($q) use ($user, $rawPhone, $cleanPhone) {
                if ($rawPhone) $q->where('phone', $rawPhone);
                if ($cleanPhone) $q->orWhere('phone', $cleanPhone);
                $q->orWhere('name', $user->name);
            });

            $customer = $customerQuery->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $user->name,
                    'phone' => $user->phone ?? '081380069798',
                ]);
            }

            $order = $orderService->createOrder($request, $customer->id, 'INV-ST-');
            return redirect()->route('user.order.history')->with('success', 'Pesanan berhasil dibuat! Nomor Invoice Anda: ' . $order->invoice_no);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    private function getCustomerOrders(Request $request, bool $onlyCompleted = false) {
        $user = auth()->user();
        if (!$user) {
            return [collect(), ''];
        }

        $rawPhone = trim($user->phone ?? '');
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);

        $customerIds = Customer::where(function($q) use ($user, $rawPhone, $cleanPhone) {
            if ($rawPhone) $q->where('phone', $rawPhone);
            if ($cleanPhone) $q->orWhere('phone', $cleanPhone);
            $q->orWhere('name', $user->name);
        })->pluck('id');

        $search = trim($request->input('search', ''));

        $ordersQuery = Order::with(['customer', 'items.product', 'production.logs'])
            ->whereIn('customer_id', $customerIds);

        if ($search) {
            $ordersQuery->where(function($q) use ($search) {
                $q->where('invoice_no', 'LIKE', "%{$search}%")
                  ->orWhere('payment_status', 'LIKE', "%{$search}%")
                  ->orWhereHas('items', function($iq) use ($search) {
                      $iq->where('product_name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $orders = $ordersQuery->latest()->get();

        $totalMasterSteps = ProductionStep::count();
        if ($totalMasterSteps == 0) $totalMasterSteps = 1;

        foreach ($orders as $order) {
            $order->total_qty = $order->items->sum('qty');

            $productNames = $order->items->pluck('product_name')->unique()->filter()->values();
            if ($productNames->isNotEmpty()) {
                $order->products_summary = $productNames->join(', ');
            } else {
                $order->products_summary = 'Pesanan Custom';
            }

            if (in_array(strtolower($order->status ?? ''), ['completed', 'selesai', 'shipped'])) {
                $order->progress_percent = 100;
            } elseif (in_array(strtolower($order->status ?? ''), ['cancelled', 'batal', 'rejected'])) {
                $order->progress_percent = 0;
            } else {
                $completedLogsCount = 0;
                if ($order->production && $order->production->logs) {
                    $completedLogsCount = $order->production->logs->pluck('production_step_id')->unique()->count();
                }
                $calculated = round(($completedLogsCount / $totalMasterSteps) * 100);
                $order->progress_percent = max(5, min(95, $calculated));
            }
        }

        if ($onlyCompleted) {
            $orders = $orders->filter(function($order) {
                return $order->progress_percent == 100 
                    || in_array(strtolower($order->status ?? ''), ['completed', 'selesai', 'shipped'])
                    || in_array(strtoupper($order->payment_status ?? ''), ['PAID', 'LUNAS']);
            })->values();
        }

        return [$orders, $search];
    }

    public function trackOrder(Request $request) {
        [$orders, $search] = $this->getCustomerOrders($request, false);
        return view('user.lacak-pesanan', compact('orders', 'search'));
    }

    public function orderHistory(Request $request) {
        [$orders, $search] = $this->getCustomerOrders($request, true);
        return view('user.riwayat-pesanan', compact('orders', 'search'));
    }
}
