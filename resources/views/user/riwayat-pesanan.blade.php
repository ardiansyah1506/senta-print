@extends('layouts.user')
@section('content')
<div class="max-w-7xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Riwayat Pesanan</h1>
                    <p class="text-gray-500 text-sm font-medium">Lihat semua pesanan yang pernah Anda buat</p>
                </div>

                <!-- Table Container -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm flex flex-col">
                    <!-- Filters & Search -->
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                        <!-- Search Box -->
                        <div class="relative w-full sm:max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" class="block w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-sm transition bg-white" placeholder="Cari ID pesanan atau produk...">
                        </div>
                        <div class="text-sm font-semibold text-brand-blue">
                            1 pesanan
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">ID</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Produk</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">QTY</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Progress</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Deadline</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-007</td>
                                    <td class="py-4 px-6 text-gray-600">Seragam Sekolah</td>
                                    <td class="py-4 px-6 text-gray-600">150 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 11.250.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 text-gray-700 text-xs font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Shipped
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-24 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-brand-blue h-1.5 rounded-full" style="width: 100%"></div>
                                            </div>
                                            <span class="text-xs text-gray-400 font-extrabold">100%</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">1 Agu 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button class="px-3 py-1.5 rounded-lg border border-brand-blue text-brand-blue hover:bg-brand-blue hover:text-white transition inline-flex items-center justify-center gap-1.5 text-xs font-bold">
                                            <i class="fa-regular fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                        <div class="text-gray-400">Menampilkan <span class="text-gray-700">1</span> dari <span class="text-gray-700">1</span> pesanan</div>
                        <div class="flex items-center gap-2">
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                            <span class="text-gray-500 px-2">Hal : 1 dari 1 Hal</span>
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        </div>
                    </div>
                </div>
@endsection
