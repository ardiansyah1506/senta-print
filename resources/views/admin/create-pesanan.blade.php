@extends('layouts.admin')
@section('title', 'Input/Edit Data Pesanan')
@section('content')
<script>
    window.categoryData = @json($categories->map(function($c) {
        return [
            'id' => $c->id,
            'name' => $c->name,
            'products' => $c->products->pluck('product_name')
        ];
    }));
</script>
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Input Data Pesanan Baru</h1>
            <p class="text-gray-500 text-sm font-medium">Buat Pesanan & Rekam Kustomer</p>
        </div>
        <a href="{{ route('admin.order.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.order.store') }}" method="POST" id="editOrderForm" enctype="multipart/form-data">
        @csrf
        
        <!-- Informasi Kustomer -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
            <h3 class="text-lg font-extrabold text-gray-900 mb-4 border-b border-gray-100 pb-3">Informasi Kustomer & Catatan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-2">Nama Kustomer <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-4 py-2.5 border font-semibold text-gray-800" placeholder="Masukkan Nama Kustomer">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_phone" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-4 py-2.5 border font-semibold text-gray-800" placeholder="08xxxxxxxxxx">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-2">Instruksi / Catatan Pesanan</label>
                    <textarea name="notes" rows="3" class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-4 py-2.5 border font-medium text-gray-800 resize-none" placeholder="Isi catatan jika ada..."></textarea>
                </div>
            </div>
        </div>
        
        <!-- Upload Foto Desain -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
            <h3 class="text-lg font-extrabold text-gray-900 mb-4 border-b border-gray-100 pb-3 flex justify-between items-center">
                <span>Foto Desain Pesanan <span class="text-xs text-gray-400 font-medium ml-2">(Opsional, Maks 1 Foto)</span></span>
            </h3>
            
            <div class="space-y-4">

                <div class="space-y-2 relative group w-full">
                    <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider">Upload File Foto Baru (Maks 5MB)</label>
                    <div class="relative w-full border-2 border-dashed border-gray-300 group-hover:border-brand-blue group-hover:bg-indigo-50/50 rounded-xl p-3 flex items-center justify-start gap-3 transition">
                        <input type="file" name="design_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('designFileLabel').innerText = this.files.length > 0 ? this.files[0].name : 'Pilih/Tarik Foto (Opsional)'">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-brand-blue shrink-0">
                            <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                        </div>
                        <div class="flex-1 truncate">
                            <p id="designFileLabel" class="text-xs font-extrabold text-gray-700 truncate">Pilih/Tarik Foto (Opsional)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
            <h3 class="text-lg font-extrabold text-gray-900 mb-4 border-b border-gray-100 pb-3 flex justify-between items-center">
                <span>Daftar Item Pesanan</span>
                <button type="button" onclick="addRow()" class="bg-brand-blue text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Baris
                </button>
            </h3>

            <!-- Dynamic Lines container -->
            <div id="itemsContainer" class="space-y-4 mb-6">
                <div class="item-row flex items-start gap-3 bg-gray-50/50 p-4 rounded-xl border border-gray-100 relative">
                    <div class="flex-1 space-y-3">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="items[0][category_id]" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="window.dispatchEvent(new CustomEvent('category-changed', { detail: { index: 0, id: this.value } }))">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-3" x-data="productCombobox('', '')" @category-changed.window="if ($event.detail.index == 0) { categoryId = $event.detail.id; value = ''; }" @click.outside="open = false" class="relative">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="items[0][product_name]" x-model="value" @focus="open = true" @click="open = true" autocomplete="off" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="Pilih/Ketik...">
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <div x-show="open" x-transition class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto" style="display: none;">
                                    <template x-for="opt in filtered" :key="opt">
                                        <div @click="value = opt; open = false;" class="px-3 py-2 text-sm text-gray-800 hover:bg-indigo-50 cursor-pointer font-semibold" x-text="opt"></div>
                                    </template>
                                    <div x-show="filtered.length === 0 && Array.isArray(options) && options.length > 0" class="px-3 py-2 text-xs text-gray-400 italic">Tekan Enter manual</div>
                                    <div x-show="!categoryId" class="px-3 py-2 text-xs text-gray-400 italic">Pilih kategori</div>
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Ukuran</label>
                                <input type="text" name="items[0][size_name]" class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="M/L/XL">
                            </div>
                            <div class="col-span-6 md:col-span-1">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Qty <span class="text-red-500">*</span></label>
                                <input type="number" name="items[0][qty]" min="1" value="1" required class="qty-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="items[0][unit_price]" min="0" value="0" required class="price-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-3 items-center">
                            <div class="col-span-12 md:col-span-9">
                                <input type="text" name="items[0][notes]" class="w-full text-xs border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-medium text-gray-600" placeholder="Catatan per item (opsional)">
                            </div>
                            <div class="col-span-12 md:col-span-3 text-right">
                                <span class="text-[10px] text-gray-400 font-extrabold uppercase mr-2">Total:</span>
                                <span class="row-total text-sm font-extrabold text-brand-blue">Rp 0</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="removeRow(this)" class="mt-6 text-red-400 hover:text-red-600 p-2"><i class="fa-solid fa-trash-can"></i></button>
                </div>
                </div>
            </div>

            <!-- Summary Area -->
            <div class="border-t border-gray-200 pt-6 mt-4 flex justify-end">
                <div class="w-full md:w-1/3 bg-gray-50 p-4 rounded-2xl border border-gray-100 space-y-3">
                    <div class="flex justify-between items-center text-sm font-bold text-gray-600">
                        <span>Total Harga (Subtotal)</span>
                        <span id="labelSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-600">Diskon (Rp)</span>
                        <input type="number" id="inputDiscount" name="discount" value="0" class="w-32 text-right border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-1 border font-semibold text-gray-800 text-sm" onchange="calculateGrandTotal()">
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <span class="font-extrabold text-gray-900 uppercase tracking-wider text-xs">Grand Total</span>
                        <span id="labelGrandTotal" class="text-xl font-extrabold text-brand-blue">Rp 0</span>
                    </div>
                    
                    <!-- Deposit & Sisa Pembayaran -->
                    <div class="flex justify-between items-center text-sm pt-3 border-t border-gray-200">
                        <span class="font-bold text-gray-600">Deposit / DP (Rp)</span>
                        <input type="number" id="inputDeposit" name="deposit" value="0" class="w-32 text-right border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-1 border font-semibold text-gray-800 text-sm" onchange="calculateGrandTotal()">
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200 bg-indigo-50/50 p-2 -mx-2 rounded-lg">
                        <span class="font-extrabold text-red-600 uppercase tracking-wider text-xs">Sisa Pembayaran</span>
                        <span id="labelSisaBayar" class="text-xl font-extrabold text-red-600">Rp 0</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="document.getElementById('editOrderForm').submit()" class="bg-brand-blue text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-[0_6px_16px_-6px_rgba(79,70,229,0.5)]">
                    Simpan Data Pesanan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    let rowIndex = 1;

    document.addEventListener('alpine:init', () => {
        Alpine.data('productCombobox', (initialCategory, initialProduct) => ({
            value: initialProduct.replace(/\\'/g, "'"),
            open: false,
            categoryId: initialCategory,
            get options() {
                if (!window.categoryData) return [];
                let cat = window.categoryData.find(c => c.id == this.categoryId);
                return cat ? cat.products : [];
            },
            get filtered() {
                if (this.value === '') return this.options;
                return this.options.filter(o => String(o).toLowerCase().includes(this.value.toLowerCase()));
            }
        }));
    });

    function formatRp(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function updateProductList(selectElement, rIndex) {
        const parent = selectElement.closest('.item-row');
        const datalist = parent.querySelector(`datalist#productList-${rIndex}`);
        const catId = selectElement.value;
        const cat = categoryData.find(c => c.id == catId);
        
        datalist.innerHTML = '';
        if (cat && cat.products) {
            cat.products.forEach(p => {
                const option = document.createElement('option');
                option.value = p;
                datalist.appendChild(option);
            });
        }
    }

    function addRow() {
        const container = document.getElementById('itemsContainer');
        const rowHtml = `
            <div class="item-row flex items-start gap-3 bg-gray-50/50 p-4 rounded-xl border border-gray-100 relative">
                <div class="flex-1 space-y-3">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="items[${rowIndex}][category_id]" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="window.dispatchEvent(new CustomEvent('category-changed', { detail: { index: ${rowIndex}, id: this.value } }))">
                                <option value="">Pilih Kategori</option>
                                ${categoryData.map(c => `<option value="${c.id}">${c.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-span-12 md:col-span-3" x-data="productCombobox('', '')" @category-changed.window="if ($event.detail.index == ${rowIndex}) { categoryId = $event.detail.id; value = ''; }" @click.outside="open = false" class="relative">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" name="items[${rowIndex}][product_name]" x-model="value" @focus="open = true" @click="open = true" autocomplete="off" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="Pilih/Ketik...">
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <div x-show="open" x-transition class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto" style="display: none;">
                                <template x-for="opt in filtered" :key="opt">
                                    <div @click="value = opt; open = false;" class="px-3 py-2 text-sm text-gray-800 hover:bg-indigo-50 cursor-pointer font-semibold" x-text="opt"></div>
                                </template>
                                <div x-show="filtered.length === 0 && Array.isArray(options) && options.length > 0" class="px-3 py-2 text-xs text-gray-400 italic">Tekan Enter manual</div>
                                <div x-show="!categoryId" class="px-3 py-2 text-xs text-gray-400 italic">Pilih kategori</div>
                            </div>
                        </div>
                        <div class="col-span-6 md:col-span-2">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Ukuran</label>
                            <input type="text" name="items[${rowIndex}][size_name]" class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="M/L/XL">
                        </div>
                        <div class="col-span-6 md:col-span-1">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Qty <span class="text-red-500">*</span></label>
                            <input type="number" name="items[${rowIndex}][qty]" min="1" value="1" required class="qty-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="items[${rowIndex}][unit_price]" min="0" value="0" required class="price-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-3 items-center">
                        <div class="col-span-12 md:col-span-9">
                            <input type="text" name="items[${rowIndex}][notes]" class="w-full text-xs border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-medium text-gray-600" placeholder="Catatan per item (opsional)">
                        </div>
                        <div class="col-span-12 md:col-span-3 text-right">
                            <span class="text-[10px] text-gray-400 font-extrabold uppercase mr-2">Total:</span>
                            <span class="row-total text-sm font-extrabold text-brand-blue">Rp 0</span>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="removeRow(this)" class="mt-6 text-red-400 hover:text-red-600 p-2"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
        rowIndex++;
        calculateGrandTotal();
    }

    function removeRow(btn) {
        if (document.querySelectorAll('.item-row').length > 1) {
            btn.closest('.item-row').remove();
            calculateGrandTotal();
        } else {
            alert('Minimal harus ada 1 baris pesanan!');
        }
    }

    function calculateRow(el) {
        const row = el.closest('.item-row');
        const qty = parseInt(row.querySelector('.qty-input').value) || 0;
        const price = parseInt(row.querySelector('.price-input').value) || 0;
        row.querySelector('.row-total').innerText = formatRp(qty * price);
    }

    function calculateGrandTotal() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;
            const price = parseInt(row.querySelector('.price-input').value) || 0;
            subtotal += (qty * price);
        });

        document.getElementById('labelSubtotal').innerText = formatRp(subtotal);
        
        let discount = parseInt(document.getElementById('inputDiscount').value) || 0;
        let deposit = parseInt(document.getElementById('inputDeposit').value) || 0;
        
        let grandTotal = Math.max(0, subtotal - discount);
        let sisaBayar = Math.max(0, grandTotal - deposit);

        document.getElementById('labelGrandTotal').innerText = formatRp(grandTotal);
        document.getElementById('labelSisaBayar').innerText = formatRp(sisaBayar);
    }

    // init calculate
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.item-row').forEach(row => {
            const input = row.querySelector('.qty-input');
            if(input) calculateRow(input);
        });
        calculateGrandTotal();
    });
</script>
@endsection
