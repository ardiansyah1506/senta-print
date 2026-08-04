<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageTitle = trim($__env->yieldContent('title', 'Dashboard'));
        $fullTitle = $pageTitle . ' - Dashboard Admin Senta Print';
    @endphp
    @include('partials.seo-meta', [
        'title' => $fullTitle,
        'description' => 'Panel administrator Senta Print untuk pengelolaan pesanan, master data, ukuran, dan laporan.',
        'robots' => 'noindex, nofollow'
    ])
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo_mark.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex h-screen overflow-hidden selection:bg-brand-blue selection:text-white">

    <!-- Sidebar -->
    <x-sidebar-admin />

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f4f7f9] z-0 relative">
        <!-- Topbar -->
        <x-dashboard-topbar role="Admin" :title="$pageTitle" :parentTitle="trim($__env->yieldContent('parent_title')) ?: null" />

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield("content")
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebarDrawer');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar && backdrop) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = { 
            "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", 
            "timeOut": "3000", "showEasing": "swing", "hideEasing": "linear", 
            "showMethod": "fadeIn", "hideMethod": "fadeOut" 
        };
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if(session('error')) toastr.error("{{ session('error') }}"); @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        function renderLucide() {
            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', renderLucide);
        } else {
            renderLucide();
        }
        window.addEventListener('load', renderLucide);
        setTimeout(renderLucide, 100);
        setTimeout(renderLucide, 500);
    </script>
</body>
</html>
