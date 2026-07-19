@props(['role' => 'Admin', 'title' => 'Dashboard'])

@php 
    $user = Auth::user(); 
    $userName = $user ? $user->name : 'Senta User';
@endphp
        <header class="bg-white h-16 flex items-center justify-between px-8 shrink-0 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative z-10 border-b border-gray-100">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm font-medium text-gray-500">
                <span class="hover:text-gray-800 cursor-pointer">{{ $role }}</span>
                <i class="fa-solid fa-chevron-right text-[10px] mx-3"></i>
                <span class="text-gray-900 font-bold">{{ $title }}</span>
            </div>

            <!-- Right Menus -->
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 text-gray-400">
                    <button class="hover:text-gray-700 transition relative">
                        <i class="fa-regular fa-circle-question text-lg"></i>
                    </button>
                    <button class="hover:text-gray-700 transition relative">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                </div>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-brand-blue flex items-center justify-center font-bold text-sm shadow-inner uppercase">
                        {{ substr($userName, 0, 1) }}
                    </div>
                    <div class="text-sm font-semibold text-gray-700 group-hover:text-brand-blue transition">{{ $userName }}</div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
                </div>
            </div>
        </header>
