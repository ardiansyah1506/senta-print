@props(['role' => 'Admin', 'title' => 'Dashboard', 'parentTitle' => null])

<header class="bg-white h-16 flex items-center justify-between px-4 md:px-8 shrink-0 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative z-10 border-b border-gray-100">
    <!-- Left: Mobile Toggle & Breadcrumb Navigation -->
    <div class="flex items-center gap-2 text-sm font-medium text-gray-500">
        <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-gray-600 hover:text-brand-blue p-1.5 rounded-lg border border-gray-200 focus:outline-none transition mr-1">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        
        <span class="hover:text-gray-800 font-medium hidden sm:inline text-gray-400">{{ $role }}</span>
        
        @if($parentTitle)
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-300 hidden sm:inline"></i>
            <span class="text-gray-500 font-medium hidden sm:inline">{{ $parentTitle }}</span>
        @endif

        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-300"></i>
        <span class="text-gray-900 font-extrabold truncate max-w-[200px] sm:max-w-none text-sm md:text-base">{{ $title }}</span>
    </div>
</header>
