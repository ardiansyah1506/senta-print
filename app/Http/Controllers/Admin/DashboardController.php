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
        // 1. Core Summary Stats
        $totalOrders = Order::count();
        
        // Active orders: pending, designing, cutting, sewing, sablon, finishing, qc, in_progress, production
        $activeOrders = Order::whereIn('status', [
            'pending', 'designing', 'cutting', 'sewing', 'sablon', 'finishing', 'qc', 'production', 'in_progress'
        ])->count();
        
        $completedOrders = Order::where('status', 'completed')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();

        // Revenue calculation (excluding rejected)
        $totalRevenue = Order::where('status', '!=', 'rejected')->sum('grand_total');

        // Revenue Target (Default to monthly target or 50,000,000)
        $monthlyTargetObj = Target::where('type', 'monthly')->first();
        $targetRevenue = $monthlyTargetObj ? $monthlyTargetObj->target_amount : 50000000;
        $targetPercentage = $targetRevenue > 0 ? min(100, round(($totalRevenue / $targetRevenue) * 100, 1)) : 0;

        // 2. Status Breakdown (Last 7 Days / Current distribution)
        $statusBreakdown = [
            'pending' => Order::where('status', 'pending')->count(),
            'production' => Order::whereIn('status', ['production', 'designing', 'cutting', 'sewing', 'sablon', 'finishing', 'qc', 'in_progress'])->count(),
            'completed' => $completedOrders,
            'rejected' => $rejectedOrders,
        ];

        // 3. Quick Stats
        $totalItemsProduced = OrderItem::sum('qty');
        $activeCustomers = Customer::count();
        $pendingConfirmation = Order::where('status', 'pending')->count();

        // 4. Recent Orders (Latest 5)
        $recentOrders = Order::with(['customer', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'activeOrders',
            'completedOrders',
            'rejectedOrders',
            'totalRevenue',
            'targetRevenue',
            'targetPercentage',
            'statusBreakdown',
            'totalItemsProduced',
            'activeCustomers',
            'pendingConfirmation',
            'recentOrders'
        ));
    }
}
