<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductionStep;

class ProductionController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');
        $statusFilter = $request->input('status', 'all');
        $timeFilter = $request->input('time_filter', 'all');

        $query = Order::with(['customer', 'items.product', 'production.logs']);
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($timeFilter !== 'all') {
            $now = \Carbon\Carbon::now();
            if ($timeFilter === 'today') {
                $query->whereDate('created_at', $now->toDateString());
            } elseif ($timeFilter === 'week') {
                $query->whereBetween('created_at', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
            } elseif ($timeFilter === 'month') {
                $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
            } elseif ($timeFilter === 'year') {
                $query->whereYear('created_at', $now->year);
            }
        }

        $orders = $query->latest()->paginate(8)->withQueryString();
        $totalSteps = ProductionStep::count();
        
        return view('operator.kelolaproduksi', compact('orders', 'totalSteps', 'search', 'statusFilter', 'timeFilter')); 
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
            'production_step_id' => 'required|exists:m_production_steps,id',
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

        $step = ProductionStep::findOrFail($request->production_step_id);

        $log = $production->logs()->updateOrCreate(
            ['production_step_id' => $step->id],
            [
                'notes' => trim($request->notes),
                'created_by' => auth()->id() ?? 1,
                'status' => $request->status
            ]
        );

        if ($request->hasFile('photos')) {
            // Delete old photos if any
            if ($log->photos()->count() > 0) {
                foreach ($log->photos as $oldPhoto) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPhoto->file_path)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPhoto->file_path);
                    }
                    $oldPhoto->delete();
                }
            }

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
        $completedStepIds = array_unique($production->logs()->where('status', 'completed')->pluck('production_step_id')->toArray());
        
        if (count($completedStepIds) >= $allSteps->count()) {
            $order->status = 'completed';
            $order->save();
        }

        $msg = $request->status === 'completed' ? 'Selesai!' : 'Diperbarui!';
        return back()->with('success', 'Tahap "' . $step->name . '" berhasil ' . $msg);
    }
    
    public function confirmPayment($id) {
        $order = Order::findOrFail($id);
        $order->payment_status = 'PAID';
        $order->save();
        return back()->with('success', 'Pesanan ini ('.$order->invoice_no.') telah berhasil dikonfirmasi Lunas.');
    }
}
