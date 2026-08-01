<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo-meta', [
        'title' => 'Buat Pesanan Custom - Senta Print',
        'description' => 'Formulir pemesanan produk konveksi custom Senta Print. Pesan kaos, seragam, polo shirt, dan merchandise custom secara online dengan kalkulasi harga cepat.',
        'keywords' => 'buat pesanan senta print, pesan kaos custom online, cetak seragam custom, pesan hoodie semarang, kustomisasi produk konveksi',
        'robots' => 'noindex, follow'
    ])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'], }, colors: { brand: { blue: '#4f46e5', light: '#eef2ff' } } } } }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    
    <!-- Navbar -->
    <x-public-navbar />

    <div class="max-w-6xl mx-auto pb-10 px-4 sm:px-6 pt-24 mt-4">
        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Buat Pesanan Custom <span class="bg-brand-blue text-white text-xs px-3 py-1 rounded-full font-bold ml-2">Jalur Public</span></h1>
            <p class="text-gray-500 text-sm font-medium">Bebas antrian, kustomisasi sebebas mungkin. Langsung terhubung dengan Tim Produksi.</p>
        </div>

        <form id="orderForm" action="{{ route('public.order.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return window.processCheckout(event)">
            @csrf
            <input type="hidden" name="cart" id="cartPayload" value="[]">
            <div id="hiddenFilesContainer" class="hidden"></div>
            
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <!-- Form Input Sections -->
                <div class="w-full lg:w-[65%] flex flex-col gap-8">
                    
                    <!-- Box -1: Guest Identitas -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <h2 class="text-lg font-extrabold text-gray-900">Identitas Pemesan</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_pemesan" required placeholder="Budi Santoso" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50 focus:bg-white text-gray-800">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">No. WhatsApp <span class="text-red-500">*</span></label>
                                <input type="text" name="no_whatsapp" required placeholder="081234567890" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50 focus:bg-white text-gray-800">
                                <p class="text-[10px] text-gray-400 mt-2 font-medium">Invoice akan dikaitkan dan dikirim ke No. HP ini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Box 1: Product & Size Details -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 pt-7" id="entryBox">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Kategori</label>
                                <div class="relative">
                                    <select id="categorySelect" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none transition bg-white" onchange="window.updateProducts()">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Produk</label>
                                <div class="relative">
                                    <select id="productSelect" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none transition bg-white disabled:bg-gray-50" disabled>
                                        <option value="">Pilih Produk</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-700 mb-3">Distribusi Ukuran <span class="text-gray-400 font-normal">(Isi jumlah barang per ukuran)</span></label>
                            
                            <!-- Mini Size Chart Box -->
                            <a id="inlineSizeChartBox" href="#" target="_blank" class="hidden mb-4 p-2 bg-indigo-50/50 border border-indigo-100 rounded-xl items-center gap-3 hover:bg-indigo-50 transition group cursor-pointer" title="Klik untuk memperbesar gambar Size Chart di Tab Baru">
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-white border border-indigo-200 shrink-0 relative">
                                    <div class="absolute inset-0 bg-black/30 hidden group-hover:flex items-center justify-center transition">
                                        <i class="fa-solid fa-expand text-white text-[10px]"></i>
                                    </div>
                                    <img id="inlineSizeChartImg" src="" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-brand-blue flex items-center gap-1.5"><i class="fa-solid fa-ruler-combined"></i> Panduan Ukuran</h4>
                                    <p class="text-[10px] text-gray-500 font-medium tracking-wide">Klik untuk melihat detail ukuran</p>
                                </div>
                            </a>

                            <div id="sizesGrid" class="grid grid-cols-4 md:grid-cols-8 gap-3">
                                <div class="text-[10px] text-gray-400 col-span-full">Pilih kategori untuk melihat ukuran yang tersedia.</div>
                            </div>
                        </div>
                        
                        <!-- Add-on Section in Entry Box -->
                        <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Layanan Tambahan (Add-on)</label>
                                <p class="text-[11px] text-gray-400 font-medium">Opsional: Alokasikan Add-on secara spesifik per ukuran (contoh: Lengan Panjang, dsb).</p>
                            </div>
                            <button type="button" onclick="window.openAddonModal('entry')" class="inline-flex items-center justify-center gap-2 bg-indigo-50 text-brand-blue border border-indigo-200 hover:bg-brand-blue hover:text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm shrink-0">
                                <i class="fa-solid fa-plus text-[10px]"></i> Kelola Add-on Per Ukuran
                            </button>
                        </div>
                        <div id="activeAddonsSummary" class="mt-3 flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Box 2: Upload Design -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-extrabold text-gray-900 mb-4">Upload Design File <span class="text-red-500 font-bold ml-1 text-sm">*wajib per list pesanan</span></h2>
                        <div class="w-full border-2 border-dashed border-gray-200 rounded-2xl p-10 flex flex-col items-center justify-center text-center bg-gray-50/50 hover:bg-gray-50 transition cursor-pointer group" onclick="document.getElementById('designFile').click()">
                            <div class="w-12 h-12 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 mb-4 group-hover:text-brand-blue group-hover:border-indigo-100 group-hover:bg-brand-bluelight transition">
                                <i class="fa-solid fa-arrow-up-from-bracket text-lg"></i>
                            </div>
                            <h4 id="fileLabelText" class="font-extrabold text-gray-800 mb-1.5 text-[15px]">Pilih File Desain (klik di sini)</h4>
                            <p class="text-xs text-gray-400 font-bold tracking-wide">PNG, JPG, PDF &mdash; MAX 10MB</p>
                        </div>
                        <input type="file" id="designFile" class="hidden" accept=".png,.jpg,.jpeg,.pdf" onchange="document.getElementById('fileLabelText').innerText = this.files[0] ? this.files[0].name : 'Pilih File Desain (klik di sini)'">
                    </div>

                    <!-- Divider Line -->
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-dashed border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <button type="button" onclick="window.addToCart()" class="bg-[#f4f7f9] px-4 py-1.5 rounded-full text-sm font-bold text-gray-500 flex items-center gap-1.5 cursor-pointer hover:text-brand-blue hover:bg-brand-bluelight transition border border-gray-200 shadow-sm shadow-brand-blue/10">
                                Tambah List Pesanan <i class="fa-solid fa-arrow-down"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Box 3: Catatan -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-extrabold text-gray-900 mb-6">Catatan Akhir</h2>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Catatan Pesanan Secara Keseluruhan</label>
                            <textarea name="notes" rows="3" placeholder="Instruksi pengiriman, kontak referensi, atau custom sablon..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Summary Stick Area -->
                <div class="w-full lg:w-[400px] shrink-0 relative">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-6">
                        <h2 class="text-lg font-extrabold text-gray-900 mb-6">Keranjang Pesanan</h2>
                        
                        <div id="cartItemsContainer" class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-2">
                            <div class="text-sm text-gray-400 font-medium text-center py-6 border-2 border-dashed border-gray-100 rounded-xl">Keranjang Kosong</div>
                        </div>
                        
                        <div class="border-t border-gray-100 py-6 mb-2">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-extrabold text-gray-500 tracking-wide text-xs uppercase">Total Item</span>
                                <span class="font-extrabold text-gray-800" id="grandTotalQty">0 pcs</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-extrabold text-gray-900 tracking-wide text-xs uppercase">Estimasi Biaya</span>
                                <span class="font-extrabold text-brand-blue text-xl" id="grandTotalPrice">Rp 0</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-brand-blue text-white rounded-xl py-4 font-bold hover:bg-indigo-700 transition shadow-[0_6px_16px_-6px_rgba(79,70,229,0.5)] flex items-center justify-center gap-2 mb-4">
                            Kirim Pesanan Sekarang <i class="fa-solid fa-paper-plane text-xs"></i>
                        </button>
                        
                        <p class="text-[10px] text-gray-400 leading-tight font-medium text-center">
                            Pesanan ini akan masuk ke tab <b>Kelola Pesanan</b>. Tim Senta Print akan meninjau dan mengirimkan Invoice konfirmasi.
                        </p>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- Addon Modal -->
    <div id="addonModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-6 relative transform transition-all scale-95" id="addonModalContent">
            <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition" onclick="window.closeAddonModal()">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <h3 class="text-xl font-extrabold text-gray-900 mb-1">Kelola Add-on Per Ukuran</h3>
            <p class="text-xs text-gray-500 mb-6 font-medium">Alokasikan ekstra layanan/tambahan per ukuran untuk <span id="modalProductName" class="font-bold text-gray-700"></span></p>
            
            <input type="hidden" id="modalCartItemId" value="">
            <div id="modalAddonsList" class="flex flex-col gap-4 max-h-[60vh] overflow-y-auto mb-6 pr-2">
                <!-- Multi Addons grouped per size will be injected here -->
            </div>

            <div class="flex gap-3 border-t border-gray-100 pt-4">
                <button type="button" onclick="window.closeAddonModal()" class="w-1/3 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="window.saveAddonsToCartItem()" class="w-2/3 bg-brand-blue text-white rounded-xl py-3 text-xs font-bold hover:bg-indigo-700 transition shadow-md shadow-brand-blue/20">
                    Simpan Add-ons
                </button>
            </div>
        </div>
    </div>

    <script>
        window.dbCategories = @json($categories);
        window.cart = [];
        window.liveDraft = null;
        window.entrySizeAddons = {};

        function formatRupiah(amount) { return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('entryBox').addEventListener('change', window.syncDraft);
            document.getElementById('entryBox').addEventListener('input', window.syncDraft);
            const designFileInput = document.getElementById('designFile');
            if(designFileInput) designFileInput.addEventListener('change', window.syncDraft);
        });

        window.getUnitPriceForQty = function(product, qty) {
            if (!product || !product.prices || product.prices.length === 0) {
                return 0;
            }
            const targetQty = qty > 0 ? qty : 1;
            const sortedPrices = [...product.prices].sort((a, b) => parseInt(a.min_qty) - parseInt(b.min_qty));
            for (let tier of sortedPrices) {
                let min = parseInt(tier.min_qty);
                let max = tier.max_qty ? parseInt(tier.max_qty) : null;
                if (targetQty >= min && (max === null || targetQty <= max)) {
                    return parseFloat(tier.price);
                }
            }
            if (targetQty < parseInt(sortedPrices[0].min_qty)) {
                return parseFloat(sortedPrices[0].price);
            }
            return parseFloat(sortedPrices[sortedPrices.length - 1].price);
        };

        window.syncDraft = function() {
            const catSelect = document.getElementById('categorySelect');
            const prodSelect = document.getElementById('productSelect');
            
            if(!catSelect.value || !prodSelect.value) {
                window.liveDraft = null;
                window.renderCart();
                return;
            }

            const catId = catSelect.value;
            const prodId = prodSelect.value;
            const category = window.dbCategories.find(c => c.id == catId);
            const product = category ? category.products.find(p => p.id == prodId) : null;
            
            const sizesData = {};
            let totalQty = 0;
            document.querySelectorAll('.size-input').forEach(el => {
                let val = parseInt(el.value || 0);
                if(val > 0) {
                    sizesData[el.getAttribute('data-size-id')] = val;
                }
                totalQty += val;
            });

            const unitPrice = window.getUnitPriceForQty(product, totalQty);

            let totalAddonCost = 0;
            let addonsDataList = [];
            if (window.entrySizeAddons) {
                Object.keys(window.entrySizeAddons).forEach(szId => {
                    let addons = window.entrySizeAddons[szId] || [];
                    addons.forEach(a => {
                        let cost = a.price * a.qty;
                        if (a.type === 'subtract') totalAddonCost -= cost;
                        else totalAddonCost += cost;
                        addonsDataList.push(a);
                    });
                });
            }

            let itemTotal = (unitPrice * totalQty) + totalAddonCost;
            itemTotal = Math.max(0, itemTotal);

            const fileInput = document.getElementById('designFile');
            const fileLabel = fileInput.files.length > 0 ? fileInput.files[0].name : '(Belum ada file desain)';
            const fileUrl = fileInput.files.length > 0 ? URL.createObjectURL(fileInput.files[0]) : null;

            const selProdOpt = prodSelect.options[prodSelect.selectedIndex];

            window.liveDraft = {
                id: 'draft',
                category_id: catSelect.value,
                product_id: prodSelect.value,
                product_name: selProdOpt.text + " (Draft)",
                sizes: sizesData,
                total_qty: totalQty,
                addons: addonsDataList,
                size_addons: window.entrySizeAddons ? JSON.parse(JSON.stringify(window.entrySizeAddons)) : {},
                base_price: unitPrice,
                total_price: itemTotal,
                design_file_name: fileLabel,
                design_file_url: fileUrl,
                is_draft: true
            };

            window.renderCart();
        };

        window.updateProducts = function() {
            window.entrySizeAddons = {};
            document.getElementById('activeAddonsSummary').innerHTML = "";
            const catId = document.getElementById('categorySelect').value;
            const productSelect = document.getElementById('productSelect');
            const sizesGrid = document.getElementById('sizesGrid');

            productSelect.innerHTML = '<option value="">Pilih Produk</option>';
            sizesGrid.innerHTML = '';

            if(!catId) {
                productSelect.disabled = true;
                return;
            }

            const category = window.dbCategories.find(c => c.id == catId);
            if(category) {
                let scBox = document.getElementById('inlineSizeChartBox');
                let scImg = document.getElementById('inlineSizeChartImg');
                if(category.size_chart) {
                    let scUrl = '/storage/' + category.size_chart;
                    scBox.href = scUrl;
                    scImg.src = scUrl;
                    scBox.classList.remove('hidden');
                    scBox.classList.add('flex');
                } else {
                    scBox.classList.remove('flex');
                    scBox.classList.add('hidden');
                }

                category.products.forEach(p => {
                    let startingPrice = window.getUnitPriceForQty(p, 1);
                    let priceLabel = startingPrice > 0 ? ` - mulai ${formatRupiah(startingPrice)}` : '';
                    productSelect.innerHTML += `<option value="${p.id}">${p.product_name}${priceLabel}</option>`; 
                });
                productSelect.disabled = false;

                if(category.sizes.length > 0) {
                    category.sizes.forEach(s => {
                        sizesGrid.innerHTML += `
                            <div class="text-center">
                                <div class="text-[10px] font-extrabold text-gray-900 mb-1 uppercase">${s.name}</div>
                                <input type="number" min="0" value="0" name="temp_size" class="size-input w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm" data-size-id="${s.id}" data-size-name="${s.name}">
                            </div>
                        `;
                    });
                } else {
                    sizesGrid.innerHTML = '<div class="text-xs text-gray-400 col-span-full">Tidak ada ukuran untuk Kategori ini.</div>';
                }
            }
            
            document.querySelectorAll('.size-input').forEach(i => i.addEventListener('change', window.syncDraft));
            document.querySelectorAll('.size-input').forEach(i => i.addEventListener('input', window.syncDraft));
            
            window.syncDraft();
        };

        window.openAddonModal = function(cartItemId) {
            const catSelect = document.getElementById('categorySelect');
            const prodSelect = document.getElementById('productSelect');
            
            if (!catSelect.value || !prodSelect.value) {
                if(typeof toastr !== 'undefined') toastr.warning('Silakan pilih Kategori dan Produk terlebih dahulu.');
                else alert('Silakan pilih Kategori dan Produk terlebih dahulu.');
                return;
            }

            const activeSizes = [];
            document.querySelectorAll('.size-input').forEach(el => {
                let val = parseInt(el.value || 0);
                if (val > 0) {
                    activeSizes.push({
                        id: el.getAttribute('data-size-id'),
                        name: el.getAttribute('data-size-name'),
                        qty: val
                    });
                }
            });

            if (activeSizes.length === 0) {
                if(typeof toastr !== 'undefined') toastr.warning('Silakan isi setidaknya 1 kuantitas ukuran pada form sebelum mengelola Add-on.');
                else alert('Silakan isi setidaknya 1 kuantitas ukuran pada form sebelum mengelola Add-on.');
                return;
            }

            const catId = catSelect.value;
            const prodId = prodSelect.value;
            const category = window.dbCategories.find(c => c.id == catId);
            const product = category ? category.products.find(p => p.id == prodId) : null;

            document.getElementById('modalProductName').innerText = product ? product.product_name : '';
            document.getElementById('modalCartItemId').value = cartItemId;

            const listCont = document.getElementById('modalAddonsList');
            listCont.innerHTML = '';

            if (!category || !category.addons || category.addons.length === 0) {
                listCont.innerHTML = '<div class="text-sm text-gray-400 font-medium text-center py-6">Tidak ada Add-on tersedia untuk kategori ini.</div>';
            } else {
                let html = '';
                activeSizes.forEach(sz => {
                    let existingAddonsForSize = window.entrySizeAddons && window.entrySizeAddons[sz.id] ? window.entrySizeAddons[sz.id] : [];

                    html += `
                        <div class="border border-indigo-100 bg-indigo-50/30 rounded-2xl p-4 space-y-3">
                            <div class="flex items-center justify-between border-b border-indigo-100 pb-2">
                                <span class="font-extrabold text-sm text-gray-900 uppercase tracking-wide flex items-center gap-2">
                                    <i class="fa-solid fa-ruler-horizontal text-brand-blue text-xs"></i> Ukuran ${sz.name}
                                </span>
                                <span class="bg-indigo-100 text-brand-blue font-extrabold text-xs px-3 py-1 rounded-full">
                                    Total ${sz.qty} pcs
                                </span>
                            </div>

                            <div class="space-y-2 pt-1">
                    `;

                    category.addons.forEach(a => {
                        let addonPivotPrice = a.pivot && a.pivot.price ? parseInt(a.pivot.price) : 0;
                        let addonPivotType = a.pivot && a.pivot.type ? a.pivot.type : 'add';
                        let foundInSize = existingAddonsForSize.find(item => item.id == a.id);

                        let isChecked = !!foundInSize;
                        let savedQty = foundInSize ? foundInSize.qty : sz.qty;

                        let priceBadge = addonPivotType === 'subtract'
                            ? `<span class="text-xs text-red-600 font-bold">- ${addonPivotPrice > 0 ? formatRupiah(addonPivotPrice) : 'Gratis'}</span>`
                            : `<span class="text-xs text-brand-blue font-bold">+ ${addonPivotPrice > 0 ? formatRupiah(addonPivotPrice) : 'Gratis'}</span>`;

                        html += `
                            <div class="flex items-center justify-between p-3 border border-gray-200/80 rounded-xl bg-white hover:border-brand-blue transition">
                                <label class="flex items-center gap-3 cursor-pointer select-none">
                                    <input type="checkbox" class="modal-addon-cb w-4 h-4 text-brand-blue focus:ring-brand-blue border-gray-300 rounded"
                                        data-size-id="${sz.id}"
                                        data-size-name="${sz.name}"
                                        data-addon-id="${a.id}"
                                        data-addon-name="${a.name}"
                                        data-price="${addonPivotPrice}"
                                        data-type="${addonPivotType}"
                                        ${isChecked ? 'checked' : ''}
                                        onchange="document.getElementById('addon_qty_box_${sz.id}_${a.id}').classList.toggle('hidden', !this.checked);">
                                    <span class="text-xs font-bold text-gray-800">${a.name}</span>
                                    ${priceBadge}
                                </label>

                                <div id="addon_qty_box_${sz.id}_${a.id}" class="${isChecked ? '' : 'hidden'} flex items-center gap-1.5 shrink-0">
                                    <span class="text-[10px] text-gray-400 font-bold">Qty:</span>
                                    <input type="number" id="addon_qty_val_${sz.id}_${a.id}" min="1" max="${sz.qty}" value="${savedQty}" class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-xs font-extrabold text-center text-gray-800 outline-none focus:border-brand-blue">
                                </div>
                            </div>
                        `;
                    });

                    html += `
                            </div>
                        </div>
                    `;
                });

                listCont.innerHTML = html;
            }

            const modal = document.getElementById('addonModal');
            const content = document.getElementById('addonModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.style.opacity = '1';
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        };

        window.closeAddonModal = function() {
            const modal = document.getElementById('addonModal');
            const content = document.getElementById('addonModalContent');
            modal.style.opacity = '0';
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        window.saveAddonsToCartItem = function() {
            const sizeAddonsMap = {};

            document.querySelectorAll('.modal-addon-cb:checked').forEach(cb => {
                let szId = cb.getAttribute('data-size-id');
                let szName = cb.getAttribute('data-size-name');
                let addonId = cb.getAttribute('data-addon-id');
                let addonName = cb.getAttribute('data-addon-name');
                let price = parseInt(cb.getAttribute('data-price') || 0);
                let type = cb.getAttribute('data-type') || 'add';
                let qtyInput = document.getElementById(`addon_qty_val_${szId}_${addonId}`);
                let qty = qtyInput ? parseInt(qtyInput.value || 1) : 1;

                if (!sizeAddonsMap[szId]) sizeAddonsMap[szId] = [];
                sizeAddonsMap[szId].push({
                    id: addonId,
                    name: addonName,
                    qty: qty,
                    price: price,
                    type: type,
                    size_id: szId,
                    size_name: szName
                });
            });

            window.entrySizeAddons = sizeAddonsMap;

            let summaryContainer = document.getElementById('activeAddonsSummary');
            let activeSizesWithAddons = Object.keys(sizeAddonsMap).filter(szId => sizeAddonsMap[szId] && sizeAddonsMap[szId].length > 0);

            if (activeSizesWithAddons.length === 0) {
                summaryContainer.innerHTML = '';
            } else {
                let cardsHtml = activeSizesWithAddons.map(szId => {
                    let addons = sizeAddonsMap[szId];
                    let szName = document.querySelector(`.size-input[data-size-id="${szId}"]`)?.getAttribute('data-size-name') || szId;
                    let totalAddonQtyInSize = addons.reduce((sum, a) => sum + parseInt(a.qty || 0), 0);

                    let addonItemsHtml = addons.map(a => `
                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-brand-blue">
                            <i class="fa-solid fa-check text-[9px]"></i>
                            <span>${a.qty}x ${a.name}</span>
                        </div>
                    `).join('');

                    return `
                        <div class="bg-white border border-indigo-100/90 rounded-xl p-2.5 shadow-2xs">
                            <div class="flex items-center justify-between text-xs font-extrabold text-gray-800 border-b border-indigo-50 pb-1 mb-1.5">
                                <span class="uppercase font-extrabold text-gray-900">Ukuran ${szName}</span>
                                <span class="bg-indigo-50 text-brand-blue px-2 py-0.5 rounded-full text-[10px] font-extrabold">${totalAddonQtyInSize} pcs Add-on</span>
                            </div>
                            <div class="space-y-1">
                                ${addonItemsHtml}
                            </div>
                        </div>
                    `;
                }).join('');

                summaryContainer.innerHTML = `
                    <div class="w-full bg-indigo-50/60 border border-indigo-100/90 rounded-2xl p-3.5 mt-2">
                        <div class="flex items-center justify-between text-xs font-extrabold text-brand-blue mb-2.5">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-puzzle-piece text-xs"></i> Ringkasan Add-on Dikustomisasi:</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
                            ${cardsHtml}
                        </div>
                    </div>
                `;
            }

            window.syncDraft();
            window.closeAddonModal();
            if(typeof toastr !== 'undefined') toastr.success('Add-ons per ukuran berhasil disimpan');
        };

        window.addToCart = function(silent = false) {
            const catSelect = document.getElementById('categorySelect');
            const prodSelect = document.getElementById('productSelect');
            
            if(!catSelect.value || !prodSelect.value) {
                if(!silent) {
                    if(typeof toastr !== 'undefined') toastr.warning('Silakan pilih Kategori dan Produk terlebih dahulu.');
                    else alert('Silakan pilih Kategori dan Produk terlebih dahulu.');
                }
                return false;
            }

            const fileInput = document.getElementById('designFile');
            if(fileInput.files.length === 0) {
                if(!silent) {
                    if(typeof toastr !== 'undefined') toastr.warning('Silakan upload file desain produk Anda terlebih dahulu (Wajib)!');
                    else alert('Silakan upload file desain terlebih dahulu (Wajib)!');
                }
                return false;
            }

            const selProdOpt = prodSelect.options[prodSelect.selectedIndex];
            
            const sizesData = {};
            let totalQty = 0;
            document.querySelectorAll('.size-input').forEach(el => {
                let val = parseInt(el.value || 0);
                if(val > 0) {
                    sizesData[el.getAttribute('data-size-id')] = val;
                    totalQty += val;
                    el.value = 0;
                }
            });

            if(totalQty === 0) {
                if(!silent) {
                    if(typeof toastr !== 'undefined') toastr.warning('Tentukan setidaknya 1 kuantitas ukuran sebelum Tambah Pesanan!');
                    else alert('Tentukan setidaknya 1 kuantitas ukuran sebelum Tambah Pesanan!');
                }
                return false;
            }

            const catId = catSelect.value;
            const category = window.dbCategories.find(c => c.id == catId);
            const product = category ? category.products.find(p => p.id == prodSelect.value) : null;
            const unitPrice = window.getUnitPriceForQty(product, totalQty);

            let totalAddonCost = 0;
            let addonsDataList = [];
            if (window.entrySizeAddons) {
                Object.keys(window.entrySizeAddons).forEach(szId => {
                    let addons = window.entrySizeAddons[szId] || [];
                    addons.forEach(a => {
                        let cost = a.price * a.qty;
                        if (a.type === 'subtract') totalAddonCost -= cost;
                        else totalAddonCost += cost;
                        addonsDataList.push(a);
                    });
                });
            }

            let itemTotal = (unitPrice * totalQty) + totalAddonCost;
            itemTotal = Math.max(0, itemTotal);

            const cartItemId = 'cart_' + Date.now();
            const fileObj = fileInput.files[0];
            const fileLabel = fileObj.name;
            const fileUrl = URL.createObjectURL(fileObj);

            const clonedFile = fileInput.cloneNode(true);
            clonedFile.removeAttribute('id');
            clonedFile.removeAttribute('onchange');
            clonedFile.setAttribute('name', `design_files[${cartItemId}]`);
            document.getElementById('hiddenFilesContainer').appendChild(clonedFile);

            fileInput.value = "";
            document.getElementById('fileLabelText').innerText = "Pilih File Desain (klik di sini)";

            window.cart.push({
                id: cartItemId,
                category_id: catSelect.value,
                product_id: prodSelect.value,
                product_name: selProdOpt.text,
                sizes: sizesData,
                total_qty: totalQty,
                addons: addonsDataList,
                size_addons: window.entrySizeAddons ? JSON.parse(JSON.stringify(window.entrySizeAddons)) : {},
                base_price: unitPrice,
                total_price: itemTotal,
                design_file_name: fileLabel,
                design_file_url: fileUrl
            });

            prodSelect.value = "";
            window.liveDraft = null;
            window.entrySizeAddons = {};
            document.getElementById('activeAddonsSummary').innerHTML = "";
            window.renderCart();
            if(!silent) {
                if(typeof toastr !== 'undefined') toastr.success('Item berhasil ditambahkan ke Keranjang');
                else alert('Item berhasil ditambahkan ke Keranjang');
            }
            return true;
        };

        window.removeFromCart = function(id) {
            window.cart = window.cart.filter(c => c.id !== id);
            
            const targetFile = document.querySelector(`input[name="design_files[${id}]"]`);
            if(targetFile) targetFile.remove();

            window.renderCart();
            if(typeof toastr !== 'undefined') toastr.info('Item dihapus dari Keranjang');
        };

        window.renderCart = function() {
            const cont = document.getElementById('cartItemsContainer');
            document.getElementById('cartPayload').value = JSON.stringify(window.cart);
            
            const itemsToRender = [...window.cart];
            if (window.liveDraft) itemsToRender.push(window.liveDraft);

            if(itemsToRender.length === 0) {
                cont.innerHTML = '<div class="text-sm text-gray-400 font-medium text-center py-6 border-2 border-dashed border-gray-100 rounded-xl">Keranjang Kosong</div>';
                document.getElementById('grandTotalPrice').innerText = "Rp 0";
                document.getElementById('grandTotalQty').innerText = "0 pcs";
                return;
            }

            let html = '';
            let bigTotal = 0;
            let bigQty = 0;

            itemsToRender.forEach(item => {
                bigTotal += item.total_price;
                bigQty += item.total_qty;
                
                const category = window.dbCategories.find(c => c.id == item.category_id);
                
                let sizeRowsHtml = Object.keys(item.sizes).map(szId => {
                    let catSize = category ? category.sizes.find(s => s.id == szId) : null;
                    let szName = catSize ? catSize.name : szId;
                    let szQty = item.sizes[szId];
                    let addonsForSz = (item.size_addons && item.size_addons[szId]) ? item.size_addons[szId] : [];
                    
                    let subItemsHtml = '';
                    let usedAddonQtySum = 0;

                    if (addonsForSz.length > 0) {
                        addonsForSz.forEach(a => {
                            let addonQty = parseInt(a.qty || 0);
                            usedAddonQtySum += addonQty;
                            subItemsHtml += `
                                <div class="flex items-center gap-1.5 text-brand-blue font-bold">
                                    <i class="fa-solid fa-puzzle-piece text-[9px]"></i>
                                    <span>${addonQty}x ${a.name}</span>
                                </div>
                            `;
                        });

                        let remainingStd = szQty - usedAddonQtySum;
                        if (remainingStd > 0) {
                            subItemsHtml += `
                                <div class="flex items-center gap-1.5 text-gray-500 font-medium">
                                    <i class="fa-solid fa-minus text-[9px] text-gray-400"></i>
                                    <span>${remainingStd}x Standar</span>
                                </div>
                            `;
                        }
                    } else {
                        subItemsHtml = `
                            <div class="flex items-center gap-1.5 text-gray-500 font-medium">
                                <i class="fa-solid fa-minus text-[9px] text-gray-400"></i>
                                <span>${szQty}x Standar</span>
                            </div>
                        `;
                    }

                    return `
                        <div class="bg-white border border-gray-200/80 rounded-xl p-2.5 shadow-2xs">
                            <div class="flex items-center justify-between font-extrabold text-xs text-gray-800 border-b border-gray-100 pb-1.5 mb-1.5">
                                <span class="flex items-center gap-1.5 uppercase"><i class="fa-solid fa-ruler-horizontal text-brand-blue text-[10px]"></i> Ukuran: ${szName}</span>
                                <span class="bg-indigo-50 text-brand-blue px-2 py-0.5 rounded-full text-[10px] font-extrabold">${szQty} pcs</span>
                            </div>
                            <div class="space-y-1 pl-1 text-[11px]">
                                ${subItemsHtml}
                            </div>
                        </div>
                    `;
                }).join('');

                html += `
                    <div class="p-4 border border-gray-100 bg-gray-50/70 rounded-2xl relative overflow-hidden shadow-xs">
                        <div class="flex justify-between items-start mb-2">
                            <div class="max-w-[75%]">
                                <h4 class="font-extrabold text-sm text-gray-900 truncate">${item.product_name}</h4>
                                <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider mt-0.5">Total: ${item.total_qty} PCS</p>
                            </div>
                            ${!item.is_draft ? `
                            <button type="button" class="text-[10px] font-bold text-red-500 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-lg transition" onclick="window.removeFromCart('${item.id}')">
                                <i class="fa-solid fa-trash-can mr-0.5"></i> Hapus
                            </button>` : ''}
                        </div>

                        <!-- Per-Size & Addon Breakdown Box -->
                        <div class="mt-3 space-y-1.5 border-t border-gray-200/60 pt-2.5">
                            <div class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-1">Rincian Ukuran & Add-on:</div>
                            <div class="space-y-1.5">
                                ${sizeRowsHtml}
                            </div>
                        </div>

                        ${item.design_file_url ? 
                        `<div class="mt-3 pt-2 border-t border-gray-200/40">
                            <a href="${item.design_file_url}" target="_blank" class="text-[11px] text-brand-blue font-bold truncate hover:underline inline-flex items-center gap-1" title="Lihat Foto / Desain">
                                <i class="fa-solid fa-file-image"></i> ${item.design_file_name}
                            </a>
                        </div>` : 
                        `<div class="mt-3 pt-2 border-t border-gray-200/40">
                            <p class="text-[10px] text-red-500 font-bold truncate"><i class="fa-solid fa-triangle-exclamation mr-1"></i> ${item.design_file_name}</p>
                        </div>`}

                        <div class="flex justify-between items-center mt-3 pt-2.5 border-t border-gray-200">
                            <span class="text-xs text-gray-500 font-medium">${formatRupiah(item.base_price)} /pcs</span>
                            <span class="font-extrabold text-brand-blue text-sm">${formatRupiah(item.total_price)}</span>
                        </div>
                    </div>
                `;
            });

            cont.innerHTML = html;
            document.getElementById('grandTotalPrice').innerText = formatRupiah(bigTotal);
            document.getElementById('grandTotalQty').innerText = bigQty + " pcs";
        };

        window.processCheckout = function(e) {
            e.preventDefault();

            const catSelect = document.getElementById('categorySelect');
            const prodSelect = document.getElementById('productSelect');
            
            if(catSelect.value && prodSelect.value) {
                let res = window.addToCart(true);
                if(!res) return false;
            }

            if(window.cart.length === 0) {
                if(typeof toastr !== 'undefined') toastr.error('Keranjang masih kosong, lengkapi list pesanan minimal 1!');
                return false;
            }

            document.getElementById('orderForm').submit();
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = { "positionClass": "toast-top-right", "timeOut": "3000" };
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if(session('error')) toastr.error("{{ session('error') }}"); @endif
    </script>
    @include('partials.tracking-modal')
</body>
</html>
