@extends('layouts.admin')
@section('content')
            <div class="max-w-6xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-8">
                    <a href="{{ route('admin.master-kategori.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-brand-blue transition mb-4">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Daftar Kategori : {{ $category->name }}</h1>
                    <p class="text-gray-500 text-sm font-medium">Kelola konfigurasi produk, Add On, dan ukuran beserta harganya</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Produk</p>
                            <p class="text-3xl font-extrabold text-gray-900">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i class="fa-solid fa-cart-shopping text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Add On</p>
                            <p class="text-3xl font-extrabold text-gray-900">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-puzzle-piece text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Ukuran</p>
                            <p class="text-3xl font-extrabold text-gray-900">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                            <i class="fa-solid fa-ruler-combined text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- section 1: Daftar Produk -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-extrabold text-gray-900">Daftar Produk</h2>
                        <button class="bg-brand-blue text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm shadow-indigo-200">
                            <i class="fa-solid fa-plus text-xs"></i> Tambah Produk
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Dasar</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                
                                <tr><td colspan="4" class="py-6 text-center text-gray-400">Belum ada produk.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                    <!-- section 2: Daftar Ukuran -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <h2 class="text-lg font-extrabold text-gray-900">Daftar Ukuran</h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.master-kategori.syncSizes', $category->id) }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Ukuran Tersedia (Bisa Pilih Banyak) <span class="text-red-500">*</span></label>
                                    <select multiple name="sizes[]" class="w-full border border-gray-200 rounded-xl p-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white min-h-[150px]">
                                        @foreach($allSizes as $size)
                                            <option value="{{ $size->id }}" class="p-2 border-b border-gray-50 last:border-0 hover:bg-brand-bluelight rounded" {{ $category->sizes->contains($size->id) ? 'selected' : '' }}>
                                                {{ $size->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-400 mt-1.5 font-medium"><i class="fa-solid fa-circle-info mr-1"></i> Tahan tombol Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu ukuran.</p>
                                </div>
                                <button type="submit" class="bg-brand-blue text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-sm shadow-indigo-200 w-full sm:w-auto">
                                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Pilihan Ukuran
                                </button>
                            </form>
                        </div>
                    </div>

                <!-- section 3: Daftar Add On -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden pb-4">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                            <h2 class="text-lg font-extrabold text-gray-900">Daftar Add On</h2>
                        </div>
                        
                        <!-- Form Tambah Add On -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
                            <form action="{{ route('admin.master-kategori.addAddon', $category->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end">
                                @csrf
                                <div class="w-full sm:flex-1">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Pilih Add On</label>
                                    <div class="relative">
                                        <select name="addon_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white appearance-none transition shadow-sm">
                                            <option value="">-- Pilih Add On --</option>
                                            @foreach($allAddons as $addon)
                                                <option value="{{ $addon->id }}">{{ $addon->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                </div>
                                <div class="w-full sm:w-48">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Harga Tambahan (Rp)</label>
                                    <input type="number" name="price" required min="0" placeholder="0" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition shadow-sm">
                                </div>
                                <button type="submit" class="bg-brand-blue text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm w-full sm:w-auto h-10 border border-transparent">
                                    Tambahkan
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Add On</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Harga Tambahan</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                @forelse($category->addons as $catAddon)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">{{ $catAddon->name }}</td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($catAddon->pivot->price, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <form action="{{ route('admin.master-kategori.removeAddon', [$category->id, $catAddon->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus Add On dari kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="py-6 text-center text-gray-400 font-semibold text-xs">Belum ada Add On yang ditautkan ke kategori ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
@endsection
