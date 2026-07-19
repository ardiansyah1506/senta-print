@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
                
                <!-- Page Header & Filters -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-2">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Laporan</h1>
                        <p class="text-gray-500 text-sm font-medium">Analisis pesanan dan pendapatan</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative bg-white border border-gray-200 rounded-lg shadow-sm flex items-center px-3 py-2">
                            <select class="bg-transparent text-sm font-semibold text-gray-700 outline-none appearance-none pr-8 cursor-pointer">
                                <option>Rentang Tanggal</option>
                            </select>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-3 pointer-events-none"></i>
                        </div>
                        <div class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm">
                            <input type="text" value="06/30/2026" class="w-28 text-sm font-semibold text-gray-700 outline-none px-3 py-2 bg-transparent text-center">
                            <span class="text-gray-400">-</span>
                            <input type="text" value="07/30/2026" class="w-28 text-sm font-semibold text-gray-700 outline-none px-3 py-2 bg-transparent text-center">
                        </div>
                        <button class="flex items-center gap-2 border border-brand-blue text-brand-blue bg-blue-50/50 hover:bg-brand-bluelight transition px-4 py-2 rounded-lg text-sm font-bold shadow-sm">
                            <i class="fa-solid fa-download"></i> Export Excel
                        </button>
                    </div>
                </div>

                <!-- 4 Stat Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col justify-between">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL REVENUE</p>
                                <p class="text-2xl font-extrabold text-gray-900">Rp 33.250.000</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center">
                                <i class="fa-solid fa-money-bill-wave text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-2">
                            <span>Target: Rp 50.000.000</span>
                            <span class="text-gray-900">66.5%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 66.5%"></div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">PESANAN SELESAI</p>
                            <p class="text-2xl font-extrabold text-gray-900">3</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center">
                            <i class="fa-solid fa-cube text-lg"></i>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">RATA-RATA ORDER</p>
                            <p class="text-2xl font-extrabold text-gray-900">Rp 11.083.333</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-pink-50 text-pink-500 flex items-center justify-center">
                            <i class="fa-solid fa-chart-column text-lg"></i>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white p-6 rounded-2xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL (SEMUA STATUS)</p>
                            <p class="text-2xl font-extrabold text-gray-900">6 Pesanan</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-clock text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Middle Section: 2 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Laporan Bulanan -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900">Laporan Bulanan</h2>
                            <p class="text-xs text-gray-500 font-medium mb-6">Ringkasan per periode</p>
                        </div>
                        <div class="w-full">
                            <div class="grid grid-cols-5 text-[10px] font-bold text-gray-400 border-b border-gray-100 pb-3 mb-4 uppercase tracking-wider">
                                <div class="col-span-1">Periode</div>
                                <div class="text-center">Jumlah Pesanan</div>
                                <div class="text-center">Target</div>
                                <div class="text-center">Pendapatan</div>
                                <div class="text-right">Pencapaian</div>
                            </div>
                            <div class="grid grid-cols-5 items-center text-sm">
                                <div class="col-span-1 text-gray-500 font-semibold text-xs pr-2">30 Jun 2026 - <br> 30 Jul 2026</div>
                                <div class="text-center text-gray-700 font-semibold">6 pesanan</div>
                                <div class="text-center text-gray-400 font-semibold">Rp 50.000.000</div>
                                <div class="text-center text-gray-900 font-extrabold whitespace-nowrap">Rp 33.250.000</div>
                                <div class="text-right text-amber-500 font-extrabold">66.5%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Terpopuler -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full flex flex-col">
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900">Produk Terpopuler</h2>
                            <p class="text-xs text-gray-500 font-medium mb-6">Distribusi pesanan per produk</p>
                        </div>
                        
                        <div class="space-y-4 flex-1">
                            <!-- Item 1 -->
                            <div class="flex items-center gap-4">
                                <div class="w-32 text-xs font-semibold text-gray-600 truncate">Kaos Sablon</div>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-brand-blue h-2 rounded-full w-full"></div>
                                </div>
                                <div class="text-xs font-extrabold text-gray-900 w-4 text-right">1</div>
                            </div>
                            <!-- Item 2 -->
                            <div class="flex items-center gap-4">
                                <div class="w-32 text-xs font-semibold text-gray-600 truncate">Polo Shirt</div>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-brand-blue h-2 rounded-full w-full"></div>
                                </div>
                                <div class="text-xs font-extrabold text-gray-900 w-4 text-right">1</div>
                            </div>
                            <!-- Item 3 -->
                            <div class="flex items-center gap-4">
                                <div class="w-32 text-xs font-semibold text-gray-600 truncate">Jaket Hoodie</div>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-brand-blue h-2 rounded-full w-full"></div>
                                </div>
                                <div class="text-xs font-extrabold text-gray-900 w-4 text-right">1</div>
                            </div>
                            <!-- Item 4 -->
                            <div class="flex items-center gap-4">
                                <div class="w-32 text-xs font-semibold text-gray-600 truncate">Jersey Olahraga</div>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-brand-blue h-2 rounded-full w-full"></div>
                                </div>
                                <div class="text-xs font-extrabold text-gray-900 w-4 text-right">1</div>
                            </div>
                            <!-- Item 5 -->
                            <div class="flex items-center gap-4">
                                <div class="w-32 text-xs font-semibold text-gray-600 truncate">Kaos Polos</div>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-brand-blue h-2 rounded-full w-[90%]"></div>
                                </div>
                                <div class="text-xs font-extrabold text-gray-900 w-4 text-right">1</div>
                            </div>
                            <!-- Item 6 -->
                            <div class="flex items-center gap-4">
                                <div class="w-32 text-xs font-semibold text-gray-600 truncate">Topi Custom</div>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="bg-brand-blue h-2 rounded-full w-[80%]"></div>
                                </div>
                                <div class="text-xs font-extrabold text-gray-900 w-4 text-right">1</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section: Daftar Pesanan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900 mb-1">Pesanan Periode Ini</h2>
                            <p class="text-xs text-gray-500 font-medium">Daftar lengkap pesanan: 30 Jun 2026 - 30 Jul 2026</p>
                        </div>
                        <a href="#" class="text-brand-blue font-bold text-sm hover:text-indigo-800 transition flex items-center gap-1">
                            Lihat Semua <i class="fa-solid fa-arrow-right text-[10px] mt-0.5"></i>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Customer</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Produk</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Jumlah</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Pendapatan Bersih</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="py-4 px-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Deadline</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-semibold text-gray-700 bg-white">
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3.5 px-6 font-extrabold text-brand-blue">ORD-001</td>
                                    <td class="py-3.5 px-6">Budi Santoso</td>
                                    <td class="py-3.5 px-6">Kaos Sablon</td>
                                    <td class="py-3.5 px-6 text-gray-500">100 pcs</td>
                                    <td class="py-3.5 px-6 font-bold text-gray-900">Rp 6.500.000</td>
                                    <td class="py-3.5 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-500">20 Jul 2026</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3.5 px-6 font-extrabold text-brand-blue">ORD-002</td>
                                    <td class="py-3.5 px-6">Siti Rahayu</td>
                                    <td class="py-3.5 px-6">Polo Shirt</td>
                                    <td class="py-3.5 px-6 text-gray-500">50 pcs</td>
                                    <td class="py-3.5 px-6 font-bold text-gray-900">Rp 4.250.000</td>
                                    <td class="py-3.5 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-500">25 Jul 2026</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3.5 px-6 font-extrabold text-brand-blue">ORD-003</td>
                                    <td class="py-3.5 px-6">Budi Santoso</td>
                                    <td class="py-3.5 px-6">Jaket Hoodie</td>
                                    <td class="py-3.5 px-6 text-gray-500">30 pcs</td>
                                    <td class="py-3.5 px-6 font-bold text-gray-900">Rp 3.600.000</td>
                                    <td class="py-3.5 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-bold border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-500">30 Jul 2026</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3.5 px-6 font-extrabold text-brand-blue">ORD-005</td>
                                    <td class="py-3.5 px-6">Siti Rahayu</td>
                                    <td class="py-3.5 px-6">Jersey Olahraga</td>
                                    <td class="py-3.5 px-6 text-gray-500">25 pcs</td>
                                    <td class="py-3.5 px-6 font-bold text-gray-900">Rp 2.250.000</td>
                                    <td class="py-3.5 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 text-brand-blue text-xs font-bold border border-indigo-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Production
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-500">15 Jul 2026</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3.5 px-6 font-extrabold text-brand-blue">ORD-006</td>
                                    <td class="py-3.5 px-6">Andi Pratama</td>
                                    <td class="py-3.5 px-6">Kaos Polos</td>
                                    <td class="py-3.5 px-6 text-gray-500">500 pcs</td>
                                    <td class="py-3.5 px-6 font-bold text-gray-900">Rp 22.500.000</td>
                                    <td class="py-3.5 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-500">12 Jul 2026</td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3.5 px-6 font-extrabold text-brand-blue">ORD-008</td>
                                    <td class="py-3.5 px-6">Siti Rahayu</td>
                                    <td class="py-3.5 px-6">Topi Custom</td>
                                    <td class="py-3.5 px-6 text-gray-500">80 pcs</td>
                                    <td class="py-3.5 px-6 font-bold text-gray-900">Rp 2.800.000</td>
                                    <td class="py-3.5 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-500">18 Jul 2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                        <div class="text-gray-400">Menampilkan <span class="text-gray-700">6</span> dari <span class="text-gray-700">9</span> pesanan</div>
                        <div class="flex items-center gap-2">
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                            <span class="text-gray-500 px-2">Hal 1 dari 4 Hal</span>
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        </div>
                    </div>
                </div>
@endsection
