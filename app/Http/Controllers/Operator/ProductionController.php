<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index() { 
        $orders = \App\Models\Order::whereIn('status', ['production'])
            ->with(['customer', 'items.product', 'production.logs'])
            ->latest()
            ->paginate(10);
        
        $totalSteps = \App\Models\ProductionStep::count();
        if ($totalSteps == 0) $totalSteps = 6;
        
        return view('operator.kelolaproduksi', compact('orders', 'totalSteps')); 
    }

    public function tracking($id) {
        $order = \App\Models\Order::with(['customer', 'items.product', 'production.logs.step'])->findOrFail($id);
        $steps = \App\Models\ProductionStep::orderBy('sort_order')->get();
        return view('operator.tracking', compact('order', 'steps')); 
    }

    public function storeLog(Request $request, $id) {
        $order = \App\Models\Order::findOrFail($id);
        
        $production = $order->production()->firstOrCreate(
            ['order_id' => $order->id],
            ['started_at' => now()]
        );
        
        $production->logs()->create([
            'production_step_id' => $request->production_step_id,
            'notes' => $request->notes,
            'created_by' => auth()->id() ?? 1,
            'status' => 'completed'
        ]);

        return back()->with('success', 'Progress diperbarui.');
    }
}
