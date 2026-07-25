@extends('layouts.user')
@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Buat Pesanan Baru</h1>
        <p class="text-gray-500 text-sm font-medium">Isi detail pesanan konveksi Anda</p>
    </div>

    <form id="orderForm" action="{{ route('user.order.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return window.processCheckout(event)">
        @csrf
        <input type="hidden" name="cart" id="cartPayload" value="[]">
        <div id="hiddenFilesContainer" class="hidden"></div>
        
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <!-- Left Form Area -->
            <div class="w-full lg:flex-1 space-y-6">
                
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
                    
                    <!-- Size Breakdown Rows Section -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-0.5">Rincian Ukuran & Layanan Add-on</label>
                                <p class="text-[11px] text-gray-400 font-medium">Tentukan rincian ukuran, jumlah, dan layanan Add-on khusus per kelompok baju.</p>
                            </div>
                            <a id="inlineSizeChartBox" href="#" target="_blank" class="hidden p-1.5 bg-indigo-50 border border-indigo-100 rounded-xl items-center gap-2 hover:bg-indigo-100 transition group cursor-pointer shrink-0" title="Lihat Size Chart">
                                <i class="fa-solid fa-ruler-combined text-brand-blue text-xs"></i>
                                <span class="text-[11px] font-bold text-brand-blue">Size Chart</span>
                            </a>
                        </div>

                        <!-- Dynamic Size Rows Container -->
                        <div id="sizeRowsContainer" class="space-y-3 mb-3">
                            <div class="text-xs text-gray-400 italic">Pilih kategori untuk mengisi ukuran.</div>
                        </div>

                        <button type="button" id="btnAddSizeRow" onclick="window.addSizeRow()" class="hidden w-full py-2.5 bg-gray-50 hover:bg-indigo-50/60 border border-dashed border-gray-300 hover:border-brand-blue text-brand-blue rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus text-[10px]"></i> Tambah Rincian Ukuran / Variasi Baru
                        </button>
                    </div>

                    <!-- Global Addons Section -->
                    <div class="mt-6 pt-5 border-t border-gray-100" id="globalAddonSection">
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-0.5">Add-on Global (Opsional)</label>
                            <p class="text-[11px] text-gray-400 font-medium">Add-on di bawah ini akan otomatis diterapkan ke 100% baju yang Anda pesan (seluruh total pcs).</p>
                        </div>
                        <div id="globalAddonList" class="space-y-2">
                            <div class="text-xs text-gray-400 italic">Pilih kategori untuk melihat Add-on global.</div>
                        </div>
                    </div>
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

<script>
    window.dbCategories = @json($categories);
    window.cart = [];
    window.liveDraft = null;
    let sizeRowCounter = 0;

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

    window.addSizeRow = function(sizeId = '', qty = 1, selectedAddonIds = []) {
        const catId = document.getElementById('categorySelect').value;
        if (!catId) return;

        const category = window.dbCategories.find(c => c.id == catId);
        if (!category || !category.sizes || category.sizes.length === 0) return;

        const rowId = 'row_' + (++sizeRowCounter);
        const container = document.getElementById('sizeRowsContainer');

        if (container.querySelector('.italic')) container.innerHTML = '';

        let sizeOptionsHtml = category.sizes.map(s => `
            <option value="${s.id}" data-name="${s.name}" ${sizeId == s.id ? 'selected' : ''}>Ukuran ${s.name}</option>
        `).join('');

        let addonsCheckboxesHtml = '';
        if (category.addons && category.addons.length > 0) {
            addonsCheckboxesHtml = category.addons.map(a => {
                let price = a.pivot && a.pivot.price ? parseInt(a.pivot.price) : 0;
                let type = a.pivot && a.pivot.type ? a.pivot.type : 'add';
                let checked = selectedAddonIds.includes(String(a.id)) ? 'checked' : '';
                let badge = type === 'subtract' ? `- ${formatRupiah(price)}` : `+ ${formatRupiah(price)}`;

                return `
                    <label class="inline-flex items-center gap-1.5 bg-white border border-gray-200 px-2.5 py-1.5 rounded-lg text-xs font-bold text-gray-700 hover:border-brand-blue transition cursor-pointer">
                        <input type="checkbox" class="row-addon-cb w-3.5 h-3.5 text-brand-blue border-gray-300 rounded focus:ring-brand-blue" value="${a.id}" data-name="${a.name}" data-price="${price}" data-type="${type}" ${checked} onchange="window.syncDraft()">
                        <span>${a.name} <span class="text-[10px] text-brand-blue font-extrabold">(${badge})</span></span>
                    </label>
                `;
            }).join('');
        } else {
            addonsCheckboxesHtml = '<span class="text-[11px] text-gray-400 italic">Tidak ada Add-on khusus</span>';
        }

        const rowDiv = document.createElement('div');
        rowDiv.id = rowId;
        rowDiv.className = 'size-row border border-gray-200 rounded-2xl p-4 bg-gray-50/60 shadow-2xs space-y-3 relative group';
        rowDiv.innerHTML = `
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="w-36 shrink-0">
                        <select class="row-size-select w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-extrabold text-gray-800 bg-white outline-none focus:border-brand-blue" onchange="window.syncDraft()">
                            ${sizeOptionsHtml}
                        </select>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-bold text-gray-500">Jumlah:</span>
                        <input type="number" min="1" value="${qty}" class="row-qty-input w-20 border border-gray-200 rounded-xl px-3 py-2 text-xs font-extrabold text-center text-gray-800 bg-white outline-none focus:border-brand-blue" oninput="window.syncDraft()">
                        <span class="text-xs font-bold text-gray-500">pcs</span>
                    </div>
                </div>

                <button type="button" onclick="window.removeSizeRow('${rowId}')" class="btn-remove-row text-xs font-extrabold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition self-end sm:self-auto">
                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                </button>
            </div>

            <div class="pt-2 border-t border-gray-200/60">
                <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-1.5">Add-on Spesifik Kelompok Ini (Opsional):</span>
                <div class="flex flex-wrap gap-2">
                    ${addonsCheckboxesHtml}
                </div>
            </div>
        `;

        container.appendChild(rowDiv);
        window.syncDraft();
    };

    window.removeSizeRow = function(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.remove();
            const container = document.getElementById('sizeRowsContainer');
            if (container.children.length === 0) {
                window.addSizeRow();
            }
            window.syncDraft();
        }
    };

    window.updateProducts = function() {
        const catId = document.getElementById('categorySelect').value;
        const productSelect = document.getElementById('productSelect');
        const container = document.getElementById('sizeRowsContainer');
        const globalContainer = document.getElementById('globalAddonList');
        const btnAdd = document.getElementById('btnAddSizeRow');

        productSelect.innerHTML = '<option value="">Pilih Produk</option>';
        container.innerHTML = '';
        globalContainer.innerHTML = '';

        if (!catId) {
            productSelect.disabled = true;
            btnAdd.classList.add('hidden');
            container.innerHTML = '<div class="text-xs text-gray-400 italic">Pilih kategori untuk mengisi ukuran.</div>';
            globalContainer.innerHTML = '<div class="text-xs text-gray-400 italic">Pilih kategori untuk melihat Add-on global.</div>';
            window.syncDraft();
            return;
        }

        const category = window.dbCategories.find(c => c.id == catId);
        if (category) {
            let scBox = document.getElementById('inlineSizeChartBox');
            if (category.size_chart) {
                let scUrl = '/storage/' + category.size_chart;
                scBox.href = scUrl;
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

            if (category.addons && category.addons.length > 0) {
                let globalHtml = category.addons.map(a => {
                    let price = a.pivot && a.pivot.price ? parseInt(a.pivot.price) : 0;
                    let type = a.pivot && a.pivot.type ? a.pivot.type : 'add';
                    let priceBadge = type === 'subtract'
                        ? `<span class="text-xs text-red-600 font-bold tracking-wide">- ${price > 0 ? formatRupiah(price) : 'Gratis'} /pcs</span>`
                        : `<span class="text-xs text-brand-blue font-bold tracking-wide">+ ${price > 0 ? formatRupiah(price) : 'Gratis'} /pcs</span>`;

                    return `
                        <label class="flex items-center justify-between p-3 border border-gray-200 rounded-xl bg-gray-50/50 hover:bg-white has-[:checked]:border-brand-blue has-[:checked]:bg-indigo-50/30 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="global-addon-cb w-4 h-4 text-brand-blue focus:ring-brand-blue border-gray-300 rounded" value="${a.id}" data-name="${a.name}" data-price="${price}" data-type="${type}" onchange="window.syncDraft()">
                                <span class="text-xs font-extrabold text-gray-800">${a.name}</span>
                            </div>
                            ${priceBadge}
                        </label>
                    `;
                }).join('');
                globalContainer.innerHTML = globalHtml;
            } else {
                globalContainer.innerHTML = '<div class="text-xs text-gray-400 italic">Tidak ada Add-on tersedia.</div>';
            }

            if (category.sizes && category.sizes.length > 0) {
                btnAdd.classList.remove('hidden');
                window.addSizeRow();
            } else {
                btnAdd.classList.add('hidden');
                container.innerHTML = '<div class="text-xs text-gray-400 italic">Tidak ada ukuran untuk Kategori ini.</div>';
            }
        }

        window.syncDraft();
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

        const globalAddons = [];
        document.querySelectorAll('.global-addon-cb:checked').forEach(cb => {
            globalAddons.push({
                id: cb.value,
                name: cb.getAttribute('data-name'),
                price: parseInt(cb.getAttribute('data-price') || 0),
                type: cb.getAttribute('data-type') || 'add'
            });
        });
        
        const sizesData = {};
        const sizeAddonsMap = {};
        let totalQty = 0;

        document.querySelectorAll('#sizeRowsContainer .size-row').forEach(row => {
            let sizeSelect = row.querySelector('.row-size-select');
            let qtyInput = row.querySelector('.row-qty-input');
            if (!sizeSelect || !qtyInput) return;

            let szId = sizeSelect.value;
            let szName = sizeSelect.options[sizeSelect.selectedIndex].getAttribute('data-name') || szId;
            let rowQty = parseInt(qtyInput.value || 0);

            if (rowQty > 0) {
                sizesData[szId] = (sizesData[szId] || 0) + rowQty;
                totalQty += rowQty;

                const rowAddonMap = new Map();
                row.querySelectorAll('.row-addon-cb:checked').forEach(cb => {
                    rowAddonMap.set(String(cb.value), {
                        id: cb.value,
                        name: cb.getAttribute('data-name'),
                        price: parseInt(cb.getAttribute('data-price') || 0),
                        type: cb.getAttribute('data-type') || 'add',
                        qty: rowQty,
                        size_id: szId,
                        size_name: szName
                    });
                });

                globalAddons.forEach(ga => {
                    if (!rowAddonMap.has(String(ga.id))) {
                        rowAddonMap.set(String(ga.id), {
                            id: ga.id,
                            name: ga.name,
                            price: ga.price,
                            type: ga.type,
                            qty: rowQty,
                            size_id: szId,
                            size_name: szName
                        });
                    }
                });

                let rowAddonsList = Array.from(rowAddonMap.values());

                if (rowAddonsList.length > 0) {
                    if (!sizeAddonsMap[szId]) sizeAddonsMap[szId] = [];
                    rowAddonsList.forEach(a => {
                        sizeAddonsMap[szId].push(a);
                    });
                }
            }
        });

        const unitPrice = window.getUnitPriceForQty(product, totalQty);

        let totalAddonCost = 0;
        let addonsDataList = [];
        Object.keys(sizeAddonsMap).forEach(szId => {
            let addons = sizeAddonsMap[szId] || [];
            addons.forEach(a => {
                let cost = a.price * a.qty;
                if (a.type === 'subtract') totalAddonCost -= cost;
                else totalAddonCost += cost;
                addonsDataList.push(a);
            });
        });

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
            size_addons: JSON.parse(JSON.stringify(sizeAddonsMap)),
            base_price: unitPrice,
            total_price: itemTotal,
            design_file_name: fileLabel,
            design_file_url: fileUrl,
            is_draft: true
        };

        window.renderCart();
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

        const globalAddons = [];
        document.querySelectorAll('.global-addon-cb:checked').forEach(cb => {
            globalAddons.push({
                id: cb.value,
                name: cb.getAttribute('data-name'),
                price: parseInt(cb.getAttribute('data-price') || 0),
                type: cb.getAttribute('data-type') || 'add'
            });
        });

        const sizesData = {};
        const sizeAddonsMap = {};
        let totalQty = 0;

        document.querySelectorAll('#sizeRowsContainer .size-row').forEach(row => {
            let sizeSelect = row.querySelector('.row-size-select');
            let qtyInput = row.querySelector('.row-qty-input');
            if (!sizeSelect || !qtyInput) return;

            let szId = sizeSelect.value;
            let szName = sizeSelect.options[sizeSelect.selectedIndex].getAttribute('data-name') || szId;
            let rowQty = parseInt(qtyInput.value || 0);

            if (rowQty > 0) {
                sizesData[szId] = (sizesData[szId] || 0) + rowQty;
                totalQty += rowQty;

                const rowAddonMap = new Map();
                row.querySelectorAll('.row-addon-cb:checked').forEach(cb => {
                    rowAddonMap.set(String(cb.value), {
                        id: cb.value,
                        name: cb.getAttribute('data-name'),
                        price: parseInt(cb.getAttribute('data-price') || 0),
                        type: cb.getAttribute('data-type') || 'add',
                        qty: rowQty,
                        size_id: szId,
                        size_name: szName
                    });
                });

                globalAddons.forEach(ga => {
                    if (!rowAddonMap.has(String(ga.id))) {
                        rowAddonMap.set(String(ga.id), {
                            id: ga.id,
                            name: ga.name,
                            price: ga.price,
                            type: ga.type,
                            qty: rowQty,
                            size_id: szId,
                            size_name: szName
                        });
                    }
                });

                let rowAddonsList = Array.from(rowAddonMap.values());

                if (rowAddonsList.length > 0) {
                    if (!sizeAddonsMap[szId]) sizeAddonsMap[szId] = [];
                    rowAddonsList.forEach(a => {
                        sizeAddonsMap[szId].push(a);
                    });
                }
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
        Object.keys(sizeAddonsMap).forEach(szId => {
            let addons = sizeAddonsMap[szId] || [];
            addons.forEach(a => {
                let cost = a.price * a.qty;
                if (a.type === 'subtract') totalAddonCost -= cost;
                else totalAddonCost += cost;
                addonsDataList.push(a);
            });
        });

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

        const selProdOpt = prodSelect.options[prodSelect.selectedIndex];

        window.cart.push({
            id: cartItemId,
            category_id: catSelect.value,
            product_id: prodSelect.value,
            product_name: selProdOpt.text,
            sizes: sizesData,
            total_qty: totalQty,
            addons: addonsDataList,
            size_addons: JSON.parse(JSON.stringify(sizeAddonsMap)),
            base_price: unitPrice,
            total_price: itemTotal,
            design_file_name: fileLabel,
            design_file_url: fileUrl
        });

        prodSelect.value = "";
        window.liveDraft = null;
        document.getElementById('sizeRowsContainer').innerHTML = '';
        document.getElementById('globalAddonList').innerHTML = '';
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
@endsection
