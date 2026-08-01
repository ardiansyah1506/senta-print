@props(['role' => 'Admin', 'title' => 'Dashboard'])

@php 
    $user = Auth::user(); 
    $userName = $user ? $user->name : 'Senta User';
@endphp
        <header class="bg-white h-16 flex items-center justify-between px-4 md:px-8 shrink-0 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative z-10 border-b border-gray-100">
            <!-- Left: Mobile Toggle & Breadcrumb -->
            <div class="flex items-center gap-3 text-sm font-medium text-gray-500">
                <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-gray-600 hover:text-brand-blue p-1.5 rounded-lg border border-gray-200 focus:outline-none transition">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <span class="hover:text-gray-800 cursor-pointer hidden sm:inline">{{ $role }}</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-1 sm:mx-2 hidden sm:inline"></i>
                <span class="text-gray-900 font-bold truncate max-w-[150px] sm:max-w-none">{{ $title }}</span>
            </div>

            <!-- Right Menus -->
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 text-gray-400">
                    <button class="hover:text-gray-700 transition relative">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                    </button>
                    <button class="hover:text-gray-700 transition relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                </div>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-brand-blue flex items-center justify-center font-bold text-sm shadow-inner uppercase">
                        {{ substr($userName, 0, 1) }}
                    </div>
                    <div class="text-sm font-semibold text-gray-700 group-hover:text-brand-blue transition">{{ $userName }}</div>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400"></i>
                </div>
            </div>
        </header>
