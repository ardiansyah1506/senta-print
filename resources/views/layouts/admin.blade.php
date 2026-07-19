<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senta Print - Data Master</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        sidebar: '#1a2234',
                        sidebarhover: '#252e42',
                        brand: {
                            blue: '#4f46e5', // Indigo 600
                            bluelight: '#f4f6ff', // Light slate/indigo for active tab
                            yellow: '#facc15', // Yellow 400
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex h-screen overflow-hidden selection:bg-brand-blue selection:text-white">

    <!-- Sidebar -->
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

        <!-- User Profile -->
        <div class="px-4 py-6">
            <div class="bg-sidebarhover rounded-xl p-4 flex items-center gap-3 border border-gray-700/50">
                <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center text-white font-bold shadow-inner">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="text-white text-sm font-bold truncate">Admin Senta Print</div>
                    <div class="text-[10px] font-bold bg-brand-blue/20 text-brand-blue px-2 py-0.5 rounded uppercase inline-block mt-0.5">Admin</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-sidebarhover hover:text-white transition">
                <i class="fa-solid fa-border-all w-5 text-center"></i> Dashboard
            </a>
            <a href="{{ route('admin.order.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-sidebarhover hover:text-white transition">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i> Kelola Pesanan
            </a>
            <a href="{{ route('admin.report.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-sidebarhover hover:text-white transition">
                <i class="fa-solid fa-file-lines w-5 text-center"></i> Laporan
            </a>
            <a href="{{ route('admin.master-kategori.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-lg hover:bg-brand-yellow hover:text-gray-900 shadow-sm transition">
                <i class="fa-solid fa-database w-5 text-center"></i> Data Master
            </a>
            <a href="{{ route('admin.manajemen-user.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg hover:bg-sidebarhover hover:text-white transition">
                <i class="fa-solid fa-users-gear w-5 text-center"></i> Manajemen User
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

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f4f7f9] z-0 relative">
        <!-- Topbar -->
        <header class="bg-white h-16 flex items-center justify-between px-8 shrink-0 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative z-10">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm font-medium text-gray-500">
                <span class="hover:text-gray-800 cursor-pointer">Admin</span>
                <i class="fa-solid fa-chevron-right text-[10px] mx-3"></i>
                <span class="text-gray-900 font-bold">Data Master</span>
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
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-brand-blue flex items-center justify-center font-bold text-sm shadow-inner">
                        B
                    </div>
                    <div class="text-sm font-semibold text-gray-700 group-hover:text-brand-blue transition">Budi</div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield("content")
</div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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
    </script>
</body>
</html>
