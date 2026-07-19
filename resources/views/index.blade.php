<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senta Print - Wujudkan Desain Impian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e293b', // Dark background
                            950: '#0f172a', // Darker background
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .feature-icon-container {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <nav class="bg-white sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-brand-900" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/>
                        <path d="M12 10.5l-3 6h6l-3-6z" fill="currentColor"/>
                    </svg>
                    <span class="font-extrabold text-xl tracking-tight text-brand-900 uppercase">Senta Print</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-sm font-semibold text-gray-600 hover:text-brand-600 transition">Masuk</a>
                    <a href="#" class="text-sm font-semibold text-brand-900 border border-gray-200 px-5 py-2.5 rounded-full hover:border-gray-300 hover:bg-gray-50 transition">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-white pt-20 pb-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight mb-6">
                Wujudkan Desain Impian<br>
                <span class="text-brand-600">dengan Kualitas Terbaik</span>
            </h1>
            <p class="text-lg text-gray-500 mb-10 max-w-2xl mx-auto">
                Platform manajemen konveksi modern. Pesan kaos, seragam, jaket, dan produk custom lainnya dengan tracking real-time dan jaminan kualitas.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-20">
                <a href="#" class="w-full sm:w-auto px-8 py-3.5 bg-brand-900 text-white rounded-full font-semibold hover:bg-brand-950 transition flex items-center justify-center gap-2 shadow-lg shadow-gray-200">
                    Pesan Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
                <a href="#" class="w-full sm:w-auto px-8 py-3.5 bg-white text-gray-700 border border-gray-300 rounded-full font-semibold hover:bg-gray-50 transition flex items-center justify-center">
                    Lacak Invoice Anda
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
                        5.0 <i class="fa-solid fa-star text-xl mt-1"></i>
                    </div>
                    <div class="text-sm text-gray-500 font-medium whitespace-nowrap">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                        Pilih Produk Favoritmu<br>
                        dari <span class="text-brand-600">Katalog Kami</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Beragam pilihan produk konveksi tersedia untuk kebutuhan komunitas, perusahaan, sekolah, hingga event. Semua dapat dikustom sesuai desain, warna, dan kebutuhan Anda.
                    </p>
                    <a href="#" class="inline-flex items-center justify-center px-8 py-3.5 bg-brand-900 text-white rounded-full font-semibold hover:bg-brand-950 transition shadow-lg shadow-gray-200">
                        Lihat Katalog Kami
                    </a>
                </div>
                <!-- Image Content -->
                <div class="lg:w-1/2 w-full">
                    <div class="relative bg-gray-100 rounded-3xl p-8 shadow-sm">
                        <!-- Red Badge -->
                        <div class="absolute -top-4 -right-4 bg-red-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg shadow-red-200 z-10 border-4 border-white">
                            <i class="fa-solid fa-award text-2xl"></i>
                        </div>
                        <img src="https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&q=80&w=800&h=600" alt="Polo Shirt Senta Print" class="w-full h-80 object-cover rounded-xl shadow-md mix-blend-multiply filter contrast-125" style="object-position: center;">
                    </div>
                    <!-- Dots -->
                    <div class="flex justify-center gap-2 mt-6">
                        <div class="w-2.5 h-2.5 rounded-full bg-brand-600"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-300"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            <i class="fa-solid fa-box-open text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Free Ongkir</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Yang pertama kali memberikan layanan gratis ongkir dengan minimum order yang berlaku.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i class="fa-solid fa-truck-fast text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Free Design</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Kami selalu menyiapkan desain dengan konsep visual yang baik dan sesuai dengan fungsi dan kebutuhannya.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i class="fa-solid fa-pen-ruler text-xl"></i>
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
                            <i class="fa-solid fa-shield-check text-xl"></i>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition duration-300">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Proses Kilat</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                            Tepat waktu dalam pengadaan, kecepatan dalam hal operasional dan menjaga amanah dari konsumen.
                        </p>
                        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center bg-brand-50 text-brand-600 border border-brand-100 shadow-sm">
                            <i class="fa-solid fa-bolt text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tracking Section -->
    <section class="py-20 bg-gray-50 border-y border-gray-100">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                <span class="text-brand-600">Lacak Status</span> Produk Konveksi
            </h2>
            <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto">
                Masukkan nomor invoice anda untuk melihat proses pemotongan, sablon, jahit, Quality Control, hingga Pengiriman
            </p>
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row focus-within:ring-2 focus-within:ring-brand-500 focus-within:border-brand-500 transition-shadow">
                <input type="text" placeholder="Masukkan Nomor Invoice (contoh: INV-2026-001)" class="w-full px-4 py-3 outline-none text-gray-700 bg-transparent rounded-lg">
                <button class="bg-brand-900 text-white font-semibold px-8 py-3 rounded-xl hover:bg-brand-950 transition flex items-center justify-center mt-2 sm:mt-0 shadow-md">
                    Lacak <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    Apa Kata <span class="text-brand-600">Pelanggan Kami?</span>
                </h2>
                <p class="text-gray-500 text-lg">
                    Ratusan pelanggan puas dengan layanan Senta Print.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 relative group hover:bg-white hover:shadow-xl transition duration-300">
                    <h3 class="font-bold text-gray-900 mb-3">The best Figma Templates</h3>
                    <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                        These templates saved me tons of sweet time. They're modern, flexible, and extremely just better to style on my project.
                    </p>
                    <div class="flex items-center gap-4 mt-auto">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Rina Sugiharti</div>
                            <div class="text-xs text-gray-500">PT. Semesta</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 relative group hover:bg-white hover:shadow-xl transition duration-300">
                    <h3 class="font-bold text-gray-900 mb-3">The best Figma Templates</h3>
                    <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                        These templates saved me tons of sweet time. They're modern, flexible, and extremely just better to style on my project.
                    </p>
                    <div class="flex items-center gap-4 mt-auto">
                        <img src="https://i.pravatar.cc/150?img=33" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Siti Rahayu</div>
                            <div class="text-xs text-gray-500">PT. Makmur</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 relative group hover:bg-white hover:shadow-xl transition duration-300">
                    <h3 class="font-bold text-gray-900 mb-3">The best Figma Templates</h3>
                    <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                        These templates saved me tons of sweet time. They're modern, flexible, and extremely just better to style on my project.
                    </p>
                    <div class="flex items-center gap-4 mt-auto">
                        <img src="https://i.pravatar.cc/150?img=68" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Alex Pratama</div>
                            <div class="text-xs text-gray-500">Founder</div>
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
                <a href="#" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 text-white rounded-full font-semibold hover:bg-brand-500 transition shadow-lg shadow-brand-900/50 flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp"></i> Pesan Sekarang
                </a>
                <a href="#" class="w-full sm:w-auto px-8 py-3.5 bg-transparent text-white border-2 border-gray-600 rounded-full font-semibold hover:border-gray-400 hover:bg-gray-800 transition flex items-center justify-center">
                    Hubungi Kami
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
                    <div class="flex items-center gap-2 mb-6 text-white">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/>
                            <path d="M12 10.5l-3 6h6l-3-6z" fill="currentColor"/>
                        </svg>
                        <span class="font-extrabold text-lg tracking-tight uppercase">Senta Print</span>
                    </div>
                    <p class="leading-relaxed mb-6">
                        Senta Print adalah perusahaan yang bergerak di bidang produksi Konveksi dan Merchandise, dengan bergaransi utama memberikan dua hal yaitu produk dan garansi pada pembeli dengan kualitas dan tepat waktu.
                    </p>
                </div>
                
                <!-- Menu -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-xs uppercase">Menu</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="#" class="hover:text-white transition">Katalog</a></li>
                        <li><a href="#" class="hover:text-white transition">Fasilitas Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Tracking Pesanan</a></li>
                        <li><a href="#" class="hover:text-white transition">Testimoni</a></li>
                    </ul>
                </div>

                <!-- Layanan -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-xs uppercase">Layanan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition">Kaos Polo</a></li>
                        <li><a href="#" class="hover:text-white transition">Jaket & Hoodie</a></li>
                        <li><a href="#" class="hover:text-white transition">Seragam & Kemeja</a></li>
                        <li><a href="#" class="hover:text-white transition">Barang Custom</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-xs uppercase">Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <i class="fa-solid fa-phone mt-1 text-gray-500"></i>
                            <a href="#" class="hover:text-white transition">+62 812 3456 7890</a>
                        </li>
                        <li class="flex gap-3">
                            <i class="fa-solid fa-envelope mt-1 text-gray-500"></i>
                            <a href="#" class="hover:text-white transition">info@sentraprint.com</a>
                        </li>
                        <li class="flex gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-gray-500"></i>
                            <span>Jl. Semarang Raya No. 1, Semarang Indah, Semarang, Jawa Tengah</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-center items-center">
                <p>&copy; 2026 Senta Group. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
