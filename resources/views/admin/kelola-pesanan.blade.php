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
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-001</td>
                                    <td class="py-4 px-6">Budi Santoso</td>
                                    <td class="py-4 px-6 text-gray-500">Kaos Sablon</td>
                                    <td class="py-4 px-6">100 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 6.500.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">20 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-002</td>
                                    <td class="py-4 px-6">Siti Rahayu</td>
                                    <td class="py-4 px-6 text-gray-500">Polo Shirt</td>
                                    <td class="py-4 px-6">50 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 4.250.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">25 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-003</td>
                                    <td class="py-4 px-6">Budi Santoso</td>
                                    <td class="py-4 px-6 text-gray-500">Jaket Hoodie</td>
                                    <td class="py-4 px-6">30 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 3.600.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-bold border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">30 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-004</td>
                                    <td class="py-4 px-6">Andi Pratama</td>
                                    <td class="py-4 px-6 text-gray-500">Kemeja Kerja</td>
                                    <td class="py-4 px-6">200 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 19.000.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-brand-blue text-xs font-bold border border-indigo-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Production
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">10 Agu 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-005</td>
                                    <td class="py-4 px-6">Siti Rahayu</td>
                                    <td class="py-4 px-6 text-gray-500">Jersey Olahraga</td>
                                    <td class="py-4 px-6">25 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 2.250.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-brand-blue text-xs font-bold border border-indigo-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-brand-blue"></span> Production
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">15 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-006</td>
                                    <td class="py-4 px-6">Andi Pratama</td>
                                    <td class="py-4 px-6 text-gray-500">Kaos Polos</td>
                                    <td class="py-4 px-6">500 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 22.500.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">12 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-007</td>
                                    <td class="py-4 px-6">Budi Santoso</td>
                                    <td class="py-4 px-6 text-gray-500">Seragam Sekolah</td>
                                    <td class="py-4 px-6">150 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 11.250.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Shipped
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">1 Agu 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-008</td>
                                    <td class="py-4 px-6">Siti Rahayu</td>
                                    <td class="py-4 px-6 text-gray-500">Topi Custom</td>
                                    <td class="py-4 px-6">80 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 2.800.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">18 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-brand-blue">ORD-009</td>
                                    <td class="py-4 px-6">Budi Santoso</td>
                                    <td class="py-4 px-6 text-gray-500">Polo Shirt</td>
                                    <td class="py-4 px-6">6 pcs</td>
                                    <td class="py-4 px-6 font-bold text-gray-900">Rp 510.000</td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-bold border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">31 Jul 2026</td>
                                    <td class="py-4 px-6 text-center">
                                        <button onclick="openPopup()" class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-brand-blue hover:bg-brand-bluelight transition inline-flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                        <div class="text-gray-400">Menampilkan <span class="text-gray-700">9</span> dari <span class="text-gray-700">9</span> pesanan</div>
                        <div class="flex items-center gap-2">
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                            <span class="text-gray-500 px-2">Hal 1 dari 4 Hal</span>
                            <button class="w-7 h-7 flex items-center justify-center border border-gray-200 text-gray-400 hover:bg-gray-50 rounded bg-white transition"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        </div>
                    </div>
                </div>
@endsection
