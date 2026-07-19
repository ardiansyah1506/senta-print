@extends('layouts.admin')
@section('content')
<div class="max-w-6xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Data Master</h1>
                    <p class="text-gray-500 text-sm font-medium">Kelola konfigurasi Kategori, Add on, dan Ukuran beserta harganya</p>
                </div>

                <!-- Main Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- Left Sidebar (Tabs) -->
                    <div class="lg:col-span-4">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                            <ul class="space-y-1">
                                <li>
                                    <a href="#" class="block px-5 py-3.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl transition">
                                        Master Kategori
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block px-5 py-3.5 text-sm font-bold text-brand-blue bg-brand-bluelight rounded-xl transition shadow-sm border border-indigo-50/50">
                                        Master Add On
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block px-5 py-3.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl transition">
                                        Master Ukuran
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Content Area -->
                    <div class="lg:col-span-8 flex flex-col gap-8">
                        
                        <!-- Box 1: Tambah Data Baru -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                            <h2 class="text-xl font-extrabold text-gray-900 mb-6">Tambah Data Baru</h2>
                            
                            <form action="{{ route('admin.addon.store') }}" method="POST" class="space-y-5">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Nama Add On</label>
                                    <input type="text" name="name" required placeholder="Masukkan Add On..." class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800">
                                </div>
                                <div class="flex justify-end pt-2">
                                    <button type="submit" class="bg-brand-blue text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)]">
                                        <i class="fa-solid fa-plus text-xs"></i> Tambah Data
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Box 2: Daftar Add On -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm flex flex-col">
                            <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white">
                                <h2 class="text-xl font-extrabold text-gray-900">Daftar Add On</h2>
                                <a href="#" class="text-brand-blue font-bold text-sm hover:text-indigo-800 transition flex items-center gap-2">
                                    Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-white border-b border-gray-100">
                                            <th class="py-5 px-8 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest w-full">Nama</th>
                                            <th class="py-5 px-8 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-right whitespace-nowrap w-32">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 font-semibold text-gray-800 bg-white">
                                        @forelse($addons as $addon)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-8 font-bold text-gray-900">{{ $addon->name }}</td>
                                            <td class="py-4 px-8 text-right space-x-2 flex justify-end">
                                                <button class="text-gray-400 hover:text-brand-blue transition w-8 h-8 rounded-md hover:bg-gray-100 inline-flex items-center justify-center"><i class="fa-regular fa-pen-to-square"></i></button>
                                                <form action="{{ route('admin.addon.destroy', $addon->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition w-8 h-8 rounded-md hover:bg-red-50 inline-flex items-center justify-center"><i class="fa-regular fa-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="py-8 text-center text-gray-500">Belum ada Add On yang ditambahkan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="px-8 py-5 border-t border-gray-100 flex items-center justify-center text-xs font-bold">
                                {{ $addons->links() }}
                            </div>
                        </div>

                    </div>
                </div>
@endsection
