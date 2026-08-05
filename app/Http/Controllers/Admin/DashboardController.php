<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Target;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();

        $prevMonthStart = $now->copy()->subMonth()->startOfMonth();
        $prevMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // 1. Total Orders & Month-over-Month Growth
        $totalOrders = Order::count();
        $ordersThisMonth = Order::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $ordersPrevMonth = Order::whereBetween('created_at', [$prevMonthStart, $prevMonthEnd])->count();
        
        if ($ordersPrevMonth > 0) {
            $ordersGrowth = round((($ordersThisMonth - $ordersPrevMonth) / $ordersPrevMonth) * 100, 1);
        } else {
            $ordersGrowth = $ordersThisMonth > 0 ? 100 : 0;
        }

        // 2. Active Orders (in progress)
        $activeOrders = Order::whereIn('status', [
            'pending', 'designing', 'cutting', 'sewing', 'sablon', 'finishing', 'qc', 'production', 'in_progress'
        ])->orWhereNull('status')->count();

        // 3. Completed Orders & Growth
        $completedOrders = Order::whereIn('status', ['completed', 'selesai', 'shipped'])->count();
        $completedThisMonth = Order::whereIn('status', ['completed', 'selesai', 'shipped'])
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $completedPrevMonth = Order::whereIn('status', ['completed', 'selesai', 'shipped'])
            ->whereBetween('created_at', [$prevMonthStart, $prevMonthEnd])->count();

        if ($completedPrevMonth > 0) {
            $completedGrowth = round((($completedThisMonth - $completedPrevMonth) / $completedPrevMonth) * 100, 1);
        } else {
            $completedGrowth = $completedThisMonth > 0 ? 100 : 0;
        }

        $rejectedOrders = Order::whereIn('status', ['rejected', 'batal', 'cancelled'])->count();

        // 4. Revenue Calculation (Excluding rejected)
        $totalRevenue = Order::whereNotIn('status', ['rejected', 'batal', 'cancelled'])->sum('grand_total');

        // Revenue Target (Monthly Target)
        $monthlyTargetObj = Target::where('type', 'monthly')->first();
        $targetRevenue = $monthlyTargetObj ? $monthlyTargetObj->target_amount : 50000000;
        $targetPercentage = $targetRevenue > 0 ? min(100, round(($totalRevenue / $targetRevenue) * 100, 1)) : 0;

        // 5. Status Breakdown
        $statusBreakdown = [
            'pending' => Order::whereIn('status', ['pending'])->orWhereNull('status')->count(),
            'production' => Order::whereIn('status', ['production', 'designing', 'cutting', 'sewing', 'sablon', 'finishing', 'qc', 'in_progress'])->count(),
            'completed' => $completedOrders,
            'rejected' => $rejectedOrders,
        ];

        // 6. Quick Stats
        $totalItemsProduced = OrderItem::sum('qty');
        $activeCustomers = Customer::count();
        $pendingConfirmation = Order::whereIn('status', ['pending'])->orWhereNull('status')->count();
        $ordersToday = Order::whereDate('created_at', date('Y-m-d'))->count();

        // 7. Recent Orders (Latest 5)
        $recentOrders = Order::with(['customer', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'ordersGrowth',
            'activeOrders',
            'completedOrders',
            'completedGrowth',
            'rejectedOrders',
            'totalRevenue',
            'targetRevenue',
            'targetPercentage',
            'statusBreakdown',
            'totalItemsProduced',
            'activeCustomers',
            'pendingConfirmation',
            'ordersToday',
            'recentOrders'
        ));
    }
}
