@extends('layouts.admin')
@section('title', 'Input/Edit Data Pesanan')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Input Data Pesanan: {{ $order->invoice_no }}</h1>
            <p class="text-gray-500 text-sm font-medium">Customer: {{ $order->customer->name ?? '-' }} ({{ $order->customer->phone ?? '-' }})</p>
        </div>
        <a href="{{ route('admin.order.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <!-- Notes Section from User -->
    <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-6 mb-6">
        <h3 class="text-sm font-extrabold text-indigo-900 mb-2 flex items-center gap-2"><i class="fa-solid fa-message text-brand-blue"></i> Instruksi Pesanan dari Customer</h3>
        <p class="text-sm text-gray-700 font-medium whitespace-pre-wrap">{{ $order->notes ?? '(Tidak ada catatan)' }}</p>
    </div>

    <form action="{{ route('admin.order.update', $order->id) }}" method="POST" id="editOrderForm">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="notes" value="{{ $order->notes }}">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
            <h3 class="text-lg font-extrabold text-gray-900 mb-4 border-b border-gray-100 pb-3 flex justify-between items-center">
                <span>Daftar Item Pesanan</span>
                <button type="button" onclick="addRow()" class="bg-brand-blue text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Baris
                </button>
            </h3>

            <!-- Dynamic Lines container -->
            <div id="itemsContainer" class="space-y-4 mb-6">
                @if($order->items->count() === 0)
                <!-- First Empty Row if zero items -->
                <div class="item-row flex items-start gap-3 bg-gray-50/50 p-4 rounded-xl border border-gray-100 relative">
                    <div class="flex-1 space-y-3">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-5">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Nama Produk / Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="items[0][product_name]" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="Contoh: Kaos PDH Custom">
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Ukuran</label>
                                <input type="text" name="items[0][size_name]" class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="M/L/XL">
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Qty <span class="text-red-500">*</span></label>
                                <input type="number" name="items[0][qty]" min="1" value="1" required class="qty-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this)">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="items[0][unit_price]" min="0" value="0" required class="price-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this)">
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
                @else
                <!-- Existing Rows -->
                @foreach($order->items as $index => $item)
                <div class="item-row flex items-start gap-3 bg-gray-50/50 p-4 rounded-xl border border-gray-100 relative">
                    <div class="flex-1 space-y-3">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-5">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Nama Produk / Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="items[{{ $index }}][product_name]" value="{{ $item->product_name }}" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800">
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Ukuran</label>
                                <input type="text" name="items[{{ $index }}][size_name]" value="{{ $item->size_name }}" class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800">
                            </div>
                            <div class="col-span-6 md:col-span-2">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Qty <span class="text-red-500">*</span></label>
                                <input type="number" name="items[{{ $index }}][qty]" min="1" value="{{ $item->qty }}" required class="qty-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="items[{{ $index }}][unit_price]" min="0" value="{{ (int)($item->base_price > 0 ? $item->base_price : $item->unit_price) }}" required class="price-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-3 items-center">
                            <div class="col-span-12 md:col-span-9">
                                <input type="text" name="items[{{ $index }}][notes]" value="{{ $item->notes }}" class="w-full text-xs border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-medium text-gray-600" placeholder="Catatan per item (opsional)">
                            </div>
                            <div class="col-span-12 md:col-span-3 text-right">
                                <span class="text-[10px] text-gray-400 font-extrabold uppercase mr-2">Total:</span>
                                <span class="row-total text-sm font-extrabold text-brand-blue">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="removeRow(this)" class="mt-6 text-red-400 hover:text-red-600 p-2"><i class="fa-solid fa-trash-can"></i></button>
                </div>
                @endforeach
                @endif
            </div>

            <!-- Daftar Layanan Tambahan (Add-on) -->
            <h3 class="text-lg font-extrabold text-gray-900 mt-8 mb-4 border-b border-gray-100 pb-3 flex justify-between items-center">
                <span>Daftar Layanan Tambahan / Add-on <span class="text-xs text-gray-400 font-medium ml-2">(Opsional)</span></span>
                <button type="button" onclick="addAddonRow()" class="bg-indigo-50 text-brand-blue border border-indigo-100 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-brand-blue hover:text-white transition">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Add-on
                </button>
            </h3>

            <div id="addonsContainer" class="space-y-4 mb-6">
            </div>

            <!-- Summary Area -->
            <div class="border-t border-gray-200 pt-6 mt-4 flex justify-end">
                <div class="w-full md:w-1/3 bg-gray-50 p-4 rounded-2xl border border-gray-100 space-y-3">
                    <div class="flex justify-between items-center text-sm font-bold text-gray-600">
                        <span>Subtotal (Otomatis)</span>
                        <span id="labelSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-600">Diskon (Rp)</span>
                        <input type="number" id="inputDiscount" name="discount" value="{{ (int)$order->discount }}" class="w-32 text-right border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-1 border font-semibold text-gray-800 text-sm" onchange="calculateGrandTotal()">
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <span class="font-extrabold text-gray-900 uppercase tracking-wider text-xs">Grand Total</span>
                        <span id="labelGrandTotal" class="text-xl font-extrabold text-brand-blue">Rp 0</span>
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
    let rowIndex = {{ max($order->items->count(), 1) }};

    function formatRp(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function addRow() {
        const container = document.getElementById('itemsContainer');
        const rowHtml = `
            <div class="item-row flex items-start gap-3 bg-gray-50/50 p-4 rounded-xl border border-gray-100 relative">
                <div class="flex-1 space-y-3">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 md:col-span-5">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Nama Produk / Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="items[${rowIndex}][product_name]" required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="Contoh: Kaos PDH Custom">
                        </div>
                        <div class="col-span-6 md:col-span-2">
                            <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1">Ukuran</label>
                            <input type="text" name="items[${rowIndex}][size_name]" class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="M/L/XL">
                        </div>
                        <div class="col-span-6 md:col-span-2">
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

    function addAddonRow() {
        const container = document.getElementById('addonsContainer');
        const rowHtml = `
            <div class="item-row flex items-center gap-3 bg-indigo-50/30 p-4 rounded-xl border border-indigo-50 relative">
                <div class="flex-1 space-y-3">
                    <div class="grid grid-cols-12 gap-3 items-end">
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-[10px] font-extrabold text-indigo-700 uppercase tracking-wider mb-1">Nama Add-on <span class="text-red-500">*</span></label>
                            <input type="text" name="items[${rowIndex}][product_name]" value="Add-on: " required class="w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" placeholder="Contoh: Add-on: Lengan Panjang">
                        </div>
                        <div class="col-span-6 md:col-span-3">
                            <label class="block text-[10px] font-extrabold text-indigo-700 uppercase tracking-wider mb-1">Qty <span class="text-red-500">*</span></label>
                            <input type="number" name="items[${rowIndex}][qty]" min="1" value="1" required class="qty-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                        </div>
                        <div class="col-span-6 md:col-span-3">
                            <label class="block text-[10px] font-extrabold text-indigo-700 uppercase tracking-wider mb-1">Biaya Tambahan (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="items[${rowIndex}][unit_price]" min="0" value="0" required class="price-input w-full text-sm border-gray-200 rounded-lg outline-none focus:border-brand-blue px-3 py-2 border font-semibold text-gray-800" onchange="calculateRow(this); calculateGrandTotal()">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center shrink-0 border-l border-indigo-100 pl-4 ml-2">
                    <span class="text-[10px] text-gray-400 font-extrabold uppercase mb-1">Sub:</span>
                    <span class="row-total text-sm font-extrabold text-brand-blue mb-1">Rp 0</span>
                    <button type="button" onclick="removeRow(this, true)" class="text-red-400 hover:text-red-600 p-1"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
        rowIndex++;
        calculateGrandTotal();
    }

    function removeRow(btn, force = false) {
        if (force || document.querySelectorAll('.item-row').length > 1) {
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
        let grandTotal = Math.max(0, subtotal - discount);

        document.getElementById('labelGrandTotal').innerText = formatRp(grandTotal);
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
