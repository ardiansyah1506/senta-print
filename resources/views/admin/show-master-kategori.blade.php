@extends('layouts.admin')
@section('content')
<div class="max-w-6xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-8">
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-brand-blue transition mb-4">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Daftar Kategori : Polo Collection</h1>
                    <p class="text-gray-500 text-sm font-medium">Kelola konfigurasi produk, Add On, dan ukuran beserta harganya</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Produk</p>
                            <p class="text-3xl font-extrabold text-gray-900">12</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i class="fa-solid fa-cart-shopping text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Add On</p>
                            <p class="text-3xl font-extrabold text-gray-900">12</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-puzzle-piece text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah Ukuran</p>
                            <p class="text-3xl font-extrabold text-gray-900">9</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                            <i class="fa-solid fa-ruler-combined text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- section 1: Daftar Produk -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-extrabold text-gray-900">Daftar Produk</h2>
                        <button class="bg-brand-blue text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm shadow-indigo-200">
                            <i class="fa-solid fa-plus text-xs"></i> Tambah Produk
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Dasar</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">Quarter Zip-Polo</td>
                                    <td class="py-4 px-6 text-gray-500">Lacoste CVC24s, Halfzipper, Bordir 2 titik</td>
                                    <td class="py-4 px-6">Rp.112.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">Seamless Neck Lacoste</td>
                                    <td class="py-4 px-6 text-gray-500">Lacoste CVC24s, Bordir 1-2 titik</td>
                                    <td class="py-4 px-6">Rp.108.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">Trident Polo</td>
                                    <td class="py-4 px-6 text-gray-500">Lacoste CVC24s, Bordir 1-2 titik</td>
                                    <td class="py-4 px-6">Rp.118.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">Prism Polo</td>
                                    <td class="py-4 px-6 text-gray-500">Lacoste CVC24s, Bordir 1-2 titik</td>
                                    <td class="py-4 px-6">Rp.113.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">Summit Style Polo</td>
                                    <td class="py-4 px-6 text-gray-500">Lacoste CVC24s, Kancing 3, Bordir 2 titik</td>
                                    <td class="py-4 px-6">Rp.107.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-xs font-semibold text-gray-500">Menampilkan 5 dari 43 produk</div>
                        <div class="flex items-center gap-1 text-sm font-semibold">
                            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 rounded-md transition"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                            <button class="w-8 h-8 flex items-center justify-center bg-brand-blue text-white rounded-md">1</button>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-md transition">2</button>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-md transition">3</button>
                            <span class="px-1 text-gray-400">...</span>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-md transition">10</button>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 rounded-md transition"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                        </div>
                    </div>
                </div>

                <!-- section 2: Daftar Ukuran -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-extrabold text-gray-900">Daftar Ukuran</h2>
                        <button class="bg-brand-blue text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm shadow-indigo-200">
                            <i class="fa-solid fa-plus text-xs"></i> Tambah Ukuran
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Catatan / Instruksi Khusus</label>
                            <div class="w-full border border-gray-200 rounded-lg p-2.5 flex items-center flex-wrap gap-2 focus-within:border-brand-blue focus-within:ring-1 focus-within:ring-brand-blue transition bg-gray-50/30 relative">
                                <span class="bg-brand-blue text-white text-xs font-bold px-3 py-1.5 rounded flex items-center gap-1.5">XS <button class="hover:text-gray-200"><i class="fa-solid fa-xmark text-[10px]"></i></button></span>
                                <span class="bg-brand-blue text-white text-xs font-bold px-3 py-1.5 rounded flex items-center gap-1.5">S <button class="hover:text-gray-200"><i class="fa-solid fa-xmark text-[10px]"></i></button></span>
                                <span class="bg-brand-blue text-white text-xs font-bold px-3 py-1.5 rounded flex items-center gap-1.5">M <button class="hover:text-gray-200"><i class="fa-solid fa-xmark text-[10px]"></i></button></span>
                                <span class="bg-brand-blue text-white text-xs font-bold px-3 py-1.5 rounded flex items-center gap-1.5">L <button class="hover:text-gray-200"><i class="fa-solid fa-xmark text-[10px]"></i></button></span>
                                <input type="text" class="flex-1 bg-transparent min-w-[100px] outline-none text-sm text-gray-700" placeholder="">
                                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Dropzone -->
                        <div class="w-full border-2 border-dashed border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center text-center bg-gray-50/50 hover:bg-gray-50 transition cursor-pointer group">
                            <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 mb-3 group-hover:text-brand-blue transition">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-1">Unggah Size Chart (JPG, PNG, PDF)</h4>
                            <p class="text-xs text-gray-500 font-medium">Tarik dan lepas file disini atau klik untuk memilih</p>
                        </div>
                    </div>
                </div>

                <!-- section 3: Daftar Add On -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden pb-4">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-extrabold text-gray-900">Daftar Add On</h2>
                        <button class="bg-brand-blue text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm shadow-indigo-200">
                            <i class="fa-solid fa-plus text-xs"></i> Tambah Add On
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Add On</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Harga Tambahan</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">combed 24s</td>
                                    <td class="py-4 px-6 text-right">Rp.9.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">combed 30s</td>
                                    <td class="py-4 px-6 text-right">Rp.12.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">combed 20s</td>
                                    <td class="py-4 px-6 text-right">Rp.6.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">PQ 30s</td>
                                    <td class="py-4 px-6 text-right">Rp.4.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900">Summit Style Polo</td>
                                    <td class="py-4 px-6 text-right">Rp.7.000</td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between mt-2">
                        <div class="text-xs font-semibold text-gray-500">Menampilkan 5 dari 12 add on</div>
                        <div class="flex items-center gap-1 text-sm font-semibold">
                            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 rounded-md transition"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                            <button class="w-8 h-8 flex items-center justify-center bg-brand-blue text-white rounded-md">1</button>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-md transition">2</button>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-md transition">3</button>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 rounded-md transition"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                        </div>
                    </div>
                </div>
@endsection
