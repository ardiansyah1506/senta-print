@extends('layouts.user')
@section('title', 'Buat Pesanan')
@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Buat Pesanan Baru</h1>
        <p class="text-gray-500 text-sm font-medium">Isi detail pesanan konveksi Anda</p>
    </div>

    <form action="{{ route('user.order.store') }}" method="POST" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
        @csrf
        
        <div class="space-y-6">
            <!-- Notes -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Pesanan <span class="text-red-500">*</span></label>
                <textarea name="notes" rows="6" required placeholder="Contoh: Pesan Sesuai kesepakatan di WA (1 lusin PDH custom, ukuran campur)..." class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-semibold text-gray-800 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50 focus:bg-white resize-none"></textarea>
                <p class="text-xs text-gray-500 mt-2 font-medium">Berikan rincian singkat tentang pesanan Anda agar Admin kami dapat memprosesnya dengan cepat dan tepat.</p>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full bg-brand-blue text-white rounded-2xl py-4 font-bold text-sm hover:bg-indigo-700 transition shadow-[0_6px_16px_-6px_rgba(79,70,229,0.5)] flex items-center justify-center gap-2">
                    Kirim Permintaan Pesanan Sekarang <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
                <p class="text-xs text-gray-400 mt-4 leading-relaxed text-center">
                    Pesanan ini akan segera ditinjau oleh tim Senta Print dan dikaitkan ke Nomor WhatsApp terdaftar Anda. Kami akan menginputkan rincian biaya yang nantinya dapat Anda cek melalui invoice konfirmasi.
                </p>
            </div>
        </div>
    </form>
</div>
@endsection
