    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                        <i class="fa-solid fa-print text-xl"></i>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tight text-gray-900">Senta<span class="text-brand-600">Print</span></span>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg font-semibold transition {{ Request::routeIs('home') ? 'text-brand-600 bg-brand-50' : 'text-gray-600 hover:text-brand-600 hover:bg-gray-50' }}">Beranda</a>
                    <a href="{{ route('public.order') }}" class="px-4 py-2 rounded-lg font-semibold transition {{ Request::routeIs('public.order*') ? 'text-brand-600 bg-brand-50' : 'text-gray-600 hover:text-brand-600 hover:bg-gray-50' }}">Pesan Sekarang</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg font-semibold transition {{ Request::routeIs('login') ? 'text-brand-600 bg-brand-50' : 'text-gray-600 hover:text-brand-600 hover:bg-gray-50' }}">Cek Pesanan / Login</a>
                </div>
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button class="text-gray-600 hover:text-brand-600 focus:outline-none p-2" id="mobile-menu-btn">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
