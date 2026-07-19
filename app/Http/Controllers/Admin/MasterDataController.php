<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Addon;
use App\Models\Size;

class MasterDataController extends Controller
{
    public function indexMaster() {
        $addons = Addon::latest()->paginate(10);
        return view('admin.data-master', compact('addons'));
    }

    public function storeAddon(Request $request) {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        Addon::create($validated);
        return back()->with('success', 'Add On berhasil ditambahkan!');
    }

    public function destroyAddon($id) {
        Addon::findOrFail($id)->delete();
        return back()->with('success', 'Add On berhasil dihapus!');
    }

    public function indexCategory() { 
        $categories = Category::latest()->paginate(10);
        return view('admin.master-kategori', compact('categories')); 
    }
    
    public function storeCategory(Request $request) {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        Category::create($validated);
        return back()->with('success', 'Kategori ditambahkan!');
    }

    public function showCategory() { return view('admin.show-master-kategori'); }
}
