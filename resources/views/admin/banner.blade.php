@extends('layouts.admin')
@section('title', 'Banner Promosi')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Banner Promosi</h2>
            <p class="text-gray-500 font-medium text-sm">Kelola foto banner untuk pop-up promosi di halaman publik.</p>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h3 class="text-lg font-extrabold text-gray-900 mb-4 border-b border-gray-100 pb-3">Upload Banner Baru</h3>
        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-center">
            @csrf
            <div class="flex-1 w-full relative group">
                <input type="file" name="photo" accept="image/*" required
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('fileNameLabel').innerText = this.files.length > 0 ? this.files[0].name : 'Pilih File Foto (Maks 2MB)'">
                <div class="w-full border-2 border-dashed border-gray-300 group-hover:border-brand-blue group-hover:bg-indigo-50/50 rounded-2xl p-4 flex items-center justify-center gap-3 transition">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-brand-blue shrink-0">
                        <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                    </div>
                    <div>
                        <p id="fileNameLabel" class="text-sm font-extrabold text-gray-700">Pilih File Foto (Maks 2MB)</p>
                        <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Format JPG/PNG/WEBP didukung</p>
                    </div>
                </div>
            </div>
            <button type="submit" class="bg-brand-blue w-full md:w-auto text-white px-8 py-4 rounded-2xl font-extrabold shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)] hover:bg-indigo-700 hover:shadow-lg transition flex items-center justify-center shrink-0">
                Upload Banner
            </button>
        </form>
    </div>

    <!-- Active Banner Notice -->
    @php $activeBanner = $banners->where('is_active', true)->first(); @endphp
    @if($activeBanner)
    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 flex flex-col md:flex-row items-center gap-6">
        <div class="shrink-0 relative group">
            <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-extrabold px-2 py-1 rounded-md uppercase tracking-wider shadow-sm z-10">Aktif</span>
            <img src="{{ asset('storage/'.$activeBanner->photo) }}" class="h-32 w-48 object-cover rounded-xl shadow-sm border border-white" alt="Active Banner">
        </div>
        <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h4 class="text-green-800 font-extrabold text-lg mb-1"><i class="fa-solid fa-circle-check mr-2"></i> Banner Sedang Aktif</h4>
                <p class="text-green-700 text-sm font-medium">Ini adalah promo utama yang saat ini ditampilkan dalam bentuk pop-up saat Customer pertama kali mengunjungi katalog.</p>
            </div>
            <form action="{{ route('admin.banner.deactivate', $activeBanner->id) }}" method="POST">
                @csrf
                <button type="submit" class="shrink-0 bg-white border border-red-200 text-red-600 hover:bg-red-50 hover:text-red-700 font-extrabold text-xs px-4 py-2 rounded-xl transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-power-off"></i> Nonaktifkan
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Data List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h3 class="text-lg font-extrabold text-gray-900 mb-6 border-b border-gray-100 pb-3">Semua Banner Tersimpan</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($banners as $item)
            <div class="group relative bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <!-- Image Wrapper -->
                <div class="relative h-48 bg-gray-200">
                    <img src="{{ asset('storage/'.$item->photo) }}" alt="Banner {{ $item->id }}" class="w-full h-full object-cover">
                    <!-- Overlay Actions -->
                    <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-4 gap-3">
                        @if(!$item->is_active)
                        <form action="{{ route('admin.banner.activate', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-white text-green-600 w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-50 hover:scale-110 transition shadow-lg" title="Aktifkan">
                                <i class="fa-solid fa-power-off"></i>
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.banner.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-white text-red-500 w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-50 hover:scale-110 transition shadow-lg" title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Banner Meta -->
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-bold mb-0.5">Uploaded</p>
                        <p class="text-sm font-extrabold text-gray-800">{{ $item->created_at->format('d M Y') }}</p>
                    </div>
                    @if($item->is_active)
                    <span class="bg-green-100 text-green-700 font-extrabold text-[10px] px-2 py-1 rounded-md uppercase tracking-wider"><i class="fa-solid fa-check mr-1"></i> Aktif</span>
                    @else
                    <span class="bg-gray-200 text-gray-500 font-semibold text-[10px] px-2 py-1 rounded-md">Draft</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                    <i class="fa-regular fa-images text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada banner</h3>
                <p class="text-gray-500 text-sm">Upload foto promosi Anda di form atas.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
