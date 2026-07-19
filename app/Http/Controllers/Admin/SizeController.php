<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->paginate(10);
        return view('admin.master-ukuran', compact('sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        Size::create($validated);
        return back()->with('success', 'Ukuran berhasil ditambahkan!');
    }

    public function destroy(string $id)
    {
        Size::findOrFail($id)->delete();
        return back()->with('success', 'Ukuran berhasil dihapus!');
    }

    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
}
