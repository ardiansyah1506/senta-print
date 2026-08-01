<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request) {
        $startDateStr = $request->input('start_date');
        $endDateStr = $request->input('end_date');

        if ($startDateStr && $endDateStr) {
            $startDate = Carbon::parse($startDateStr)->startOfDay();
            $endDate = Carbon::parse($endDateStr)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // Fetch Orders within range
        $ordersQuery = Order::with(['customer', 'items.product'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        $allOrders = $ordersQuery->get();
        $totalOrdersCount = $allOrders->count();
        
        // Exclude rejected/cancelled for revenue? Let's say we only count non-rejected for revenue.
        $validOrders = $allOrders->where('status', '!=', 'rejected');
        
        $totalRevenue = $validOrders->sum('grand_total');
        $completedOrdersCount = $allOrders->where('status', 'completed')->count();
        $averageOrderValue = $validOrders->count() > 0 ? $totalRevenue / $validOrders->count() : 0;

        // Calculate Products popularity
        $productPopularity = [];
        foreach ($allOrders as $order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $name = $item->product->name;
                    if (!isset($productPopularity[$name])) {
                        $productPopularity[$name] = 0;
                    }
                    $productPopularity[$name] += $item->quantity;
                }
            }
        }
        arsort($productPopularity);
        $topProducts = array_slice($productPopularity, 0, 6, true);

        // Target calculation
        $daysCount = $startDate->diffInDays($endDate) + 1;
        
        $target = Target::where('start_date', $startDate->format('Y-m-d'))
            ->where('end_date', $endDate->format('Y-m-d'))
            ->first();

        $targetAmount = 0;
        
        if ($target) {
            $targetAmount = $target->target_amount;
        } else {
            $defaults = Target::whereNull('start_date')->get()->keyBy('type');
            
            if ($daysCount == 1) {
                if (isset($defaults['daily'])) $targetAmount = $defaults['daily']->target_amount;
                elseif (isset($defaults['monthly'])) $targetAmount = ($defaults['monthly']->target_amount / 30);
            } elseif ($daysCount == 7) {
                if (isset($defaults['weekly'])) $targetAmount = $defaults['weekly']->target_amount;
                elseif (isset($defaults['daily'])) $targetAmount = $defaults['daily']->target_amount * 7;
                elseif (isset($defaults['monthly'])) $targetAmount = ($defaults['monthly']->target_amount / 30) * 7;
            } elseif ($startDate->copy()->startOfMonth()->isSameDay($startDate) && $endDate->copy()->endOfMonth()->isSameDay($endDate)) {
                $monthsCount = $startDate->diffInMonths($endDate->copy()->addDay()); // diffInMonths needs the end date to be precisely 1 month apart, addDay ensures it counts full month
                if ($monthsCount == 0) $monthsCount = 1;
                
                if (isset($defaults['monthly'])) {
                    $targetAmount = $defaults['monthly']->target_amount * $monthsCount;
                } elseif (isset($defaults['daily'])) {
                    $targetAmount = $defaults['daily']->target_amount * $daysCount;
                }
            } elseif ($startDate->copy()->startOfYear()->isSameDay($startDate) && $endDate->copy()->endOfYear()->isSameDay($endDate)) {
                if (isset($defaults['yearly'])) $targetAmount = $defaults['yearly']->target_amount;
                elseif (isset($defaults['monthly'])) $targetAmount = $defaults['monthly']->target_amount * 12;
                elseif (isset($defaults['daily'])) $targetAmount = $defaults['daily']->target_amount * $daysCount;
            } else {
                if (isset($defaults['daily'])) {
                    $targetAmount = $defaults['daily']->target_amount * $daysCount;
                } elseif (isset($defaults['monthly'])) {
                    $targetAmount = ($defaults['monthly']->target_amount / 30) * $daysCount;
                } elseif (isset($defaults['yearly'])) {
                    $targetAmount = ($defaults['yearly']->target_amount / 365) * $daysCount;
                }
            }
        }

        $achievementPercentage = $targetAmount > 0 ? ($totalRevenue / $targetAmount) * 100 : 0;

        return view('admin.laporan', compact(
            'startDate',
            'endDate',
            'allOrders',
            'totalOrdersCount',
            'totalRevenue',
            'completedOrdersCount',
            'averageOrderValue',
            'topProducts',
            'targetAmount',
            'achievementPercentage',
            'target'
        ));
    }

    public function setTarget(Request $request) {
        $request->validate([
            'type' => 'required|string',
            'target_amount' => 'required|numeric|min:0'
        ]);

        if ($request->type === 'custom') {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date'
            ]);
            
            $target = Target::where('start_date', $request->start_date)
                ->where('end_date', $request->end_date)
                ->first();

            if ($target) {
                $target->update(['target_amount' => $request->target_amount]);
            } else {
                Target::create([
                    'type' => 'custom',
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'target_amount' => $request->target_amount
                ]);
            }
        } else {
            $target = Target::where('type', $request->type)->whereNull('start_date')->first();
            if ($target) {
                $target->update(['target_amount' => $request->target_amount]);
            } else {
                Target::create([
                    'type' => $request->type,
                    'start_date' => null,
                    'end_date' => null,
                    'target_amount' => $request->target_amount
                ]);
            }
        }

        return redirect()->back()->with('success', 'Target berhasil disimpan.');
    }
}
