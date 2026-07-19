<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senta Print - Buat Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'], }, colors: { brand: { blue: '#4f46e5', light: '#eef2ff' } } } } }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    
                </a>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'text-[#4f46e5] font-extrabold border-b-2 border-[#4f46e5]' : 'text-gray-500 font-semibold hover:text-[#4f46e5]' }} text-sm transition pb-1">Home</a>
                    <a href="{{ route('login') }}" class="{{ Request::routeIs('login') ? 'text-[#4f46e5] font-extrabold border-b-2 border-[#4f46e5]' : 'text-gray-500 font-semibold hover:text-[#4f46e5]' }} text-sm transition pb-1">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="max-w-6xl mx-auto pb-10 px-4 sm:px-6 mt-8">
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
                    
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 mb-3">Add Ons</label>
                        <div id="addonsGrid" class="flex flex-col gap-3">
                             <div class="text-[10px] text-gray-400 w-full">Pilih kategori untuk melihat add-ons (contoh: lengan panjang, bordir ekstra).</div>
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

    function formatRupiah(amount) { return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }

    // Bind real-time tracking
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('entryBox').addEventListener('change', window.syncDraft);
        document.getElementById('entryBox').addEventListener('input', window.syncDraft);
        const designFileInput = document.getElementById('designFile');
        if(designFileInput) designFileInput.addEventListener('change', window.syncDraft);
    });

    window.syncDraft = function() {
        const catSelect = document.getElementById('categorySelect');
        const prodSelect = document.getElementById('productSelect');
        
        if(!catSelect.value || !prodSelect.value) {
            window.liveDraft = null;
            window.renderCart();
            return;
        }

        const selProdOpt = prodSelect.options[prodSelect.selectedIndex];
        const basePrice = parseInt(selProdOpt.getAttribute('data-price') || 75000);
        
        let totalQty = 0;
        document.querySelectorAll('.size-input').forEach(el => totalQty += parseInt(el.value || 0));

        let addonsData = [];
        document.querySelectorAll('.addon-checkbox:checked').forEach(el => {
            let addonId = el.value;
            let qty = document.getElementById('addon_qty_' + addonId).value || 1;
            let szEl = document.getElementById('addon_size_' + addonId);
            let szName = (szEl && szEl.value) ? szEl.options[szEl.selectedIndex].text : '';
            addonsData.push({
                name: el.getAttribute('data-name'),
                qty: parseInt(qty),
                size_name: szName,
                price: parseInt(el.getAttribute('data-price') || 0)
            });
        });

        let itemTotal = basePrice * totalQty;
        addonsData.forEach(a => itemTotal += (a.price * a.qty));

        const fileInput = document.getElementById('designFile');
        const fileLabel = fileInput.files.length > 0 ? fileInput.files[0].name : '(Belum ada file desain)';
        const fileUrl = fileInput.files.length > 0 ? URL.createObjectURL(fileInput.files[0]) : null;

        window.liveDraft = {
            product_name: selProdOpt.text + " (Draft)",
            total_qty: totalQty,
            addons: addonsData,
            base_price: basePrice,
            total_price: itemTotal,
            design_file_name: fileLabel,
            design_file_url: fileUrl,
            is_draft: true
        };

        window.renderCart();
    };

    window.updateProducts = function() {
        const catId = document.getElementById('categorySelect').value;
        const productSelect = document.getElementById('productSelect');
        const sizesGrid = document.getElementById('sizesGrid');
        const addonsGrid = document.getElementById('addonsGrid');

        productSelect.innerHTML = '<option value="">Pilih Produk</option>';
        sizesGrid.innerHTML = '';
        addonsGrid.innerHTML = '';

        if(!catId) {
            productSelect.disabled = true;
            return;
        }

        const category = window.dbCategories.find(c => c.id == catId);
        if(category) {
            
            // Render Inline Size Chart
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
                // Determine baseline price (fallbacks to generic if dynamic table isn't fully scoped)
                let actualPrice = p.price || 75000;
                productSelect.innerHTML += `<option value="${p.id}" data-price="${actualPrice}">${p.product_name} - ${formatRupiah(actualPrice)}</option>`; 
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

            if(category.addons.length > 0) {
                let sizeOptions = '<option value="">Pilih Ukuran (Opsional)</option>';
                if(category.sizes.length > 0) {
                    category.sizes.forEach(sz => {
                        sizeOptions += `<option value="${sz.id}">${sz.name}</option>`;
                    });
                }
                
                category.addons.forEach(a => {
                    let addonPivotPrice = a.pivot && a.pivot.price ? parseInt(a.pivot.price) : 0;
                    addonsGrid.innerHTML += `
                        <div class="flex flex-col gap-2 p-3 border border-gray-200 rounded-xl bg-white has-[:checked]:border-brand-blue has-[:checked]:bg-brand-blue/5 transition">
                            <label class="flex items-center justify-between cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" class="addon-checkbox w-4 h-4 text-brand-blue focus:ring-brand-blue border-gray-300 rounded" value="${a.id}" data-name="${a.name}" data-price="${addonPivotPrice}" onchange="document.getElementById('addon_details_${a.id}').classList.toggle('hidden', !this.checked)">
                                    <span class="text-sm font-bold text-gray-700">${a.name}</span>
                                </div>
                                <span class="text-xs text-brand-blue font-bold tracking-wide">+ ${addonPivotPrice > 0 ? formatRupiah(addonPivotPrice) : 'Gratis'}</span>
                            </label>
                            
                            <div id="addon_details_${a.id}" class="hidden mt-2 pt-3 border-t border-gray-100 flex gap-3">
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Kuantitas (pcs)</label>
                                    <input type="number" id="addon_qty_${a.id}" min="1" value="1" class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-xs outline-none focus:border-brand-blue bg-white">
                                </div>
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1">Ukuran Baju Diterapkan</label>
                                    <select id="addon_size_${a.id}" class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-xs outline-none focus:border-brand-blue bg-white">
                                        ${sizeOptions}
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                addonsGrid.innerHTML = '<div class="text-xs text-gray-400">Tidak ada addons untuk Kategori ini.</div>';
            }
        }
        
        // Provide an onchange fallback bindings for dynamically spawned sizes & checkboxes
        document.querySelectorAll('.size-input, .addon-checkbox').forEach(i => i.addEventListener('change', window.syncDraft));
        document.querySelectorAll('.size-input').forEach(i => i.addEventListener('input', window.syncDraft));
        
        window.syncDraft();
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
        const basePrice = parseInt(selProdOpt.getAttribute('data-price') || 75000);
        
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

        const addonsData = [];
        document.querySelectorAll('.addon-checkbox:checked').forEach(el => {
            let addonId = el.value;
            let qty = document.getElementById('addon_qty_' + addonId).value || 1;
            let szEl = document.getElementById('addon_size_' + addonId);
            let szId = szEl.value || null;
            let szName = szId ? szEl.options[szEl.selectedIndex].text : '';
            let parsedPrice = parseInt(el.getAttribute('data-price') || 0);

            addonsData.push({
                id: addonId,
                name: el.getAttribute('data-name'),
                qty: parseInt(qty),
                size_id: szId,
                size_name: szName,
                price: parsedPrice
            });
            
            el.checked = false;
            document.getElementById('addon_details_' + addonId).classList.add('hidden');
        });

        let itemTotal = basePrice * totalQty;
        // logic for addons pricing: + price per addon per qty
        addonsData.forEach(a => {
            itemTotal += (a.price * a.qty);
        }); 

        // File extraction handling
        const cartItemId = 'cart_' + Date.now();
        const fileObj = fileInput.files[0];
        const fileLabel = fileObj.name;
        const fileUrl = URL.createObjectURL(fileObj);

        // Clone the input element to retain file buffer and pass it functionally inside hidden layer
        const clonedFile = fileInput.cloneNode(true);
        clonedFile.removeAttribute('id');
        clonedFile.removeAttribute('onchange');
        clonedFile.setAttribute('name', `design_files[${cartItemId}]`);
        document.getElementById('hiddenFilesContainer').appendChild(clonedFile);

        // Reset visual File input state
        fileInput.value = "";
        document.getElementById('fileLabelText').innerText = "Pilih File Desain (klik di sini)";

        window.cart.push({
            id: cartItemId,
            category_id: catSelect.value,
            product_id: prodSelect.value,
            product_name: selProdOpt.text,
            sizes: sizesData,
            total_qty: totalQty,
            addons: addonsData,
            base_price: basePrice,
            total_price: itemTotal,
            design_file_name: fileLabel,
            design_file_url: fileUrl
        });

        prodSelect.value = "";
        window.liveDraft = null;
        window.renderCart();
        if(!silent) {
            if(typeof toastr !== 'undefined') toastr.success('Item berhasil ditambahkan ke Keranjang');
            else alert('Item berhasil ditambahkan ke Keranjang');
        }
        return true;
    };

    window.removeFromCart = function(id) {
        window.cart = window.cart.filter(c => c.id !== id);
        
        // Remove the hidden generated design constraint payload
        const targetFile = document.querySelector(`input[name="design_files[${id}]"]`);
        if(targetFile) targetFile.remove();

        window.renderCart();
        if(typeof toastr !== 'undefined') toastr.info('Item dihapus dari Keranjang');
    }

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
            
            let addonsDesc = item.addons.length > 0 
                ? item.addons.map(a => `${a.name} (${a.qty}pcs${a.size_name ? ' uk:'+a.size_name : ''})`).join(', ') 
                : 'Tidak ada add-ons';

            html += `
                <div class="p-4 border border-gray-100 bg-gray-50/50 rounded-xl relative overflow-hidden">
                    <div class="flex justify-between items-start mb-2">
                        <div class="max-w-[70%]">
                            <h4 class="font-extrabold text-sm text-gray-900 truncate">${item.product_name}</h4>
                            <p class="text-[10px] text-gray-500 uppercase font-bold mt-0.5">${item.total_qty} PCS &bull; ${item.addons.length} ADD-ONS</p>
                            <p class="text-[9px] text-gray-400 mt-1 truncate" title="${addonsDesc}">${addonsDesc}</p>
                            ${item.design_file_url ? 
                            `<a href="${item.design_file_url}" target="_blank" class="text-[10px] text-brand-blue mt-1.5 font-bold truncate hover:underline inline-block" title="Lihat Foto / Desain">
                                <i class="fa-solid fa-file-image mr-1"></i> ${item.design_file_name}
                            </a>` : 
                            `<p class="text-[10px] text-red-500 mt-1.5 font-bold truncate"><i class="fa-solid fa-triangle-exclamation mr-1"></i> ${item.design_file_name}</p>`
                            }
                        </div>
                        ${!item.is_draft ? `
                        <button type="button" class="text-red-400 hover:text-red-600 transition" onclick="window.removeFromCart('${item.id}')">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>` : ''}
                    </div>
                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                        <span class="text-xs text-gray-500 font-medium">${formatRupiah(item.base_price)} /pcs</span>
                        <span class="font-bold text-brand-blue text-sm">${formatRupiah(item.total_price)}</span>
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
        
        // Auto-commit live draft to cart
        if(catSelect.value && prodSelect.value) {
            let res = window.addToCart(true); // silent auto-commit
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
</body>
</html>
