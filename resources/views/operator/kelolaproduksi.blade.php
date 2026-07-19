@extends('layouts.operator')
@section('content')
<div class="max-w-7xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Kelola Produksi</h1>
                    <p class="text-gray-500 text-sm font-medium">Daftar pesanan aktif dan pembaruan progres</p>
                </div>

                <!-- Table Container Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col">
                    
                    <!-- Title Section inside Box -->
                    <div class="mb-8 pl-1">
                        <h2 class="text-xl font-extrabold text-gray-900 mb-1">Pesanan dalam Proses</h2>
                        <p class="text-gray-500 text-sm font-medium">Pilih pesanan untuk memperbarui status dan melampirkan bukti</p>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
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
                    
                    <!-- Pagination -->
                    <div class="pt-6 mt-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold pl-1 pr-1">
                        <div class="w-full">
                            {{ $orders->links() }}
                        </div>
                    </div>

                </div>
@endsection
