@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Filter Bar -->
    <form action="{{ route('admin.order.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-6">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Search Input -->
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari invoice/customer..." class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-xl text-xs outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue font-medium bg-gray-50/50">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>

            <!-- Filter Mode Selector -->
            <select name="filter_type" id="orderFilterType" onchange="toggleOrderFilterMode(this.value)" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-800 outline-none focus:border-brand-blue">
                <option value="all" {{ ($filterType ?? 'all') === 'all' ? 'selected' : '' }}>Semua Tanggal</option>
                <option value="month" {{ ($filterType ?? '') === 'month' ? 'selected' : '' }}>Per Bulan & Tahun</option>
                <option value="range" {{ ($filterType ?? '') === 'range' ? 'selected' : '' }}>Rentang Tanggal Custom</option>
            </select>

            <!-- Inputs per Month & Year -->
            <div id="orderMonthYearInputs" class="flex items-center gap-2 {{ ($filterType ?? '') === 'month' ? '' : 'hidden' }}">
                <select name="month" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2 bg-white text-gray-800 outline-none focus:border-brand-blue">
                    @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ ($month ?? date('n')) == $mNum ? 'selected' : '' }}>{{ $mName }}</option>
                    @endforeach
                </select>
                <select name="year" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2 bg-white text-gray-800 outline-none focus:border-brand-blue">
                    @for($y = date('Y') + 1; $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <!-- Inputs per Date Range -->
            <div id="orderDateRangeInputs" class="flex items-center gap-2 {{ ($filterType ?? '') === 'range' ? '' : 'hidden' }}">
                <input type="date" name="start_date" value="{{ $startDateStr ?? '' }}" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2 bg-white text-gray-800 outline-none focus:border-brand-blue">
                <span class="text-gray-400 text-xs font-bold">s/d</span>
                <input type="date" name="end_date" value="{{ $endDateStr ?? '' }}" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2 bg-white text-gray-800 outline-none focus:border-brand-blue">
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0 justify-end">
            <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-filter text-[10px]"></i> Filter
            </button>
            <a href="{{ route('admin.order.index') }}" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-xl text-xs font-bold hover:bg-gray-200 transition">Reset</a>
        </div>
    </form>

    <script>
        function toggleOrderFilterMode(mode) {
            const monthInputs = document.getElementById('orderMonthYearInputs');
            const rangeInputs = document.getElementById('orderDateRangeInputs');
            if (mode === 'month') {
                monthInputs.classList.remove('hidden');
                rangeInputs.classList.add('hidden');
            } else if (mode === 'range') {
                monthInputs.classList.add('hidden');
                rangeInputs.classList.remove('hidden');
            } else {
                monthInputs.classList.add('hidden');
                rangeInputs.classList.add('hidden');
            }
        }
    </script>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm flex flex-col">
        
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100">
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Invoice / No.</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total Item</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Estimasi Biaya</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status Bayar</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Tahap Produksi</th>
                        <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                    @forelse($orders as $order)
                    @php
                        $payStatus = strtoupper($order->payment_status ?? 'PENDING');
                        $isPaid = ($payStatus === 'PAID' || $payStatus === 'LUNAS');
                        
                        $currentStepName = 'Menunggu Pembayaran';
                        if ($order->production && $order->production->logs->isNotEmpty()) {
                            $lastLog = $order->production->logs->last();
                            if ($lastLog && $lastLog->step) {
                                $currentStepName = $lastLog->step->name;
                            }
                        }
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-4 px-6">
                            <span class="font-extrabold text-brand-blue block text-sm">{{ $order->invoice_no }}</span>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-extrabold text-gray-900 block">{{ $order->customer->name ?? '-' }}</span>
                            <span class="text-xs text-gray-500 font-medium flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-xs"></i> {{ $order->customer->phone ?? '-' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-extrabold text-gray-800">{{ $order->items->sum('qty') }} pcs</span>
                            <span class="text-[10px] text-gray-400 block font-normal">{{ $order->items->first()->product_name ?? 'Produk' }}</span>
                        </td>
                        <td class="py-4 px-6 font-extrabold text-brand-blue text-sm">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($isPaid)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> LUNAS (PAID)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-600 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> BELUM LUNAS
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fa-solid fa-list-check text-[10px]"></i> {{ $currentStepName }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ $order->wa_link }}" target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-2xs" title="Kirim Notifikasi WhatsApp">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> Chat WA
                                </a>

                                @if(!$isPaid)
                                <form action="{{ route('admin.order.confirmPayment', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi bahwa pembayaran untuk invoice {{ $order->invoice_no }} telah diterima?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 bg-brand-blue text-white hover:bg-indigo-700 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-2xs">
                                        <i class="fa-solid fa-check text-[10px]"></i> Konfirmasi Lunas
                                    </button>
                                </form>
                                @endif

                                <button type="button" onclick="openOrderDetailModal({{ $order->id }})" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-500 hover:text-brand-blue hover:bg-indigo-50 transition inline-flex items-center justify-center cursor-pointer" title="Lihat Detail Pesanan">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400 font-semibold text-xs">Belum ada data pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="block md:hidden divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
            @forelse($orders as $order)
            @php
                $payStatus = strtoupper($order->payment_status ?? 'PENDING');
                $isPaid = ($payStatus === 'PAID' || $payStatus === 'LUNAS');
                
                $currentStepName = 'Menunggu Pembayaran';
                if ($order->production && $order->production->logs->isNotEmpty()) {
                    $lastLog = $order->production->logs->last();
                    if ($lastLog && $lastLog->step) {
                        $currentStepName = $lastLog->step->name;
                    }
                }
            @endphp
            <div class="p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-extrabold text-brand-blue block text-sm">{{ $order->invoice_no }}</span>
                        <span class="text-[10px] text-gray-400 font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        @if($isPaid)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> LUNAS
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-600 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> BELUM LUNAS
                            </span>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50/80 p-3 rounded-xl space-y-1.5 text-xs border border-gray-100">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Customer:</span>
                        <span class="font-bold text-gray-900">{{ $order->customer->name ?? '-' }} ({{ $order->customer->phone ?? '-' }})</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Item:</span>
                        <span class="font-bold text-gray-800">{{ $order->items->sum('qty') }} pcs</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Estimasi Biaya:</span>
                        <span class="font-bold text-brand-blue text-sm">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-1 border-t border-gray-200/60">
                        <span class="text-gray-500">Tahap Produksi:</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ $currentStepName }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <a href="{{ $order->wa_link }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-600 hover:text-white py-2 rounded-xl text-xs font-bold transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Chat WA
                    </a>

                    @if(!$isPaid)
                    <form action="{{ route('admin.order.confirmPayment', $order->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Konfirmasi lunas?')">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1 bg-brand-blue text-white py-2 rounded-xl text-xs font-bold transition">
                            <i class="fa-solid fa-check text-[10px]"></i> Lunas
                        </button>
                    </form>
                    @endif

                    <button type="button" onclick="openOrderDetailModal({{ $order->id }})" class="px-3 py-2 rounded-xl border border-gray-200 text-gray-500 hover:text-brand-blue hover:bg-indigo-50 transition inline-flex items-center justify-center cursor-pointer" title="Lihat Detail">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-400 font-semibold text-xs">Belum ada data pesanan.</div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
            <div class="w-full">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Admin Order Detail Pop-up Modal -->
<div id="adminOrderDetailModal" class="fixed inset-0 z-[100] hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full p-8 relative transform transition-all scale-95 max-h-[90vh] overflow-y-auto" id="adminOrderDetailContent">
        <button type="button" onclick="closeOrderDetailModal()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
            <div class="w-10 h-10 bg-indigo-50 text-brand-blue rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <h3 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                    Detail Pesanan <span id="modalInvoiceNo" class="text-brand-blue font-extrabold"></span>
                </h3>
                <p class="text-xs text-gray-500 font-medium">Tanggal Pesanan: <span id="modalOrderDate" class="font-bold text-gray-700"></span></p>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Customer & Action Bar -->
            <div class="bg-gray-50/80 border border-gray-100 rounded-2xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block mb-1">Informasi Pemesan:</span>
                    <h4 id="modalCustomerName" class="font-extrabold text-base text-gray-900"></h4>
                    <p class="text-xs text-gray-500 font-semibold flex items-center gap-1.5 mt-0.5">
                        <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i> <span id="modalCustomerPhone"></span>
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <span id="modalPayBadge" class="px-3 py-1 rounded-full text-xs font-extrabold"></span>

                    <a id="modalWaBtn" href="#" target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-600 hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition shadow-2xs">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Notif WA
                    </a>

                    <form id="modalConfirmForm" action="" method="POST" class="hidden inline" onsubmit="return confirm('Konfirmasi lunas pembayaran untuk pesanan ini?')">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 bg-brand-blue text-white hover:bg-indigo-700 px-3 py-2 rounded-xl text-xs font-bold transition shadow-2xs">
                            <i class="fa-solid fa-check text-[10px]"></i> Konfirmasi Lunas
                        </button>
                    </form>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-indigo-50/30 border border-indigo-100/70 rounded-xl p-3.5">
                <span class="text-[10px] font-extrabold text-brand-blue uppercase tracking-wider block mb-1">Catatan Keseluruhan Pesanan:</span>
                <p id="modalOrderNotes" class="text-xs text-gray-700 font-medium leading-relaxed"></p>
            </div>

            <!-- Order Items Breakdown -->
            <div>
                <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-boxes-stacked text-brand-blue"></i> Rincian Produk & Add-on:
                </h4>
                <div id="modalItemsList" class="space-y-3"></div>
            </div>

            <!-- Total Price Summary Box -->
            <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-2 text-xs">
                <div class="flex justify-between items-center text-gray-600">
                    <span>Subtotal Produk Baju:</span>
                    <span id="modalSubtotalBaju" class="font-extrabold text-gray-800">Rp 0</span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Subtotal Layanan Add-on:</span>
                    <span id="modalSubtotalAddons" class="font-extrabold text-brand-blue">Rp 0</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-200 pt-2 font-extrabold text-base text-gray-900">
                    <span>Grand Total Biaya:</span>
                    <span id="modalGrandTotal" class="text-brand-blue text-lg">Rp 0</span>
                </div>
            </div>

            <!-- Production Progress History & Photos Gallery -->
            <div id="modalProductionSection" class="hidden space-y-3 border-t border-gray-100 pt-5">
                <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-camera text-brand-blue text-xs"></i> Progress Foto Pengerjaan Produksi:
                </h4>
                <div id="modalProductionLogs" class="space-y-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    window.dbOrders = @json($orders->items());

    function openOrderDetailModal(orderId) {
        const order = window.dbOrders.find(o => o.id == orderId);
        if (!order) return;

        document.getElementById('modalInvoiceNo').innerText = order.invoice_no;
        document.getElementById('modalOrderDate').innerText = new Date(order.created_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });
        document.getElementById('modalCustomerName').innerText = order.customer ? order.customer.name : '-';
        document.getElementById('modalCustomerPhone').innerText = order.customer ? order.customer.phone : '-';
        document.getElementById('modalOrderNotes').innerText = order.notes || '(Tidak ada catatan khusus)';
        document.getElementById('modalWaBtn').href = order.wa_link || '#';

        // Payment status badge
        const payBadge = document.getElementById('modalPayBadge');
        const isPaid = (order.payment_status === 'PAID' || order.payment_status === 'LUNAS');
        payBadge.innerText = isPaid ? 'LUNAS (PAID)' : 'BELUM LUNAS';
        payBadge.className = isPaid 
            ? 'px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200' 
            : 'px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-600 border border-amber-200';

        const confirmForm = document.getElementById('modalConfirmForm');
        if (!isPaid) {
            confirmForm.action = `/admin/kelola-pesanan/${order.id}/confirm-payment`;
            confirmForm.classList.remove('hidden');
        } else {
            confirmForm.classList.add('hidden');
        }

        // Render items breakdown
        let itemsHtml = '';
        let grandSubtotalBaju = 0;
        let grandTotalAddons = 0;

        order.items.forEach(it => {
            let basePrice = parseFloat(it.base_price > 0 ? it.base_price : it.unit_price);
            let subtotalBaju = basePrice * it.qty;
            grandSubtotalBaju += subtotalBaju;

            let addonsHtml = '';
            let itemAddonTotal = 0;

            if (it.addons && it.addons.length > 0) {
                addonsHtml = it.addons.map(a => {
                    let aPrice = parseFloat(a.addon_price || 0);
                    itemAddonTotal += aPrice;
                    let formattedPrice = aPrice < 0 
                        ? `<span class="text-red-600 font-bold">- Rp ${Math.abs(aPrice).toLocaleString('id-ID')}</span>`
                        : `<span class="text-brand-blue font-bold">+ Rp ${aPrice.toLocaleString('id-ID')}</span>`;

                    return `
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 bg-indigo-50/40 px-3 py-1.5 rounded-xl border border-indigo-100/60">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-puzzle-piece text-brand-blue text-xs"></i> ${a.addon_name}</span>
                            ${formattedPrice}
                        </div>
                    `;
                }).join('');
            } else {
                addonsHtml = `
                    <div class="text-xs text-gray-400 italic bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100">
                        - Standar (Tanpa Add-on)
                    </div>
                `;
            }

            grandTotalAddons += itemAddonTotal;
            let lineFinalTotal = subtotalBaju + itemAddonTotal;

            let designLink = it.design_file 
                ? `<a href="/storage/${it.design_file}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-brand-blue font-bold hover:underline bg-indigo-50 px-3 py-1 rounded-lg border border-indigo-100">
                    <i class="fa-solid fa-file-image"></i> Lihat Desain
                   </a>`
                : `<span class="text-xs text-gray-400 italic">(Tidak ada file)</span>`;

            itemsHtml += `
                <div class="p-4 border border-gray-200/80 rounded-2xl bg-white space-y-3 shadow-2xs">
                    <div class="flex justify-between items-start border-b border-gray-100 pb-2">
                        <div>
                            <h4 class="font-extrabold text-sm text-gray-900">${it.product_name} (${it.size_name ? 'Ukuran ' + it.size_name : 'All Size'})</h4>
                            <span class="inline-block bg-indigo-50 text-brand-blue text-[10px] font-extrabold px-2.5 py-0.5 rounded-full mt-0.5">${it.qty} pcs</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Harga Dasar Baju</span>
                            <span class="font-extrabold text-xs text-gray-800">Rp ${basePrice.toLocaleString('id-ID')} /pcs</span>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block">Rincian Layanan & Add-on:</span>
                        ${addonsHtml}
                    </div>

                    <div class="flex justify-between items-center pt-1 border-t border-gray-100 text-xs">
                        <span class="text-gray-500 font-medium">File Desain Produk:</span>
                        ${designLink}
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-xs space-y-1">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Subtotal Baju (${it.qty} pcs x Rp ${basePrice.toLocaleString('id-ID')}):</span>
                            <span class="font-bold text-gray-800">Rp ${subtotalBaju.toLocaleString('id-ID')}</span>
                        </div>
                        ${itemAddonTotal !== 0 ? `
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Total Layanan Add-on:</span>
                            <span class="font-bold ${itemAddonTotal < 0 ? 'text-red-600' : 'text-brand-blue'}">
                                ${itemAddonTotal < 0 ? '-' : '+'} Rp ${Math.abs(itemAddonTotal).toLocaleString('id-ID')}
                            </span>
                        </div>` : ''}
                        <div class="flex justify-between items-center border-t border-gray-200/80 pt-1.5 font-extrabold text-gray-900">
                            <span>Total Item Ini:</span>
                            <span class="text-brand-blue text-sm">Rp ${lineFinalTotal.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
            `;
        });

        document.getElementById('modalItemsList').innerHTML = itemsHtml;
        document.getElementById('modalSubtotalBaju').innerText = 'Rp ' + grandSubtotalBaju.toLocaleString('id-ID');
        document.getElementById('modalSubtotalAddons').innerText = (grandTotalAddons >= 0 ? '+' : '') + 'Rp ' + grandTotalAddons.toLocaleString('id-ID');
        document.getElementById('modalGrandTotal').innerText = 'Rp ' + parseFloat(order.grand_total).toLocaleString('id-ID');

        // Production Logs Gallery
        let logsContainer = document.getElementById('modalProductionLogs');
        if (order.production && order.production.logs && order.production.logs.length > 0) {
            let logsHtml = order.production.logs.map(log => {
                let photosHtml = '';
                if (log.photos && log.photos.length > 0) {
                    photosHtml = `
                        <div class="grid grid-cols-4 gap-2 pt-2">
                            ${log.photos.map(p => `
                                <a href="/storage/${p.file_path}" target="_blank" class="w-full h-16 rounded-xl overflow-hidden border border-gray-200 block shadow-2xs hover:opacity-90 transition">
                                    <img src="/storage/${p.file_path}" class="w-full h-full object-cover">
                                </a>
                            `).join('')}
                        </div>
                    `;
                }

                return `
                    <div class="p-3.5 border border-indigo-100 bg-indigo-50/30 rounded-xl space-y-1">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-extrabold text-brand-blue flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i> ${log.step ? log.step.name : 'Tahap'} Selesai
                            </span>
                            <span class="text-[10px] text-gray-400 font-bold">${new Date(log.created_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })}</span>
                        </div>
                        <p class="text-xs text-gray-700 font-medium bg-white p-2.5 rounded-xl border border-gray-100 mt-1">${log.notes}</p>
                        ${photosHtml}
                    </div>
                `;
            }).join('');

            logsContainer.innerHTML = logsHtml;
            document.getElementById('modalProductionSection').classList.remove('hidden');
        } else {
            document.getElementById('modalProductionSection').classList.add('hidden');
        }

        const modal = document.getElementById('adminOrderDetailModal');
        const content = document.getElementById('adminOrderDetailContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.style.opacity = '1';
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeOrderDetailModal() {
        const modal = document.getElementById('adminOrderDetailModal');
        const content = document.getElementById('adminOrderDetailContent');
        modal.style.opacity = '0';
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
