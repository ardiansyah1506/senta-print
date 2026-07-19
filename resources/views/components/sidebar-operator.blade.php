@php 
    $user = Auth::user(); 
    $userName = $user ? $user->name : 'Operator';
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

        <!-- User Profile (Operator) -->
        <div class="px-4 py-6">
            <div class="bg-sidebarhover rounded-xl p-4 flex items-center gap-3 border border-gray-700/50">
                <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center text-white font-bold shadow-inner uppercase">
                    {{ substr($userName, 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="text-white text-sm font-bold truncate">{{ $userName }}</div>
                    <div class="text-[10px] font-bold bg-[#804000]/60 text-orange-400 border border-orange-900/30 px-2 py-0.5 rounded uppercase inline-block mt-0.5 tracking-wide">OPERATOR</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a href="{{ route('operator.production.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition {{ Request::routeIs('operator.production.*', 'operator.tracking*') ? 'font-bold bg-brand-yellow text-gray-900 shadow-sm' : 'font-medium hover:bg-sidebarhover hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i> Kelola Produksi
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
