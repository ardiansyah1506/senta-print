@php
    $activeBanner = \App\Models\Banner::where('is_active', true)->first();
@endphp

@if($activeBanner)
<div x-data="{ 
        showPromo: false, 
        init() { 
            setTimeout(() => { this.showPromo = true; }, 800); 
        }, 
        closePromo() {
            this.showPromo = false; 
        } 
    }"
    x-show="showPromo"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
    style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="showPromo"
         class="absolute inset-0 bg-transparent" 
         @click="closePromo()"></div>

    <!-- Modal Content -->
    <div x-show="showPromo"
         x-transition:enter="transition ease-out duration-500 transform"
         x-transition:enter-start="opacity-0 translate-y-12 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-12 scale-95"
         class="relative max-w-[85%] sm:max-w-md md:max-w-lg mx-auto flex justify-center items-center pointer-events-none">
        
        <div class="relative inline-block pointer-events-auto">
            <!-- Close Button (Positioned Outside to float) -->
            <button @click="closePromo()" class="absolute -top-8 -right-8 md:-top-14 md:-right-14 lg:-top-16 lg:-right-16 z-[110] bg-white text-gray-800 hover:text-red-600 hover:-translate-y-1 hover:scale-110 shadow-2xl border border-gray-100 rounded-full w-10 h-10 md:w-12 md:h-12 flex items-center justify-center transition-all duration-300 focus:outline-none">
                <i class="fa-solid fa-xmark text-lg md:text-xl"></i>
            </button>

            <!-- Banner Image -->
            <img src="{{ asset('storage/' . $activeBanner->photo) }}" alt="Special Promo" class="w-full h-auto max-h-[75vh] object-contain drop-shadow-2xl filter">
        </div>
    </div>
</div>
@endif
