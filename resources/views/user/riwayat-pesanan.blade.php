@extends('layouts.user')
@section('title', 'Riwayat Pemesanan')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Riwayat Pesanan</h1>
            <p class="text-gray-500 text-sm font-medium">Lihat semua pesanan yang pernah Anda buat di Senta Print</p>
        </div>
        <a href="{{ route('user.order.create') }}" class="inline-flex items-center justify-center gap-2 bg-brand-blue hover:bg-indigo-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-sm self-start md:self-auto">
            <i class="fa-solid fa-plus text-xs"></i> Buat Pesanan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 font-bold" role="alert">
            <i class="fa-solid fa-circle-check mr-1.5 text-emerald-600"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm flex flex-col">
        <!-- Filters & Search -->
        <form action="{{ route('user.order.history') }}" method="GET" class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 bg-white">
            <!-- Search Box -->
            <div class="relative w-full sm:max-w-md">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="block w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-sm transition bg-white" placeholder="Cari No. Invoice atau produk...">
            </div>
            <div class="flex items-center justify-between sm:justify-end gap-3 text-xs font-bold">
                @if(!empty($search))
                    <a href="{{ route('user.order.history') }}" class="text-gray-400 hover:text-gray-600 underline">Reset Search</a>
                @endif
                <span class="text-brand-blue bg-indigo-50 px-3 py-1.5 rounded-xl">
                    Total: {{ count($orders) }} Pesanan
                </span>
            </div>
        </form>
        
        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="p-12 text-center space-y-4">
                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-gray-800">Belum Ada Pesanan</h3>
                    <p class="text-xs text-gray-400 font-medium max-w-sm mx-auto mt-1">Anda belum memiliki riwayat pesanan{{ !empty($search) ? ' yang sesuai dengan pencarian' : '' }}. Silakan buat pesanan baru!</p>
                </div>
                <a href="{{ route('user.order.create') }}" class="inline-flex items-center gap-2 bg-brand-blue text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-sm">
                    <i class="fa-solid fa-cart-plus"></i> Order Sekarang
                </a>
            </div>
        @else
            <!-- Table (Desktop View) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">No. Invoice</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Produk</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">QTY</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total Biaya</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status Bayar</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Progress</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 font-extrabold text-brand-blue">{{ $order->invoice_no }}</td>
                            <td class="py-4 px-6 text-gray-800 max-w-[200px] truncate" title="{{ $order->products_summary }}">
                                {{ $order->products_summary }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">{{ number_format($order->total_qty) }} pcs</td>
                            <td class="py-4 px-6 font-bold text-gray-900">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                @php
                                    $st = strtoupper($order->payment_status ?? 'PENDING');
                                    $badgeBg = match($st) {
                                        'PAID', 'LUNAS' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'DP', 'PARTIAL' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        default => 'bg-amber-50 text-amber-600 border-amber-200'
                                    };
                                @endphp
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold border {{ $badgeBg }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ str_contains($badgeBg, 'emerald') ? 'bg-emerald-500' : 'bg-amber-500' }}"></span> {{ $st }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-24 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-brand-blue h-1.5 rounded-full" style="width: {{ $order->progress_percent }}%"></div>
                                    </div>
                                    <span class="text-xs text-brand-blue font-extrabold">{{ $order->progress_percent }}%</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-500 text-xs">{{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                <button type="button" onclick="openDirectCustomerTrackingModal('{{ $order->invoice_no }}')" class="px-3 py-1.5 rounded-lg border border-brand-blue text-brand-blue hover:bg-brand-blue hover:text-white transition inline-flex items-center justify-center gap-1.5 text-xs font-bold">
                                    <i class="fa-regular fa-eye"></i> Detail & Lacak
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cards (Mobile View) -->
            <div class="block md:hidden divide-y divide-gray-100 bg-white font-semibold text-gray-700">
                @foreach($orders as $order)
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-extrabold text-brand-blue block text-sm">{{ $order->invoice_no }}</span>
                            <span class="text-xs text-gray-600 block font-medium">{{ $order->products_summary }}</span>
                        </div>
                        @php
                            $st = strtoupper($order->payment_status ?? 'PENDING');
                            $badgeBg = match($st) {
                                'PAID', 'LUNAS' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'DP', 'PARTIAL' => 'bg-blue-50 text-blue-600 border-blue-200',
                                default => 'bg-amber-50 text-amber-600 border-amber-200'
                            };
                        @endphp
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeBg }}">
                            {{ $st }}
                        </div>
                    </div>
                    <div class="bg-gray-50/80 p-3 rounded-xl space-y-1.5 text-xs border border-gray-100">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah:</span>
                            <span class="font-bold text-gray-800">{{ number_format($order->total_qty) }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Biaya:</span>
                            <span class="font-bold text-gray-900 text-sm">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-1 border-t border-gray-200/60">
                            <span class="text-gray-500">Progress Produksi:</span>
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-brand-blue h-1.5 rounded-full" style="width: {{ $order->progress_percent }}%"></div>
                                </div>
                                <span class="text-xs text-brand-blue font-extrabold">{{ $order->progress_percent }}%</span>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Order:</span>
                            <span class="font-medium text-gray-600">{{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                    <button type="button" onclick="openDirectCustomerTrackingModal('{{ $order->invoice_no }}')" class="w-full py-2 rounded-xl border border-brand-blue text-brand-blue hover:bg-brand-blue hover:text-white transition inline-flex items-center justify-center gap-1.5 text-xs font-bold">
                        <i class="fa-regular fa-eye"></i> Lihat Detail & Lacak
                    </button>
                </div>
                @endforeach
            </div>

            <!-- Footer Counter -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold bg-white">
                <div class="text-gray-400">Menampilkan <span class="text-gray-700">{{ count($orders) }}</span> pesanan</div>
            </div>
        @endif
    </div>
</div>

@include('partials.tracking-modal')
@endsection
