@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Kelola Pesanan</h1>
                    <p class="text-gray-500 text-sm font-medium">Lihat, filter, dan kelola semua pesanan</p>
                </div>

                <!-- Table Container -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm flex flex-col">
                    <!-- Filters & Search -->
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <!-- Search Box -->
                        <div class="relative w-full sm:max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" class="block w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-sm transition bg-white" placeholder="Cari ID, customer, produk...">
                        </div>
                        <!-- Filters -->
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <div class="relative bg-white border border-gray-200 rounded-xl shadow-sm flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 cursor-pointer hover:border-gray-300 transition w-full sm:w-auto">
                                <i class="fa-solid fa-filter text-gray-400 mr-2 text-xs"></i>
                                <select class="bg-transparent outline-none appearance-none pr-8 cursor-pointer w-full z-10 relative">
                                    <option>Semua Status</option>
                                    <option>Completed</option>
                                    <option>Pending</option>
                                    <option>Production</option>
                                    <option>Shipped</option>
                                    <option>Rejected</option>
                                </select>
                                <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 pointer-events-none"></i>
                            </div>
                            <button class="flex items-center gap-2 border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 transition px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm w-full sm:w-auto justify-center">
                                <i class="fa-solid fa-arrows-rotate text-gray-400"></i> Refresh
                            </button>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">ID</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Customer</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Produk</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">QTY</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Deadline</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                                        @forelse($orders as $order)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-6 font-extrabold text-brand-blue">{{ $order->invoice_no }}</td>
                                            <td class="py-4 px-6">{{ $order->customer->name ?? '-' }}</td>
                                            <td class="py-4 px-6 text-gray-500">{{ $order->items->first()->product->name ?? 'Produk' }}</td>
                                            <td class="py-4 px-6">{{ $order->items->sum('qty') }} pcs</td>
                                            <td class="py-4 px-6 font-bold text-gray-900">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                            <td class="py-4 px-6">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                        'production' => 'bg-indigo-50 text-brand-blue border-indigo-100',
                                                        'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                        'shipped' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                        'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                                    ];
                                                    $dotColors = [
                                                        'pending' => 'bg-amber-500',
                                                        'production' => 'bg-brand-blue',
                                                        'completed' => 'bg-emerald-500',
                                                        'shipped' => 'bg-emerald-500',
                                                        'rejected' => 'bg-red-500',
                                                    ];
                                                    $status = strtolower($order->status ?? 'pending');
                                                    $badgeColor = $statusColors[$status] ?? $statusColors['pending'];
                                                    $dotColor = $dotColors[$status] ?? $dotColors['pending'];
                                                @endphp
                                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span> {{ ucfirst($status) }}
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-gray-500">{{ $order->deadline ? \Carbon\Carbon::parse($order->deadline)->format('d M Y') : '-' }}</td>
                                            <td class="py-4 px-6 text-center text-xs flex gap-2 justify-center">
                                                <button onclick="openPopup({{ $order->id }})" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="py-8 text-center text-gray-400 font-semibold text-xs">Belum ada data pesanan.</td>
                                        </tr>
                                        @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                        <div class="w-full">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
@endsection
