<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionStep;
use Illuminate\Http\Request;

class ProductionStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $steps = ProductionStep::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.master-tahap-produksi', compact('steps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (!isset($validated['sort_order']) || $validated['sort_order'] === null) {
            $maxOrder = ProductionStep::max('sort_order');
            $validated['sort_order'] = $maxOrder !== null ? $maxOrder + 1 : 1;
        }

        ProductionStep::create($validated);

        return back()->with('success', 'Tahap produksi berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $step = ProductionStep::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer|min:0',
        ]);

        $step->update($validated);

        return back()->with('success', 'Tahap produksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $step = ProductionStep::findOrFail($id);
        $step->delete();

        return back()->with('success', 'Tahap produksi berhasil dihapus!');
    }

    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
}
