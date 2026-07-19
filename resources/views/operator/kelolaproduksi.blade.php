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
                                <!-- Row 1 -->
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-5 px-6 font-extrabold text-brand-blue">ORD-039</td>
                                    <td class="py-5 px-6 text-gray-600">Polo Shirt</td>
                                    <td class="py-5 px-6 text-gray-600">Budi Santoso</td>
                                    <td class="py-5 px-6 text-gray-600">10 Agu 2026</td>
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-32 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-brand-blue h-1.5 rounded-full" style="width: 83.33%"></div>
                                            </div>
                                            <span class="text-xs text-brand-blue font-extrabold">5/6</span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50/80 text-brand-blue text-[11px] font-bold border border-indigo-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Produksi
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <button onclick="openPopup()" class="px-4 py-1.5 rounded-lg border border-brand-blue text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center gap-2 text-[11px] font-extrabold tracking-wide uppercase">
                                            <i class="fa-regular fa-eye mt-px"></i> Update
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Row 2 -->
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-5 px-6 font-extrabold text-brand-blue">ORD-053</td>
                                    <td class="py-5 px-6 text-gray-600">Topi Custom</td>
                                    <td class="py-5 px-6 text-gray-600">Siti Rahayu</td>
                                    <td class="py-5 px-6 text-gray-600">15 Jul 2026</td>
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-32 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-brand-blue h-1.5 rounded-full" style="width: 33.33%"></div>
                                            </div>
                                            <span class="text-xs text-brand-blue font-extrabold">2/6</span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50/80 text-brand-blue text-[11px] font-bold border border-indigo-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Produksi
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <button onclick="openPopup()" class="px-4 py-1.5 rounded-lg border border-brand-blue text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center gap-2 text-[11px] font-extrabold tracking-wide uppercase">
                                            <i class="fa-regular fa-eye mt-px"></i> Update
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pt-6 mt-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold pl-1 pr-1">
                        <div class="text-gray-400">Menampilkan <span class="text-gray-700">2</span> dari <span class="text-gray-700">2</span> pesanan</div>
                        <div class="flex items-center gap-2">
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                            <span class="text-gray-500 px-2">Hal : 1 dari 2 Hal</span>
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        </div>
                    </div>

                </div>
@endsection
