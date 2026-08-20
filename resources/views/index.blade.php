<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo-meta', [
        'title' => 'Senta Print - Wujudkan Desain Impian dengan Kualitas Terbaik',
        'description' => 'Platform manajemen konveksi modern Senta Print. Pesan kaos, seragam, jaket, polo shirt, dan merchandise custom dengan tracking real-time dan jaminan kualitas 100%.',
        'keywords' => 'senta print, konveksi semarang, pesan kaos custom, cetak seragam, jaket hoodie custom, polo shirt custom, merchandise custom, tracking pesanan',
        'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'
    ])
    @include('partials.google-analytics')
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo_mark.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .feature-icon-container {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <x-public-navbar />

    <!-- Hero Section -->
    <section class="bg-white pt-28 pb-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight mb-6">
                Wujudkan Desain Impian<br>
                <span class="text-brand-600">dengan Kualitas Terbaik</span>
            </h1>
            <p class="text-lg text-gray-500 mb-10 max-w-2xl mx-auto">
                Platform manajemen konveksi modern. Pesan kaos, seragam, jaket, dan produk custom lainnya dengan tracking real-time dan jaminan kualitas.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-20">
                <a href="{{ route('public.order') }}" class="w-full sm:w-auto px-8 py-3.5 bg-brand-900 text-white rounded-full font-semibold hover:bg-brand-950 transition flex items-center justify-center gap-2 shadow-lg shadow-gray-200">
                    Pesan Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="#lacak-pesanan" class="w-full sm:w-auto px-8 py-3.5 bg-white text-gray-700 border border-gray-300 rounded-full font-semibold hover:bg-gray-50 transition flex items-center justify-center gap-2 cursor-pointer">
                    Lacak Invoice Anda <i data-lucide="arrow-down" class="w-4 h-4 text-brand-600"></i>
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-100 border-t border-gray-100 pt-10">
                <div class="px-4">
                    <div class="text-4xl font-extrabold text-gray-900 mb-1">500+</div>
                    <div class="text-sm text-gray-500 font-medium whitespace-nowrap">Pesanan Selesai</div>
                </div>
                <div class="px-4">
                    <div class="text-4xl font-extrabold text-gray-900 mb-1">50+</div>
                    <div class="text-sm text-gray-500 font-medium whitespace-nowrap">Klien Puas</div>
                </div>
                <div class="px-4">
                    <div class="text-4xl font-extrabold text-gray-900 mb-1">99%</div>
                    <div class="text-sm text-gray-500 font-medium whitespace-nowrap">Tepat Waktu</div>
                </div>
                <div class="px-4">
                    <div class="text-4xl font-extrabold text-gray-900 mb-1 flex items-center justify-center gap-2">
                        5.0 <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i>
                    </div>
                    <div class="text-sm text-gray-500 font-medium whitespace-nowrap">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                <!-- Text Content (On desktop: Title, text, button; On mobile: Title & text only) -->
                <div class="lg:w-1/2 w-full flex flex-col items-start">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                        Pilih Produk Favoritmu<br>
                        dari <span class="text-brand-600">Katalog Kami</span>
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 mb-6 lg:mb-8 leading-relaxed">
                        Beragam pilihan produk konveksi tersedia untuk kebutuhan komunitas, perusahaan, sekolah, hingga event. Semua dapat dikustom sesuai desain, warna, dan kebutuhan Anda.
                    </p>
                    <a href="katalog.pdf" target="_blank" class="hidden lg:inline-flex items-center justify-center px-8 py-3.5 bg-brand-900 text-white rounded-full font-semibold hover:bg-brand-950 transition shadow-lg shadow-gray-200">
                        Lihat Katalog Kami
                    </a>
                </div>

                <!-- Image Content (Slider with 3 photos) -->
                <div class="lg:w-1/2 w-full">
                    <div class="relative bg-gray-100 rounded-3xl p-4 sm:p-8 shadow-sm">
                        <!-- Red Badge -->
                        <div class="absolute -top-3 -right-3 sm:-top-4 sm:-right-4 bg-red-600 text-white rounded-full w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center shadow-lg shadow-red-500/30 z-20 border-4 border-white">
                            <i data-lucide="award" class="w-5 h-5 sm:w-7 sm:h-7"></i>
                        </div>

                        <!-- 3 Photo Carousel Container -->
                        <div class="relative w-full h-72 sm:h-80 overflow-hidden rounded-xl">
                            <!-- Slide 1 -->
                            <div class="catalog-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100" data-index="0">
                                <img src="https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&q=80&w=800&h=600" alt="Polo Shirt Senta Print" class="w-full h-full object-cover rounded-xl shadow-md mix-blend-multiply filter contrast-125">
                                <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-xs text-white text-xs px-3 py-1 rounded-full font-semibold">Kaos & Polo Custom</div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="catalog-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0" data-index="1">
                                <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?auto=format&fit=crop&q=80&w=800&h=600" alt="Jaket Hoodie Senta Print" class="w-full h-full object-cover rounded-xl shadow-md mix-blend-multiply filter contrast-125">
                                <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-xs text-white text-xs px-3 py-1 rounded-full font-semibold">Jaket & Hoodie Komunitas</div>
                            </div>
                            <!-- Slide 3 -->
                            <div class="catalog-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0" data-index="2">
                                <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?auto=format&fit=crop&q=80&w=800&h=600" alt="Seragam Kemeja Senta Print" class="w-full h-full object-cover rounded-xl shadow-md mix-blend-multiply filter contrast-125">
                                <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-xs text-white text-xs px-3 py-1 rounded-full font-semibold">Seragam & Kemeja PDH</div>
                            </div>
                        </div>
                    </div>

                    <!-- Dots Indicators -->
                    <div class="flex justify-center gap-2 mt-6">
                        <button type="button" class="catalog-dot w-3 h-3 rounded-full bg-brand-600 transition-all cursor-pointer" onclick="setCatalogSlide(0)"></button>
                        <button type="button" class="catalog-dot w-3 h-3 rounded-full bg-gray-300 transition-all cursor-pointer" onclick="setCatalogSlide(1)"></button>
                        <button type="button" class="catalog-dot w-3 h-3 rounded-full bg-gray-300 transition-all cursor-pointer" onclick="setCatalogSlide(2)"></button>
                    </div>

                    <!-- Mobile View Only: Button placed BELOW photos -->
                    <div class="mt-8 text-center lg:hidden">
                        <a href="katalog.pdf" target="_blank" class="inline-flex items-center justify-center w-full px-8 py-3.5 bg-brand-900 text-white rounded-full font-semibold hover:bg-brand-950 transition shadow-lg shadow-gray-200">
                            Lihat Katalog Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Slider Script -->
    <script>
        let currentCatalogIndex = 0;
        let catalogInterval;

        function setCatalogSlide(index) {
            currentCatalogIndex = index;
            const slides = document.querySelectorAll('.catalog-slide');
            const dots = document.querySelectorAll('.catalog-dot');

            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.remove('opacity-0');
                    slide.classList.add('opacity-100');
                } else {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                }
            });

            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-brand-600', 'w-6');
                } else {
                    dot.classList.remove('bg-brand-600', 'w-6');
                    dot.classList.add('bg-gray-300', 'w-3');
                }
            });
        }

        function startCatalogAutoSlide() {
            catalogInterval = setInterval(() => {
                currentCatalogIndex = (currentCatalogIndex + 1) % 3;
                setCatalogSlide(currentCatalogIndex);
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            setCatalogSlide(0);
            startCatalogAutoSlide();
        });
    </script>

    <!-- Features Section -->
    <section class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    Kenapa Memilih <span class="text-brand-600">Senta?</span>
                </h2>
                <p class="text-gray-500 text-lg">
                    Hanya 4 langkah untuk mendapatkan produk konveksi berkualitas
                </p>
            </div>

            <div class="flex flex-col items-center justify-center gap-8">
                <!-- Top Row (3) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Tepat Waktu</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Team andalan dalam produksi konveksi yang menjamin kelancaran project Anda dari awal hingga selesai.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i data-lucide="package-open" class="w-7 h-7 text-brand-600"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Free Ongkir</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Yang pertama kali memberikan layanan gratis ongkir dengan minimum order yang berlaku.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i data-lucide="truck" class="w-7 h-7 text-brand-600"></i>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Free Design</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Kami selalu menyiapkan desain dengan konsep visual yang baik dan sesuai dengan fungsi dan kebutuhannya.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i data-lucide="pen-tool" class="w-7 h-7 text-brand-600"></i>
                        </div>
                    </div>
                </div>
                <!-- Bottom Row (2) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-3xl">
                    <!-- Card 4 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Guarantee</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Garansi 100% jika ada cacat dalam produksi kami yang tidak sesuai dengan order.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i data-lucide="shield-check" class="w-7 h-7 text-brand-600"></i>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Proses Kilat</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Tepat waktu dalam pengadaan, kecepatan dalam hal operasional dan menjaga amanah dari konsumen.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i data-lucide="zap" class="w-7 h-7 text-brand-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tracking Section -->
    <section id="lacak-pesanan" class="py-20 bg-gray-50 border-y border-gray-100">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                <span class="text-brand-600">Lacak Status</span> Produk Konveksi
            </h2>
            <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto">
                Masukkan nomor invoice anda untuk melihat proses pemotongan, sablon, jahit, Quality Control, hingga Pengiriman
            </p>
            <form onsubmit="event.preventDefault(); startPublicTrackFromPage();" class="bg-white p-2 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row focus-within:ring-2 focus-within:ring-brand-500 focus-within:border-brand-500 transition-shadow">
                <input type="text" id="pageInvoiceInput" placeholder="Masukkan Nomor Invoice (contoh: INV-PUB-20260726-1234)" class="w-full px-4 py-3 outline-none text-gray-700 bg-transparent rounded-lg">
                <button type="submit" class="bg-brand-900 text-white font-semibold px-8 py-3 rounded-xl hover:bg-brand-950 transition flex items-center justify-center mt-2 sm:mt-0 shadow-md gap-2">
                    Lacak <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </section>

    <!-- Testimonial Section (Updated for Konveksi & Sablon) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    Apa Kata <span class="text-brand-600">Pelanggan Kami?</span>
                </h2>
                <p class="text-gray-500 text-lg">
                    Ratusan pelanggan puas dengan kualitas konveksi & ketepatan waktu Senta Print.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 relative group hover:bg-white hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 mb-3">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3">Kualitas Sablon & Jahitan Sangat Rapi</h3>
                        <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                            "Pesan 100 pcs kaos event kantor di Senta Print hasilnya sangat memuaskan! Sablon tajam, bahan combed halus, dan pengerjaan tepat waktu."
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Avatar Rina" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Rina Sugiharti</div>
                            <div class="text-xs text-gray-500">PT. Semesta Media</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 relative group hover:bg-white hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 mb-3">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3">Seragam Kemeja & Jaket Mantap</h3>
                        <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                            "Pesanan seragam kemeja bordir dan jaket hoodie komunitas hasilnya sesuai mockup 100%. Paling suka ada fitur tracking status produksi real-time!"
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=33" alt="Avatar Siti" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Siti Rahayu</div>
                            <div class="text-xs text-gray-500">Komunitas Runner Semarang</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 relative group hover:bg-white hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 mb-3">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3">Pelayanan Fast Respon & Bergaransi</h3>
                        <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                            "Dapat garansi 100% dan konsultasi desain gratis. Tim Senta Print sangat kooperatif dari pemilihan bahan sampai pengiriman kilat."
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=68" alt="Avatar Alex" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Alex Pratama</div>
                            <div class="text-xs text-gray-500">Owner Distro & Merchandise</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-brand-950 py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">
                Siap Mewujudkan Produk Custom Anda?
            </h2>
            <p class="text-gray-300 text-lg mb-10 max-w-2xl mx-auto">
                Bergabung dengan ratusan pelanggan puas. Mulai pesanan pertama Anda hari ini.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('public.order') }}" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 text-white rounded-full font-semibold hover:bg-brand-500 transition shadow-lg shadow-brand-900/50 flex items-center justify-center gap-2">
                    Pesan Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="https://wa.me/6281380069798" target="_blank" class="w-full sm:w-auto px-8 py-3.5 bg-transparent text-white border-2 border-gray-600 rounded-full font-semibold hover:border-gray-400 hover:bg-gray-800 transition flex items-center justify-center gap-2">
                    <i data-lucide="message-circle" class="w-5 h-5"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0b1120] pt-20 pb-10 text-gray-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand Info -->
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6 text-white">
                        <img src="{{ asset('logo/logo2.png') }}" alt="Senta Print Logo" class="h-10 w-auto object-contain bg-white/10 rounded p-1">
                    </a>
                    <p class="leading-relaxed mb-6">
                        Senta Print adalah perusahaan yang bergerak di bidang produksi Konveksi dan Merchandise, dengan bergaransi utama memberikan dua hal yaitu produk dan garansi pada pembeli dengan kualitas dan tepat waktu.
                    </p>
                </div>
                
                <!-- Menu -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-xs uppercase">Menu</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Home</a></li>
                        <li><a href="{{ asset('katalog.pdf') }}" target="_blank" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Katalog</a></li>
                        <li><a href="{{ route('public.order') }}" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Pesan Sekarang</a></li>
                        <li><a href="#lacak-pesanan" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Tracking Pesanan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Testimoni</a></li>
                    </ul>
                </div>

                <!-- Layanan -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-xs uppercase">Layanan</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('public.order') }}" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Kaos Polo</a></li>
                        <li><a href="{{ route('public.order') }}" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Jaket & Hoodie</a></li>
                        <li><a href="{{ route('public.order') }}" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Seragam & Kemeja</a></li>
                        <li><a href="{{ route('public.order') }}" class="text-gray-400 hover:text-brand-400 hover:translate-x-1 inline-block transition-all duration-300">Barang Custom</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-xs uppercase">Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex gap-3 group">
                            <i data-lucide="phone" class="w-4 h-4 mt-1 text-gray-500 group-hover:text-brand-400 transition-colors duration-300"></i>
                            <a href="https://wa.me/6281380069798" target="_blank" class="text-gray-400 group-hover:text-brand-400 group-hover:translate-x-1 inline-block transition-all duration-300">+62 813 8006 9798</a>
                        </li>
                        <li class="flex gap-3 group">
                            <i data-lucide="mail" class="w-4 h-4 mt-1 text-gray-500 group-hover:text-brand-400 transition-colors duration-300"></i>
                            <a href="mailto:order@sentaprint.com" class="text-gray-400 group-hover:text-brand-400 group-hover:translate-x-1 inline-block transition-all duration-300">order@sentaprint.com</a>
                        </li>
                        <li class="flex gap-3 group cursor-default">
                            <i data-lucide="map-pin" class="w-4 h-4 mt-1 text-gray-500 group-hover:text-brand-400 transition-colors duration-300 shrink-0"></i>
                            <span class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">Jl. Sendang Utara 2, Gemah, Kec. Pedurungan, Kota Semarang, Jawa Tengah 50246</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-center items-center">
                <p>&copy; 2026 Senta Group. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" media="print" onload="this.media='all'">
    <script>
        toastr.options = { "positionClass": "toast-top-right", "timeOut": "3000" };
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if(session('error')) toastr.error("{{ session('error') }}"); @endif
        function renderLucide() {
            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', renderLucide);
        } else {
            renderLucide();
        }
        window.addEventListener('load', renderLucide);
        setTimeout(renderLucide, 100);
        setTimeout(renderLucide, 500);
    </script>
    @include('partials.tracking-modal')
    <x-public-promo-banner />
</body>
</html>
