<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo-meta', [
        'title' => 'Buat Pesanan Custom - Senta Print',
        'description' => 'Formulir pemesanan produk konveksi custom Senta Print. Pesan secara online dengan mudah.',
        'keywords' => 'buat pesanan senta print, pesan kaos custom online, cetak seragam custom, pesan hoodie semarang, kustomisasi produk konveksi',
        'robots' => 'noindex, follow'
    ])
    @include('partials.google-analytics')
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo_mark.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    
    <!-- Navbar -->
    <x-public-navbar />

    <div class="max-w-3xl mx-auto pb-10 px-4 sm:px-6 pt-24">
        
        @if(session('order_success'))
            @php $succ = session('order_success'); @endphp
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-8 text-center text-emerald-800 mb-8 shadow-sm">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h2 class="text-2xl font-extrabold mb-2">Invoice {{ $succ['invoice_no'] }} Berhasil Dibuat</h2>
                <p class="text-emerald-700 font-medium mb-6">Halo {{ $succ['nama_pemesan'] }}, permintaan pesanan Anda telah tersimpan di sistem kami.</p>
                
                <p class="text-sm font-bold bg-white p-4 rounded-xl border border-emerald-200 inline-block">
                    Silakan tunggu konfirmasi selanjutnya dari Admin kami melalui WhatsApp ke <span class="text-gray-900 font-extrabold">{{ $succ['no_whatsapp'] }}</span>.
                </p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="font-bold text-sm bg-emerald-600 text-white px-6 py-3 rounded-full hover:bg-emerald-700 transition">Kembali ke Beranda</a>
                </div>
            </div>
        @else

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Buat Pesanan <span class="bg-brand-blue text-white text-xs px-3 py-1 rounded-full font-bold ml-2">Jalur Public</span></h1>
            <p class="text-gray-500 text-sm font-medium">Bebas antrian, konsultasi sebebas mungkin. Langsung terhubung dengan Tim Senta Print.</p>
        </div>

        <form action="{{ route('public.order.store') }}" method="POST" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
            @csrf
            
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemesan" required placeholder="Budi Santoso" class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50 focus:bg-white text-gray-800">
                </div>
                
                <!-- Phone -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="no_whatsapp" required placeholder="081234567890" class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-semibold outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50 focus:bg-white text-gray-800">
                    <p class="text-xs text-gray-500 mt-2 font-medium"><i class="fa-brands fa-whatsapp text-emerald-500"></i> Invoice akan dikaitkan dan dikirim ke No. HP ini</p>
                </div>
                
                <!-- Notes -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Pesanan <span class="text-red-500">*</span></label>
                    <textarea name="notes" rows="4" required placeholder="Contoh: Pesan Sesuai kesepakatan di WA (1 lusin PDH custom, ukuran campur)..." class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-semibold text-gray-800 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50 focus:bg-white resize-none"></textarea>
                    <p class="text-xs text-gray-500 mt-2 font-medium">Berikan rincian singkat tentang pesanan Anda agar Admin kami dapat memprosesnya dengan cepat dan tepat.</p>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full bg-brand-blue text-white rounded-2xl py-4 font-bold text-sm hover:bg-indigo-700 transition shadow-[0_6px_16px_-6px_rgba(79,70,229,0.5)] flex items-center justify-center gap-2">
                        Kirim Permintaan Pesanan Sekarang <i class="fa-solid fa-paper-plane text-xs"></i>
                    </button>
                    <p class="text-xs text-gray-400 mt-4 leading-relaxed text-center">
                        Pesanan ini akan segera ditinjau oleh tim Senta Print. Kami akan menginputkan rincian biaya yang nantinya dapat Anda cek melalui invoice konfirmasi.
                    </p>
                </div>
            </div>
        </form>

        @endif

    </div>
</body>
</html>
