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
                            <form action="{{ route('admin.master-kategori.addProduct', $category->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end">
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
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Harga Dasar (Rp)</label>
                                    <input type="number" name="base_price" required min="0" placeholder="0" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition shadow-sm">
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
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Dasar</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                @forelse($category->products as $product)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-brand-blue">{{ $product->product_code }}</td>
                                    <td class="py-4 px-6 text-gray-900 font-semibold">{{ $product->product_name }}</td>
                                    <td class="py-4 px-6">Rp {{ number_format($product->prices->first()->price ?? 0, 0, ',', '.') }}</td>
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
@endsection
