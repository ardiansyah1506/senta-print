<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.master-kategori', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        Category::create($validated);
        return back()->with('success', 'Kategori ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with(['sizes', 'addons', 'products'])->findOrFail($id);
        $allSizes = \App\Models\Size::all();
        $allAddons = \App\Models\Addon::all();
        return view('admin.show-master-kategori', compact('category', 'allSizes', 'allAddons'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Kategori dihapus!');
    }

    public function syncSizes(Request $request, string $id) {
        $category = Category::findOrFail($id);
        $category->sizes()->sync($request->sizes ?? []);
        return back()->with('success', 'Ukuran kategori diperbarui.');
    }

    public function addAddon(Request $request, string $id) {
        $category = Category::findOrFail($id);
        $category->addons()->attach($request->addon_id, [
            'price' => $request->price ?? 0,
            'display_order' => 0
        ]);
        return back()->with('success', 'Add On ditambahkan ke kategori ini.');
    }

    public function removeAddon(string $id, string $addon_id) {
        $category = Category::findOrFail($id);
        $category->addons()->detach($addon_id);
        return back()->with('success', 'Add On dihapus dari kategori.');
    }
}
