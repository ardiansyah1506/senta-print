@php 
    $user = Auth::user(); 
    $userName = $user ? $user->name : 'Admin Senta Print';
@endphp
    <!-- Mobile Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Drawer -->
    <aside id="sidebarDrawer" class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar text-gray-300 flex flex-col h-full shrink-0 border-r border-gray-800 transition-transform duration-300 transform -translate-x-full md:translate-x-0 md:static md:z-10">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-gray-800/50">
            <img src="{{ asset('logo/logo2.png') }}" alt="Senta Print Logo" class="h-10 w-auto object-contain">
        </div>

        <!-- User Profile -->
        <div class="px-4 py-6">
            <div class="bg-sidebarhover rounded-xl p-4 flex items-center gap-3 border border-gray-700/50">
                <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center text-white font-bold shadow-inner uppercase">
                    {{ substr($userName, 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="text-white text-sm font-bold truncate">{{ $userName }}</div>
                    <div class="text-[10px] font-bold bg-brand-blue/20 text-brand-blue px-2 py-0.5 rounded uppercase inline-block mt-0.5">Admin</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.dashboard') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="layout-grid" class="w-5 h-5"></i> Dashboard
            </a>
            <a href="{{ route('admin.order.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.order.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i> Kelola Pesanan
            </a>
            <a href="{{ route('admin.report.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.report.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="file-text" class="w-5 h-5"></i> Laporan
            </a>
            <a href="{{ route('admin.master-kategori.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.master-kategori.*', 'admin.data-master.*', 'admin.ukuran.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="database" class="w-5 h-5"></i> Data Master
            </a>
            <a href="{{ route('admin.tahap-produksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.tahap-produksi.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="layers" class="w-5 h-5"></i> Tahap Produksi
            </a>
            <a href="{{ route('admin.manajemen-user.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.manajemen-user.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5"></i> Manajemen User
            </a>
            <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('admin.banner.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="image" class="w-5 h-5"></i> Banner Promo
            </a>
            <a href="{{ route('password.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('password.*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i data-lucide="key" class="w-5 h-5"></i> Ganti Password
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 mt-auto border-t border-gray-800/50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-sidebarhover hover:text-white transition text-gray-400">
                    <i data-lucide="log-out" class="w-5 h-5"></i> Log out
                </button>
            </form>
        </div>
    </aside>
