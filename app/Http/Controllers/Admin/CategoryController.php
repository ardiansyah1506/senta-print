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
        $category = Category::with(['sizes', 'addons', 'products.prices'])->findOrFail($id);
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
        
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Ukuran diperbarui via AJAX.']);
        }

        return back()->with('success', 'Ukuran kategori diperbarui.');
    }

    public function addAddon(Request $request, string $id) {
        $category = Category::findOrFail($id);
        $type = in_array($request->type, ['add', 'subtract']) ? $request->type : 'add';
        $category->addons()->attach($request->addon_id, [
            'price' => $request->price ?? 0,
            'type' => $type,
            'display_order' => 0
        ]);
        return back()->with('success', 'Add On ditambahkan ke kategori ini.');
    }

    public function removeAddon(string $id, string $addon_id) {
        $category = Category::findOrFail($id);
        $category->addons()->detach($addon_id);
        return back()->with('success', 'Add On dihapus dari kategori.');
    }

    public function uploadSizeChart(Request $request, string $id) {
        $category = Category::findOrFail($id);
        $request->validate(['size_chart' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        if ($request->hasFile('size_chart')) {
            // Delete old file if exists
            if ($category->size_chart) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->size_chart);
            }
            $path = $request->file('size_chart')->store('size_charts', 'public');
            $category->update(['size_chart' => $path]);
        }
        return back()->with('success', 'Size chart berhasil diunggah.');
    }

    public function removeSizeChart(string $id) {
        $category = Category::findOrFail($id);
        if ($category->size_chart) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($category->size_chart);
            $category->update(['size_chart' => null]);
        }
        return back()->with('success', 'Size chart berhasil dihapus.');
    }

    public function addProduct(Request $request, string $id) {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:50',
        ]);
        
        $category->products()->create([
            'product_code' => $validated['product_code'],
            'product_name' => $validated['product_name']
        ]);

        return back()->with('success', 'Produk ditambahkan. Silakan atur harga bertingkat untuk produk ini.');
    }

    public function removeProduct(string $id, string $product_id) {
        $category = Category::findOrFail($id);
        $category->products()->findOrFail($product_id)->delete();
        return back()->with('success', 'Produk dihapus.');
    }

    public function addProductPrice(Request $request, string $id, string $product_id) {
        $category = Category::findOrFail($id);
        $product = $category->products()->findOrFail($product_id);
        
        $validated = $request->validate([
            'min_qty' => 'required|integer|min:1',
            'max_qty' => 'nullable|integer|gte:min_qty',
            'price' => 'required|numeric|min:0'
        ]);

        $product->prices()->create([
            'min_qty' => $validated['min_qty'],
            'max_qty' => $validated['max_qty'] ?? null,
            'price' => $validated['price']
        ]);

        return back()->with('success', 'Harga bertingkat berhasil ditambahkan.')->with('open_product_price_modal_id', $product_id);
    }

    public function removeProductPrice(string $id, string $product_id, string $price_id) {
        $category = Category::findOrFail($id);
        $product = $category->products()->findOrFail($product_id);
        $product->prices()->findOrFail($price_id)->delete();
        return back()->with('success', 'Harga bertingkat dihapus.')->with('open_product_price_modal_id', $product_id);
    }
}
