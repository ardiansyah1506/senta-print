@extends('layouts.admin')
@section('content')
<div class="max-w-6xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Master Kategori</h1>
                        <p class="text-gray-500 text-sm font-medium">Kelola daftar kategori produk Senta Print utama</p>
                    </div>
                    <button class="bg-brand-blue text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm shadow-indigo-200">
                        <i class="fa-solid fa-plus text-xs"></i> Tambah Kategori
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 lg:w-2/3">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Kategori</p>
                            <p class="text-3xl font-extrabold text-gray-900">8</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-brand-blue flex items-center justify-center">
                            <i class="fa-solid fa-layer-group text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Produk Varian</p>
                            <p class="text-3xl font-extrabold text-gray-900">43</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
                            <i class="fa-solid fa-shirt text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- section 1: Daftar Kategori -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-extrabold text-gray-900">Daftar Kategori</h2>
                        <!-- Search Box -->
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-sm transition bg-gray-50/50" placeholder="Cari kategori...">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi Singkat</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Jumlah Varian</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                                @forelse($categories as $category)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 font-bold text-gray-900 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-brand-bluelight text-brand-blue flex items-center justify-center text-xs"><i class="fa-solid fa-layer-group"></i></div>
                                        {{ $category->name }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">{{ $category->description ?? '-' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-md text-xs font-bold">{{ $category->sizes()->count() }} Varian</span>
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-2 flex justify-end">
                                        <a href="#" title="Kelola Item" class="inline-flex items-center justify-center text-brand-blue hover:text-white hover:bg-brand-blue transition w-8 h-8 rounded-md bg-brand-bluelight"><i class="fa-solid fa-eye text-xs"></i></a>
                                        <button class="text-gray-400 hover:text-brand-yellow transition w-8 h-8 rounded-md hover:bg-yellow-50"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50 inline-flex items-center justify-center"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500 font-semibold">Belum ada Kategori.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-center">
                        {{ $categories->links() }}
                    </div>
                </div>
@endsection
