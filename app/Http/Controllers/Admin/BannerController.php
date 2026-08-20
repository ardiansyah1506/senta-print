<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = \App\Models\Banner::latest()->get();
        return view('admin.banner', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        $path = $request->file('photo')->store('banners', 'public');
        
        \App\Models\Banner::create([
            'photo' => $path
        ]);

        return redirect()->back()->with('success', 'Banner berhasil diupload!');
    }

    public function activate($id)
    {
        // Deactivate all
        \App\Models\Banner::query()->update(['is_active' => false]);
        
        // Activate chosen
        $banner = \App\Models\Banner::findOrFail($id);
        $banner->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Banner berhasil diaktifkan!');
    }

    public function deactivate($id)
    {
        $banner = \App\Models\Banner::findOrFail($id);
        $banner->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Banner berhasil dinonaktifkan! Pop-up tidak akan muncul.');
    }

    public function destroy($id)
    {
        $banner = \App\Models\Banner::findOrFail($id);
        
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($banner->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($banner->photo);
        }
        
        $banner->delete();

        return redirect()->back()->with('success', 'Banner berhasil dihapus!');
    }
}
