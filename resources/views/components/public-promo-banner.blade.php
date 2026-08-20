@php
    $activeBanner = \App\Models\Banner::where('is_active', true)->first();
@endphp

@if($activeBanner)
<div x-data="{ 
        showPromo: false, 
        init() { 
            // Cek apakah user sudah melihat promo di session ini
            if(!sessionStorage.getItem('promo_seen')) { 
                setTimeout(() => { this.showPromo = true; }, 800); 
            } 
        }, 
        closePromo() {
            this.showPromo = false; 
            sessionStorage.setItem('promo_seen', 'true');
        } 
    }"
    x-show="showPromo"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
    style="display: none;">
    
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closePromo()"></div>

    <!-- Modal Content -->
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">
        <!-- Close Button -->
        <button @click="closePromo()" class="absolute top-4 right-4 z-10 bg-black/20 hover:bg-black/40 backdrop-blur-md text-white rounded-full w-8 h-8 flex items-center justify-center transition focus:outline-none">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Banner Image -->
        <img src="{{ asset('storage/' . $activeBanner->photo) }}" alt="Special Promo" class="w-full h-auto max-h-[75vh] object-cover sm:object-contain bg-gray-100">
    </div>
</div>
@endif
