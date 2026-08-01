@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- Page Title Header -->
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard</h1>
        <p class="text-sm font-medium text-gray-500 mt-1">Ringkasan operasional konveksi anda</p>
    </div>

    <!-- Top Summary Cards (4 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Total Pesanan -->
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100/80 flex flex-col justify-between hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Pesanan</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalOrders }}</div>
                <div class="mt-2 flex items-center text-xs font-bold text-emerald-600">
                    <i class="fa-solid fa-arrow-up mr-1 text-[10px]"></i> 12%
                </div>
            </div>
        </div>

        <!-- Card 2: Pesanan Aktif -->
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100/80 flex flex-col justify-between hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Pesanan Aktif</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg">
                    <i class="fa-regular fa-clock"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $activeOrders }}</div>
                <div class="mt-2 text-xs font-semibold text-gray-500">
                    Sedang diproses
                </div>
            </div>
        </div>

        <!-- Card 3: Selesai -->
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100/80 flex flex-col justify-between hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Selesai</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-box font-normal"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $completedOrders }}</div>
                <div class="mt-2 flex items-center text-xs font-bold text-emerald-600">
                    <i class="fa-solid fa-arrow-up mr-1 text-[10px]"></i> 8%
                </div>
            </div>
        </div>

        <!-- Card 4: Total Pendapatan -->
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100/80 flex flex-col justify-between hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Pendapatan</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-rotate"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="mt-2 flex items-center justify-between text-[11px] font-medium text-gray-500">
                    <span>Target: Rp {{ number_format($targetRevenue, 0, ',', '.') }}</span>
                    <span class="font-bold text-purple-600">{{ $targetPercentage }}%</span>
                </div>
                <!-- Progress bar -->
                <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1.5 overflow-hidden">
                    <div class="bg-purple-600 h-full rounded-full" style="width: {{ $targetPercentage }}%;"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Middle Section: Ringkasan Status & Statistik Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Card: Ringkasan Status -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-xs border border-gray-100/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-extrabold text-gray-900">Ringkasan Status</h2>
                    <p class="text-xs font-medium text-gray-400 mt-0.5">Distribusikan pesanan berdasarkan status</p>
                </div>
                <span class="text-xs font-semibold text-gray-500 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-lg">7 hari terakhir</span>
            </div>

            @php
                $maxStatusCount = max(1, array_sum($statusBreakdown));
            @endphp

            <div class="space-y-5 my-auto">
                <!-- Status: Pending -->
                <div>
                    <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1.5">
                        <span>Pending</span>
                        <span>{{ $statusBreakdown['pending'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-full rounded-full" style="width: {{ ($statusBreakdown['pending'] / $maxStatusCount) * 100 }}%;"></div>
                    </div>
                </div>

                <!-- Status: Production -->
                <div>
                    <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1.5">
                        <span>Production</span>
                        <span>{{ $statusBreakdown['production'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full" style="width: {{ ($statusBreakdown['production'] / $maxStatusCount) * 100 }}%;"></div>
                    </div>
                </div>

                <!-- Status: Completed -->
                <div>
                    <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1.5">
                        <span>Completed</span>
                        <span>{{ $statusBreakdown['completed'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ ($statusBreakdown['completed'] / $maxStatusCount) * 100 }}%;"></div>
                    </div>
                </div>

                <!-- Status: Rejected -->
                <div>
                    <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1.5">
                        <span>Rejected</span>
                        <span>{{ $statusBreakdown['rejected'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-full rounded-full" style="width: {{ ($statusBreakdown['rejected'] / $maxStatusCount) * 100 }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Card: Statistik Cepat -->
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-gray-100/80 flex flex-col justify-between">
            <div class="mb-4">
                <h2 class="text-base font-extrabold text-gray-900">Statistik Cepat</h2>
                <p class="text-xs font-medium text-gray-400 mt-0.5">Angka-angka penting</p>
            </div>

            <div class="space-y-3.5 my-auto">
                <!-- Stat Item 1 -->
                <div class="bg-indigo-50/50 rounded-xl p-4 flex items-center gap-4 border border-indigo-100/30">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900">{{ number_format($totalItemsProduced, 0, ',', '.') }}</div>
                        <div class="text-xs font-semibold text-gray-500">Total Items Produksi</div>
                    </div>
                </div>

                <!-- Stat Item 2 -->
                <div class="bg-purple-50/50 rounded-xl p-4 flex items-center gap-4 border border-purple-100/30">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900">{{ $activeCustomers }}</div>
                        <div class="text-xs font-semibold text-gray-500">Customer Aktif</div>
                    </div>
                </div>

                <!-- Stat Item 3 -->
                <div class="bg-blue-50/50 rounded-xl p-4 flex items-center gap-4 border border-blue-100/30">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900">{{ $pendingConfirmation }}</div>
                        <div class="text-xs font-semibold text-gray-500">Menunggu Konfirmasi</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Pesanan Terbaru Table -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100/80 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-900">Pesanan Terbaru</h2>
                <p class="text-xs font-medium text-gray-400 mt-0.5">5 pesanan terakhir masuk</p>
            </div>
            <a href="{{ route('admin.order.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition">
                Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50/70 border-b border-gray-100 text-gray-400 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">CUSTOMER</th>
                        <th class="px-6 py-4">PRODUK</th>
                        <th class="px-6 py-4">QTY</th>
                        <th class="px-6 py-4">STATUS</th>
                        <th class="px-6 py-4">TANGGAL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 font-semibold">
                    @forelse($recentOrders as $order)
                        @php
                            $firstItem = $order->items->first();
                            $productName = $firstItem && $firstItem->product ? $firstItem->product->name : ($order->product_name ?? 'Produk Custom');
                            $totalQty = $order->items->sum('qty') ?: ($order->qty ?? 0);
                            $customerName = $order->customer ? $order->customer->name : ($order->customer_name ?? 'Guest');
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-extrabold text-indigo-600">
                                {{ $order->order_number ?? 'ORD-'.str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-bold">
                                {{ $customerName }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $productName }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $totalQty }} pcs
                            </td>
                            <td class="px-6 py-4">
                                @if(in_array($order->status, ['pending']))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-amber-50 text-amber-600 border border-amber-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @elseif(in_array($order->status, ['completed']))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                    </span>
                                @elseif(in_array($order->status, ['rejected', 'cancelled']))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-rose-50 text-rose-600 border border-rose-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Production
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-medium">
                                {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 text-xs font-semibold text-gray-400 flex items-center justify-between">
            <span>Menampilkan {{ $recentOrders->count() }} dari {{ $totalOrders }} pesanan</span>
        </div>
    </div>

</div>
@endsection
