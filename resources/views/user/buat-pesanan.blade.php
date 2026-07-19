@extends('layouts.user')
@section('content')
<div class="max-w-7xl mx-auto">
                
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Buat Pesanan Baru</h1>
                    <p class="text-gray-500 text-sm font-medium">Isi detail pesanan konveksi Anda</p>
                </div>

                <!-- Form & Summary Layout -->
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    
                    <!-- Left Form Area -->
                    <div class="w-full lg:flex-1 space-y-6">
                        
                        <!-- Box 1: Product & Size Details -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 pt-7">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Kategori -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Kategori</label>
                                    <div class="relative">
                                        <select class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none transition bg-white">
                                            <option>Pilih Kategori</option>
                                            <option>Polo Shirt</option>
                                            <option>Kaos Sablon</option>
                                        </select>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                </div>
                                <!-- Produk -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Produk</label>
                                    <div class="relative">
                                        <select class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none transition bg-white">
                                            <option>Pilih Produk</option>
                                        </select>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Ukuran -->
                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-700 mb-3">Distribusi Ukuran</label>
                                <div class="grid grid-cols-5 md:grid-cols-9 gap-3">
                                    <!-- Size Item -->
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">XS</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">S</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">M</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">L</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">XL</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">2XL</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                        <div class="text-[9px] font-extrabold text-brand-blue mt-1">+5k</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">3XL</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                        <div class="text-[9px] font-extrabold text-brand-blue mt-1">+10k</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">4XL</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                        <div class="text-[9px] font-extrabold text-brand-blue mt-1">+15k</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[10px] font-extrabold text-gray-900 mb-1">5XL</div>
                                        <input type="text" value="0" class="w-full text-center border border-gray-200 rounded-xl py-2.5 text-sm font-semibold text-gray-400 outline-none focus:border-brand-blue focus:text-gray-800 transition shadow-sm">
                                        <div class="text-[9px] font-extrabold text-brand-blue mt-1">+20k</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Add on -->
                            <button class="w-full flex justify-between items-center px-5 py-3.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-500 hover:border-gray-300 transition shadow-sm cursor-pointer hover:bg-gray-50">
                                <span>Tambah Add On</span>
                                <i class="fa-solid fa-plus text-gray-400"></i>
                            </button>
                        </div>
                        
                        <!-- Divider Line -->
                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-dashed border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-[#f4f7f9] px-4 text-sm font-bold text-gray-500 flex items-center gap-1.5 cursor-pointer hover:text-gray-700 transition">
                                    Tambah Pesanan <i class="fa-solid fa-circle-plus"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Box 2: Upload Design -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                            <h2 class="text-lg font-extrabold text-gray-900 mb-4">Upload Design</h2>
                            <div class="w-full border-2 border-dashed border-gray-200 rounded-2xl p-10 flex flex-col items-center justify-center text-center bg-gray-50/50 hover:bg-gray-50 transition cursor-pointer group">
                                <div class="w-12 h-12 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 mb-4 group-hover:text-brand-blue group-hover:border-indigo-100 group-hover:bg-brand-bluelight transition">
                                    <i class="fa-solid fa-arrow-up-from-bracket text-lg"></i>
                                </div>
                                <h4 class="font-extrabold text-gray-800 mb-1.5 text-[15px]">Upload Desain (mock)</h4>
                                <p class="text-xs text-gray-400 font-bold tracking-wide">PNG, JPG, AI, PSD &mdash; MAX 10MB</p>
                            </div>
                        </div>

                        <!-- Box 3: Deadline & Catatan -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                            <h2 class="text-lg font-extrabold text-gray-900 mb-6">Deadline & Catatan</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Estimasi Deadline</label>
                                    <div class="relative">
                                        <input type="text" placeholder="Pilih Estimasi Deadline" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition">
                                        <i class="fa-regular fa-calendar text-gray-400 text-sm absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-2">Catatan / Instruksi Khusus</label>
                                    <textarea rows="4" placeholder="Detail sablon, bordir, desain file, dll..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Summary Stick Area -->
                    <div class="w-full lg:w-96 shrink-0 relative">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-0">
                            <h2 class="text-lg font-extrabold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                            
                            <div class="space-y-5 text-sm font-semibold mb-6">
                                <div class="flex justify-between items-center text-gray-500">
                                    <span>Produk Base</span>
                                    <span class="text-gray-900 font-bold">Rp 97.000 / pcs</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-500">
                                    <span>Total Kuantitas</span>
                                    <span class="text-gray-900 font-bold">36 pcs</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-500">
                                    <span>Biaya Material (PQ 30s)</span>
                                    <span class="text-gray-900 font-bold">+Rp 144.000</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-500">
                                    <span>Biaya Ukuran (XL+)</span>
                                    <span class="text-gray-900 font-bold">+Rp 0</span>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-100 py-6 mb-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-extrabold text-gray-900 tracking-wide text-xs uppercase">Estimasi Total</span>
                                    <span class="font-extrabold text-brand-blue text-xl">Rp 3.636.000</span>
                                </div>
                            </div>
                            
                            <button class="w-full bg-brand-blue text-white rounded-xl py-4 font-bold hover:bg-indigo-700 transition shadow-[0_6px_16px_-6px_rgba(79,70,229,0.5)] flex items-center justify-center gap-2 mb-4">
                                Pesan Sekarang <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                            
                            <p class="text-[10px] text-gray-400 leading-tight font-medium">
                                Dengan menekan tombol di atas, tim Senta Print akan segera menghubungi Anda untuk konfirmasi desain dan pembayaran.
                            </p>
                        </div>
                    </div>

                </div>
@endsection
