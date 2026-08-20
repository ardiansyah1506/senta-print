@extends('layouts.admin')
@section('title', 'Detail Kategori: ' . $category->name)
@section('parent_title', 'Master Kategori')
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
                            <p class="text-3xl font-extrabold text-gray-900">{{ $category->products->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i class="fa-solid fa-cart-shopping text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Add On</p>
                            <p class="text-3xl font-extrabold text-gray-900">{{ $category->addons->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-puzzle-piece text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Ukuran</p>
                            <p class="text-3xl font-extrabold text-gray-900">{{ $category->sizes->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                            <i class="fa-solid fa-ruler-combined text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- section 1: Daftar Produk -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 pb-4">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                            <h2 class="text-lg font-extrabold text-gray-900">Daftar Produk</h2>
                        </div>
                        
                        <!-- Form Tambah Produk -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
                            <form action="{{ route('admin.master-kategori.addProduct', $category->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3 items-end">
                                @csrf
                                <div class="w-full sm:w-1/4">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Kode Produk</label>
                                    <input type="text" name="product_code" required placeholder="PRD-01" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition shadow-sm">
                                </div>
                                <div class="w-full sm:flex-1">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Nama Produk</label>
                                    <input type="text" name="product_name" required placeholder="Kaos Polos Cotton Combed 30s" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition shadow-sm">
                                </div>
                                <div class="w-full sm:w-1/4">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Foto Produk <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                    <input type="file" name="photo" accept="image/*" class="w-full border border-gray-200 rounded-lg text-[10px] sm:text-xs">
                                </div>
                                <button type="submit" class="bg-brand-blue text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-sm w-full sm:w-auto h-10 border border-transparent whitespace-nowrap">
                                    <i class="fa-solid fa-plus text-xs mr-1"></i> Tambah Produk
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Bertingkat (Tier Pricing)</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                @forelse($category->products as $product)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-brand-blue">{{ $product->product_code }}</td>
                                    <td class="py-4 px-6 text-gray-900 font-semibold">
                                        <div class="flex items-center gap-3">
                                            @if($product->photo)
                                                <img src="{{ asset('storage/' . $product->photo) }}" class="w-10 h-10 object-cover rounded-md border border-gray-100 shadow-sm">
                                            @else
                                                <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">
                                                    <i class="fa-solid fa-image"></i>
                                                </div>
                                            @endif
                                            <span>{{ $product->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-wrap gap-2 items-center">
                                            @if($product->prices->isNotEmpty())
                                                @foreach($product->prices as $priceTier)
                                                    <span class="inline-flex items-center bg-indigo-50 text-brand-blue border border-indigo-100 text-xs px-2.5 py-1 rounded-md font-bold">
                                                        @if($priceTier->max_qty)
                                                            {{ $priceTier->min_qty }} - {{ $priceTier->max_qty }} pcs: Rp {{ number_format($priceTier->price, 0, ',', '.') }}
                                                        @else
                                                            ≥ {{ $priceTier->min_qty }} pcs: Rp {{ number_format($priceTier->price, 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                @endforeach
                                                <button onclick="document.getElementById('modalHargaBertingkat_{{ $product->id }}').classList.remove('hidden')" class="text-xs text-brand-blue hover:text-indigo-800 font-bold underline ml-1 inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-gear text-[10px]"></i> Kelola
                                                </button>
                                            @else
                                                <button onclick="document.getElementById('modalHargaBertingkat_{{ $product->id }}').classList.remove('hidden')" class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200 hover:bg-amber-100 transition">
                                                    <i class="fa-solid fa-plus text-[10px]"></i> Set Harga Bertingkat
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Modal Kelola Harga Bertingkat -->
                                        <div id="modalHargaBertingkat_{{ $product->id }}" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center hidden opacity-100 transition-opacity backdrop-blur-sm whitespace-normal">
                                            <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-2xl mx-4 overflow-hidden border border-gray-100 text-left">
                                                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                                                    <div>
                                                        <h3 class="font-extrabold text-gray-900 text-base">Kelola Harga Bertingkat</h3>
                                                        <p class="text-xs text-gray-400 font-medium">Produk: <span class="text-brand-blue font-bold">{{ $product->product_name }}</span> ({{ $product->product_code }})</p>
                                                    </div>
                                                    <button onclick="document.getElementById('modalHargaBertingkat_{{ $product->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-900 transition w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                                
                                                <div class="p-6 space-y-6">
                                                    <!-- Form Tambah Tier Harga -->
                                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                                        <h4 class="text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-3">Tambah Rentang Harga Baru</h4>
                                                        <form action="{{ route('admin.master-kategori.addProductPrice', [$category->id, $product->id]) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                                                            @csrf
                                                            <div>
                                                                <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Min Qty <span class="text-red-500">*</span></label>
                                                                <input type="number" name="min_qty" required min="1" placeholder="1" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white">
                                                            </div>
                                                            <div>
                                                                <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Max Qty <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                                                <input type="number" name="max_qty" min="1" placeholder="Bebas" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white">
                                                            </div>
                                                            <div>
                                                                <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                                                                <input type="number" name="price" required min="0" placeholder="50000" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white">
                                                            </div>
                                                            <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm h-9 flex items-center justify-center gap-1">
                                                                <i class="fa-solid fa-plus text-[10px]"></i> Simpan Tier
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- Tabel Daftar Tier Harga Aktif -->
                                                    <div>
                                                        <h4 class="text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-3">Daftar Rentang Harga Aktif</h4>
                                                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                                                            <table class="w-full text-left border-collapse text-xs">
                                                                <thead>
                                                                    <tr class="bg-gray-50 border-b border-gray-100 font-bold text-gray-500 uppercase tracking-wider">
                                                                        <th class="py-3 px-4">Min Qty</th>
                                                                        <th class="py-3 px-4">Max Qty</th>
                                                                        <th class="py-3 px-4">Harga / Pcs</th>
                                                                        <th class="py-3 px-4 text-right">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-100 font-semibold text-gray-700">
                                                                    @forelse($product->prices as $priceTier)
                                                                    <tr class="hover:bg-gray-50/50">
                                                                        <td class="py-3 px-4 font-bold text-gray-900">{{ $priceTier->min_qty }} pcs</td>
                                                                        <td class="py-3 px-4">{{ $priceTier->max_qty ? $priceTier->max_qty . ' pcs' : 'Tak Terbatas (∞)' }}</td>
                                                                        <td class="py-3 px-4 font-bold text-brand-blue">Rp {{ number_format($priceTier->price, 0, ',', '.') }}</td>
                                                                        <td class="py-3 px-4 text-right">
                                                                            <form action="{{ route('admin.master-kategori.removeProductPrice', [$category->id, $product->id, $priceTier->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus rentang harga ini?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition w-7 h-7 rounded-md hover:bg-red-50 inline-flex items-center justify-center">
                                                                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="4" class="py-4 text-center text-gray-400">Belum ada harga bertingkat yang ditambahkan.</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('modalHargaBertingkat_{{ $product->id }}').classList.add('hidden')" class="px-5 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-100 transition text-xs font-bold">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <form action="{{ route('admin.master-kategori.removeProduct', [$category->id, $product->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-400">Belum ada produk.</td></tr>
                                @endforelse
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
                            
                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Ukuran Tersedia <span class="text-red-500">*</span></label>
                                <select id="size-select" multiple name="sizes[]" autocomplete="off" placeholder="Pilih ukuran..." class="hidden">
                                    @foreach($allSizes as $size)
                                        <option value="{{ $size->id }}" {{ $category->sizes->contains($size->id) ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-gray-400 mt-2 font-medium">Perubahan ukuran otomatis tersimpan ketika Anda menambah atau menghapus pilihan.</p>
                            </div>

                            <!-- Dropzone -->
                            <div class="mt-8 border-t border-gray-100 pt-6">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Size Chart Kategori <span class="text-gray-400 font-medium">(Opsional)</span></label>
                                
                                @error('size_chart')
                                    <div class="text-red-500 text-xs font-bold mb-2">{{ $message }}</div>
                                @enderror

                                @if($category->size_chart)
                                    <!-- Jika Foto Ada -->
                                    <div class="relative group rounded-xl border border-gray-200 overflow-hidden shadow-sm inline-block max-w-[300px]">
                                        <img src="{{ asset('storage/' . $category->size_chart) }}" class="max-w-full h-auto object-cover" alt="Size Chart">
                                        
                                        <!-- Overlay Hapus -->
                                        <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <form action="{{ route('admin.master-kategori.removeSizeChart', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-2" onsubmit="return confirm('Hapus size chart ini?');">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus Foto
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <!-- Jika Belum Ada Foto (Upload Form) -->
                                    <form action="{{ route('admin.master-kategori.uploadSizeChart', $category->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex items-center gap-3 w-full border-2 border-dashed border-gray-200 rounded-xl p-4 bg-gray-50/50 hover:bg-gray-50 transition relative overflow-hidden group">
                                            <input type="file" name="size_chart" onchange="this.form.submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer text-[0]" accept="image/*">
                                            <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 group-hover:text-brand-blue transition">
                                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-800 text-sm">Unggah Size Chart Baru (JPG, PNG)</h4>
                                                <p class="text-[10px] text-gray-500 font-medium pb-0.5">Tarik dan lepas file disini atau klik untuk memilih. File maksimal 2MB.</p>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>

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
                                <div class="w-full sm:w-44">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Tipe Harga</label>
                                    <div class="relative">
                                        <select name="type" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue bg-white appearance-none transition shadow-sm">
                                            <option value="add">+ Menambah</option>
                                            <option value="subtract">- Mengurangi</option>
                                        </select>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                </div>
                                <div class="w-full sm:w-44">
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Nominal (Rp)</label>
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
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tipe Harga</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Nominal</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                @forelse($category->addons as $catAddon)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">{{ $catAddon->name }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if(($catAddon->pivot->type ?? 'add') === 'subtract')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                <i class="fa-solid fa-minus mr-1"></i> Mengurangi (-)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                <i class="fa-solid fa-plus mr-1"></i> Menambah (+)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right font-semibold {{ ($catAddon->pivot->type ?? 'add') === 'subtract' ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ ($catAddon->pivot->type ?? 'add') === 'subtract' ? '-' : '+' }} Rp {{ number_format($catAddon->pivot->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <form action="{{ route('admin.master-kategori.removeAddon', [$category->id, $catAddon->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus Add On dari kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-400 font-semibold text-xs">Belum ada Add On yang ditautkan ke kategori ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- AJAX TomSelect Initialization -->
            <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.default.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
            <style>
                /* Tom Select Tailwind Adjustments */
                .ts-control { border-radius: 0.75rem !important; border-color: #e5e7eb !important; padding: 0.65rem 1rem !important; box-shadow: none !important; }
                .ts-control.focus { border-color: #4f46e5 !important; box-shadow: 0 0 0 1px #4f46e5 !important; }
                .ts-wrapper.multi .ts-control > div { background: #e0e7ff; color: #4f46e5; border-radius: 0.25rem; font-weight: 700; font-size: 0.75rem; border: none; padding: 0.25rem 0.5rem; }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    new TomSelect('#size-select', {
                        plugins: ['remove_button'],
                        create: false,
                        onChange: function(value) {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            
                            if (value && value.length > 0) {
                                value.forEach(id => formData.append('sizes[]', id));
                            } else {
                                formData.append('sizes', ''); // Empty state
                            }
                            
                            fetch('{{ route('admin.master-kategori.syncSizes', $category->id) }}', {
                                method: 'POST',
                                headers: { 'Accept': 'application/json' },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                console.log('AJAX Sync Sizes Status:', data);
                            })
                            .catch(err => console.error('Error Syncing Sizes:', err));
                        }
                    });
                });
            </script>
            @if(session('open_product_price_modal_id'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modalId = 'modalHargaBertingkat_' + '{{ session("open_product_price_modal_id") }}';
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                });
            </script>
            @endif
@endsection
