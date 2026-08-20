<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductionStep;

class ProductionController extends Controller
{
    public function index() { 
        $orders = Order::whereIn('status', ['production'])
            ->with(['customer', 'items.product', 'production.logs'])
            ->latest()
            ->paginate(10);
        
        $totalSteps = ProductionStep::count();
        
        return view('operator.kelolaproduksi', compact('orders', 'totalSteps')); 
    }

    public function tracking($id) {
        $order = Order::with(['customer', 'items.product', 'production.logs.step', 'production.logs.photos'])->findOrFail($id);
        $allSteps = ProductionStep::orderBy('sort_order', 'asc')->get();
        
        $completedStepIds = [];
        if ($order->production && $order->production->logs) {
            $completedStepIds = array_unique($order->production->logs->where('status', 'completed')->pluck('production_step_id')->toArray());
        }

        // Determine next required step in sequential order
        $nextStep = $allSteps->first(function($step) use ($completedStepIds) {
            return !in_array($step->id, $completedStepIds);
        });

        $nextStepIndex = 1;
        if ($nextStep) {
            $nextStepIndex = $allSteps->search(function($s) use ($nextStep) {
                return $s->id == $nextStep->id;
            }) + 1;
        }

        return view('operator.tracking', compact('order', 'allSteps', 'completedStepIds', 'nextStep', 'nextStepIndex')); 
    }

    public function storeLog(Request $request, $id) {
        $request->validate([
            'notes' => 'required|string',
            'status' => 'required|in:progress,completed',
            'photos.*' => 'nullable|image|max:10240'
        ]);

        $order = Order::findOrFail($id);
        
        $production = $order->production()->firstOrCreate(
            ['order_id' => $order->id],
            ['started_at' => now()]
        );

        $allSteps = ProductionStep::orderBy('sort_order', 'asc')->get();
        if ($allSteps->isEmpty()) {
            return back()->with('error', 'Belum ada data Master Tahap Produksi.');
        }

        $completedStepIds = array_unique($production->logs()->where('status', 'completed')->pluck('production_step_id')->toArray());

        // Calculate expected next step in sequential order
        $nextStep = $allSteps->first(function($step) use ($completedStepIds) {
            return !in_array($step->id, $completedStepIds);
        });

        if (!$nextStep) {
            return back()->with('error', 'Seluruh tahap produksi untuk pesanan ini telah selesai.');
        }

        $log = $production->logs()->create([
            'production_step_id' => $nextStep->id,
            'notes' => trim($request->notes),
            'created_by' => auth()->id() ?? 1,
            'status' => $request->status
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile->isValid()) {
                    $fileName = time() . '_' . rand(100, 999) . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $photoFile->getClientOriginalName());
                    $photoFile->storeAs('production_photos', $fileName, 'public');
                    $log->photos()->create([
                        'file_path' => 'production_photos/' . $fileName
                    ]);
                }
            }
        }

        // Check if all steps are completed
        $updatedCompletedCount = count($completedStepIds);
        if ($request->status === 'completed') {
            $updatedCompletedCount++;
        }
        
        if ($updatedCompletedCount >= $allSteps->count()) {
            $order->status = 'completed';
            $order->save();
        }

        $msg = $request->status === 'completed' ? 'Selesai!' : 'Diperbarui!';
        return back()->with('success', 'Tahap "' . $nextStep->name . '" berhasil ' . $msg);
    }
}
