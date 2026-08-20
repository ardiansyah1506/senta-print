@extends('layouts.operator')
@section('title', 'Kelola Produksi')
@section('content')
<div class="max-w-7xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Kelola Produksi</h1>
                        <p class="text-gray-500 text-sm font-medium">Daftar pesanan aktif dan pembaruan progres</p>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <form action="{{ route('operator.production.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-6">
                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <span class="text-xs font-extrabold text-gray-500 uppercase tracking-wider whitespace-nowrap"><i class="fa-solid fa-filter text-brand-blue mr-1"></i> Mode & Filter:</span>
                        
                        <select name="status" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2.5 bg-gray-50 text-gray-800 outline-none focus:border-brand-blue w-full md:w-auto">
                            <option value="all">Semua Status</option>
                            <option value="pending" {{ ($statusFilter ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="production" {{ ($statusFilter ?? '') === 'production' ? 'selected' : '' }}>Produksi</option>
                            <option value="completed" {{ ($statusFilter ?? '') === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ ($statusFilter ?? '') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>

                        <select name="time_filter" class="text-xs font-bold border border-gray-200 rounded-xl px-3 py-2.5 bg-gray-50 text-gray-800 outline-none focus:border-brand-blue w-full md:w-auto">
                            <option value="all" {{ ($timeFilter ?? '') === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="today" {{ ($timeFilter ?? '') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ ($timeFilter ?? '') === 'week' ? 'selected' : '' }}>Pekan Ini</option>
                            <option value="month" {{ ($timeFilter ?? '') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ ($timeFilter ?? '') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>
                    
                    <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3 w-full md:w-auto shrink-0 justify-end">
                        <div class="relative w-full md:w-56 xl:w-72">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari invoice/customer..." class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-xl text-xs outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue font-medium bg-gray-50/50">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-sm flex items-center justify-center gap-1.5 flex-1 md:flex-none">
                                <i class="fa-solid fa-magnifying-glass text-[10px]"></i> Terapkan
                            </button>
                            <a href="{{ route('operator.production.index') }}" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-xl text-xs font-bold hover:bg-gray-200 transition text-center flex-1 md:flex-none flex items-center justify-center">Reset</a>
                        </div>
                    </div>
                </form>

                <!-- Table Container Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col">
                    
                    <!-- Title Section inside Box -->
                    <div class="mb-8 pl-1">
                        <h2 class="text-xl font-extrabold text-gray-900 mb-1">Pesanan dalam Proses</h2>
                        <p class="text-gray-500 text-sm font-medium">Pilih pesanan untuk memperbarui status dan melampirkan bukti</p>
                    </div>

                    <!-- Table (Desktop View) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">ID</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Produk</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Customer</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Deadline</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Tahap Kemajuan</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                                @forelse($orders as $order)
                                @php
                                    $completedSteps = $order->production ? $order->production->logs->unique('production_step_id')->count() : 0;
                                    $progressPercent = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-5 px-6 font-extrabold text-brand-blue">{{ $order->invoice_no }}</td>
                                    <td class="py-5 px-6 text-gray-600">{{ $order->items->first()->product->name ?? 'Produk' }}</td>
                                    <td class="py-5 px-6 text-gray-600">{{ $order->customer->name ?? '-' }}</td>
                                    <td class="py-5 px-6 text-gray-600">{{ $order->deadline ? \Carbon\Carbon::parse($order->deadline)->format('d M Y') : '-' }}</td>
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-32 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-brand-blue h-1.5 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                            </div>
                                            <span class="text-xs text-brand-blue font-extrabold">{{ $completedSteps }}/{{ $totalSteps }}</span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50/80 text-brand-blue text-[11px] font-bold border border-indigo-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Produksi
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <a href="{{ route('operator.tracking', $order->id) }}" class="px-4 py-1.5 rounded-lg border border-brand-blue text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center gap-2 text-[11px] font-extrabold tracking-wide uppercase">
                                            <i class="fa-regular fa-eye mt-px"></i> Update
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-400 font-semibold text-xs">Belum ada pesanan dalam proses produksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Card View (Mobile View) -->
                    <div class="block md:hidden divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                        @forelse($orders as $order)
                        @php
                            $completedSteps = $order->production ? $order->production->logs->unique('production_step_id')->count() : 0;
                            $progressPercent = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                        @endphp
                        <div class="py-4 space-y-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-extrabold text-brand-blue block text-sm">{{ $order->invoice_no }}</span>
                                    <span class="text-xs text-gray-600 block">{{ $order->items->first()->product->name ?? 'Produk' }}</span>
                                </div>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-brand-blue text-[10px] font-bold border border-indigo-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Produksi
                                </div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl space-y-1.5 text-xs border border-gray-100">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Customer:</span>
                                    <span class="font-bold text-gray-900">{{ $order->customer->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Deadline:</span>
                                    <span class="font-medium text-gray-700">{{ $order->deadline ? \Carbon\Carbon::parse($order->deadline)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-1 border-t border-gray-200/60">
                                    <span class="text-gray-500">Tahap Kemajuan:</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-brand-blue h-1.5 rounded-full" style="width: {{ $progressPercent }}%"></div>
                                        </div>
                                        <span class="text-xs text-brand-blue font-extrabold">{{ $completedSteps }}/{{ $totalSteps }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('operator.tracking', $order->id) }}" class="w-full py-2.5 rounded-xl border border-brand-blue text-brand-blue hover:bg-brand-blue hover:text-white transition inline-flex items-center justify-center gap-2 text-xs font-extrabold uppercase tracking-wide">
                                <i class="fa-regular fa-eye"></i> Update Progress Produksi
                            </a>
                        </div>
                        @empty
                        <div class="py-8 text-center text-gray-400 font-semibold text-xs">Belum ada pesanan dalam proses produksi.</div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pt-6 mt-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold pl-1 pr-1">
                        <div class="w-full">
                            {{ $orders->links() }}
                        </div>
                    </div>

                </div>
@endsection
