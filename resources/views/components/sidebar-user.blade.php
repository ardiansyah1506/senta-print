@php 
    $user = Auth::user(); 
    $userName = $user ? $user->name : 'Customer';
@endphp
    <aside class="w-64 bg-sidebar text-gray-300 flex flex-col h-full shrink-0 border-r border-gray-800 z-10 relative">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-gray-800/50">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/>
                    <path d="M12 10.5l-3 6h6l-3-6z" fill="currentColor"/>
                </svg>
                <span class="font-extrabold text-lg tracking-wider text-white uppercase">Senta Print</span>
            </div>
        </div>

        <!-- User Profile (Customer) -->
        <div class="px-4 py-6">
            <div class="bg-sidebarhover rounded-xl p-4 flex items-center gap-3 border border-gray-700/50">
                <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center text-white font-bold shadow-inner uppercase">
                    {{ substr($userName, 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="text-white text-sm font-bold truncate">{{ $userName }}</div>
                    <div class="text-[10px] font-bold bg-emerald-900/60 text-emerald-400 px-2 py-0.5 rounded uppercase inline-block mt-0.5 tracking-wide">CUSTOMER</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a href="{{ route('user.order.create') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('user.order.create') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i class="fa-solid fa-cart-arrow-down w-5 text-center"></i> Buat Pesanan
            </a>
            <a href="{{ route('user.order.track') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('user.order.track') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i> Lacak Pesanan
            </a>
            <a href="{{ route('user.order.history') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('user.order.history') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i> Riwayat Pemesanan
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 mt-auto border-t border-gray-800/50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-sidebarhover hover:text-white transition text-gray-400">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Log out
                </button>
            </form>
        </div>
    </aside>
