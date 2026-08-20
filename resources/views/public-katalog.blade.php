<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo-meta', [
        'title' => 'Katalog Produk Senta Print',
        'description' => 'Katalog lengkap produk konveksi Senta Print.',
        'keywords' => 'katalog, senta print, kaos, jaket, polo',
        'robots' => 'index, follow'
    ])
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo_mark.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">
    <!-- Navbar -->
    <x-public-navbar />
    
    <div class="pt-28 pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Katalog <span class="text-brand-600">Produk</span></h1>
            <p class="text-gray-500 text-lg">Pilih dari berbagai kategori produk konveksi yang kami sediakan</p>
        </div>

        @php
            $allProducts = [];
            foreach($categories as $cat) {
                foreach($cat->products as $p) {
                    $prices = $p->prices->map(function($pr) {
                        return [
                            'min' => $pr->min_qty,
                            'max' => $pr->max_qty,
                            'price' => number_format($pr->price, 0, ',', '.')
                        ];
                    })->values()->toArray();

                    $allProducts[] = [
                        'id' => $p->id,
                        'name' => $p->product_name,
                        'code' => $p->product_code,
                        'cat_id' => $cat->id,
                        'cat_name' => $cat->name,
                        'photo' => $p->photo ? asset('storage/' . $p->photo) : '',
                        'base_price' => number_format($p->prices->first()->price ?? 0, 0, ',', '.'),
                        'prices' => $prices
                    ];
                }
            }
        @endphp

        <div x-data="{ 
            activeTab: 'all', 
            products: {{ json_encode($allProducts) }},
            currentPage: 1,
            perPage: 10,
            showModal: false,
            modalData: {},
            
            get filteredProducts() {
                if (this.activeTab === 'all') return this.products;
                return this.products.filter(p => p.cat_id == this.activeTab);
            },
            get paginatedProducts() {
                let start = (this.currentPage - 1) * this.perPage;
                return this.filteredProducts.slice(start, start + this.perPage);
            },
            get totalPages() {
                return Math.ceil(this.filteredProducts.length / this.perPage);
            },
            changeTab(tab) {
                this.activeTab = tab;
                this.currentPage = 1;
            },
            openModal(product) {
                this.modalData = product;
                this.showModal = true;
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.showModal = false;
                setTimeout(() => { document.body.style.overflow = ''; }, 300);
            }
        }">
            
            <!-- Tabs Header (Pill Style) -->
            <div class="flex flex-wrap justify-center gap-3 mb-10 max-w-4xl mx-auto">
                <button type="button" @click="changeTab('all')" 
                        :class="activeTab === 'all' ? 'border-brand-600 text-brand-600 shadow-sm' : 'border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-2.5 border rounded-full font-bold text-sm transition-all duration-200 outline-none bg-white">
                    Semua Kategori
                </button>
                @foreach($categories as $cat)
                <button type="button" @click="changeTab('{{ $cat->id }}')" 
                        :class="activeTab === '{{ $cat->id }}' ? 'border-brand-600 text-brand-600 shadow-sm' : 'border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-2.5 border rounded-full font-bold text-sm transition-all duration-200 outline-none bg-white">
                    {{ $cat->name }}
                </button>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6" x-show="filteredProducts.length > 0">
                <template x-for="product in paginatedProducts" :key="product.id">
                    <button type="button" 
                       @click="openModal(product)"
                       x-transition:enter="transition ease-out duration-300"
                       x-transition:enter-start="opacity-0 scale-95"
                       x-transition:enter-end="opacity-100 scale-100"
                       class="w-full text-left bg-white rounded-3xl p-3 shadow-[0_2px_15px_-5px_rgba(0,0,0,0.1)] border border-gray-100 hover:-translate-y-1 hover:shadow-lg transition duration-300 group flex flex-col h-full">
                        <template x-if="product.photo">
                            <img :src="product.photo" class="w-full h-44 object-cover rounded-2xl mb-4 group-hover:scale-[1.02] transition-transform" :alt="product.name">
                        </template>
                        <template x-if="!product.photo">
                            <div class="w-full h-44 bg-gray-50 rounded-2xl mb-4 flex items-center justify-center text-gray-300 border border-gray-100">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </template>
                        <div class="px-2 pb-2 flex-1 flex flex-col">
                            <h4 class="font-extrabold text-gray-900 text-sm mb-2 leading-snug" x-text="product.name"></h4>
                            <p class="text-brand-600 font-bold text-xs mt-auto">Rp <span x-text="product.base_price"></span></p>
                        </div>
                    </button>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredProducts.length === 0" style="display: none;" class="text-center py-12 bg-white rounded-3xl border border-dashed border-gray-200">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <p class="text-gray-500 font-semibold text-sm">Belum ada produk dalam katalog ini.</p>
            </div>

            <!-- Pagination Controls -->
            <div x-show="totalPages > 1" style="display: none;" class="flex justify-center items-center gap-2 mt-12">
                <button @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1" 
                        class="w-10 h-10 rounded-full flex items-center justify-center border border-gray-200 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <div class="flex gap-2">
                    <template x-for="page in totalPages" :key="page">
                        <button @click="currentPage = page" 
                                :class="currentPage === page ? 'bg-brand-600 text-white shadow-md border-brand-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'"
                                class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border transition"
                                x-text="page">
                        </button>
                    </template>
                </div>

                <button @click="if(currentPage < totalPages) currentPage++" :disabled="currentPage === totalPages"
                        class="w-10 h-10 rounded-full flex items-center justify-center border border-gray-200 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <!-- Modal Pop-up Detail Produk -->
            <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-transition.opacity>
                <!-- backdrop -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal()"></div>
                
                <!-- Modal content -->
                <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto flex flex-col md:flex-row transform transition-all custom-scrollbar" 
                     @click.stop 
                     x-show="showModal"
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
                     
                    <!-- close btn -->
                    <button type="button" @click="closeModal()" class="absolute top-4 right-4 bg-white/80 hover:bg-gray-100 backdrop-blur-sm shadow-sm rounded-full p-2 z-10 transition border border-gray-100 text-gray-500 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <!-- Product Image -->
                    <div class="w-full md:w-1/2 p-4 md:p-8 bg-gray-50 flex items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                        <template x-if="modalData.photo">
                            <img :src="modalData.photo" class="w-full h-auto max-h-[400px] object-cover rounded-3xl shadow-sm" :alt="modalData.name">
                        </template>
                        <template x-if="!modalData.photo">
                            <div class="w-full aspect-square max-h-[400px] bg-white rounded-3xl flex items-center justify-center text-gray-300 border border-gray-100 shadow-inner">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </template>
                    </div>

                    <!-- Product Info -->
                    <div class="w-full md:w-1/2 p-6 md:p-8 flex flex-col justify-center bg-white">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 bg-brand-100 text-brand-700 text-[10px] font-extrabold rounded-full uppercase tracking-wider" x-text="modalData.cat"></span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 leading-tight" x-text="modalData.name"></h2>
                        <p class="text-gray-400 text-xs font-semibold mb-6 uppercase tracking-wider">Kode: <span class="text-gray-600" x-text="modalData.code"></span></p>

                        <template x-if="modalData.prices && modalData.prices.length > 0">
                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-gray-800 mb-3 tracking-wide uppercase">Pricelist Grosir</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar">
                                    <template x-for="price in modalData.prices">
                                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 flex justify-between items-center text-xs shadow-sm hover:border-brand-200 transition">
                                            <span class="font-bold text-gray-700">
                                                <span x-text="price.min"></span> <span x-show="price.max !== null">- <span x-text="price.max"></span></span><span x-show="price.max === null">+</span> pcs
                                            </span>
                                            <span class="font-extrabold text-brand-600">Rp <span x-text="price.price"></span></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        <template x-if="!modalData.prices || modalData.prices.length === 0">
                            <div class="mb-8 text-gray-500 text-sm font-medium p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">Hubungi CS untuk informasi harga produk ini.</div>
                        </template>

                        <div class="flex flex-col sm:flex-row gap-3 mt-auto pt-6 border-t border-gray-100">
                            <a href="{{ route('public.order') }}" class="flex-1 bg-brand-900 hover:bg-brand-950 text-white font-bold py-3.5 px-6 rounded-xl text-center shadow-lg shadow-brand-900/20 transition-all text-sm shrink-0">Pesanan Baru</a>
                            <a href="https://wa.me/6281380069798" target="_blank" class="flex-1 bg-white hover:bg-gray-50 text-gray-800 border border-gray-200 font-bold py-3.5 px-6 rounded-xl text-center transition-all flex items-center justify-center gap-2 text-sm shadow-sm shrink-0">
                                <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    CS
                </a>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
    
    <script>
        function renderLucide() {
            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', renderLucide);
        } else {
            renderLucide();
        }
    </script>
    <x-public-promo-banner />
</body>
</html>
