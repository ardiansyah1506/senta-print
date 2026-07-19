<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senta Print - Kelola Produksi</title>
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
                            bluelight: '#e0e7ff',
                            yellow: '#facc15', // Yellow 400
                        }
                    }
                }
            }
        }

        // Popup logic
        function openPopup() {
            document.getElementById('detailPopup').classList.remove('hidden');
        }
        function closePopup() {
            document.getElementById('detailPopup').classList.add('hidden');
        }
    </script>
</head>
<body class="bg-[#f4f7f9] text-gray-800 antialiased flex h-screen overflow-hidden selection:bg-brand-blue selection:text-white relative">

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

        <!-- User Profile (Operator) -->
        <div class="px-4 py-6">
            <div class="bg-sidebarhover rounded-xl p-4 flex items-center gap-3 border border-gray-700/50">
                <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center text-white font-bold shadow-inner">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="text-white text-sm font-bold truncate">OP Senta Print</div>
                    <div class="text-[10px] font-bold bg-[#804000]/60 text-orange-400 border border-orange-900/30 px-2 py-0.5 rounded uppercase inline-block mt-0.5 tracking-wide">OPERATOR</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a href="kelolaproduksi.html" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-lg bg-brand-yellow text-gray-900 shadow-sm transition">
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

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f4f7f9] z-0 relative">
        <!-- Topbar -->
        <header class="bg-white h-16 flex items-center justify-between px-8 shrink-0 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative z-10 border-b border-gray-100">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm font-medium text-gray-500">
                <span class="hover:text-gray-800 cursor-pointer">Operator</span>
                <i class="fa-solid fa-chevron-right text-[10px] mx-3"></i>
                <span class="text-gray-900 font-bold">Kelola Produksi</span>
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

    <!-- Modal Popup / Dialog Overlay -->
    <div id="detailPopup" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center hidden opacity-100 transition-opacity backdrop-blur-sm">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-3xl mx-4 overflow-hidden border border-gray-100 relative">
            <!-- Header -->
            <div class="px-8 py-6 border-b border-gray-100 bg-white">
                <h2 class="text-xl font-extrabold text-gray-900">Detail & Update: ORD-039</h2>
            </div>
            
            <!-- Body -->
            <div class="px-8 py-8 grid grid-cols-1 md:grid-cols-2 gap-10 bg-white">
                <!-- Left: Riwayat -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-gray-900 border-b border-gray-100 pb-3">Riwayat Produksi</h3>
                    <p class="text-sm font-medium text-gray-400 italic pt-1">Belum ada riwayat update.</p>
                </div>
                
                <!-- Right: Form Update -->
                <div class="bg-gray-50/50 rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-sm font-extrabold text-gray-900 mb-5">Form Update Baru</h3>
                    
                    <form class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Tahap Selesai <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-500 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue appearance-none transition bg-white">
                                    <option>Pilih tahap...</option>
                                    <option>Pemotongan</option>
                                    <option>Penjahitan</option>
                                    <option>Sablon</option>
                                    <option>Finishing</option>
                                    <option>QC</option>
                                </select>
                                <i class="fa-solid fa-chevron-down text-gray-400 text-xs absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Keterangan <span class="text-red-500">*</span></label>
                            <textarea rows="3" placeholder="Deskripsikan pekerjaan yang telah selesai..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition resize-none"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Foto Bukti Pengerjaan <span class="text-red-500">*</span></label>
                            <div class="w-full border-2 border-dashed border-gray-200 rounded-xl p-6 flex flex-col items-center justify-center text-center bg-white hover:bg-gray-50 transition cursor-pointer group">
                                <i class="fa-solid fa-arrow-up-from-bracket text-[22px] text-gray-500 group-hover:text-brand-blue mb-3 transition"></i>
                                <span class="text-xs text-gray-500 font-semibold group-hover:text-brand-blue transition">Pilih file gambar</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 justify-between pt-2">
                            <button type="button" onclick="closePopup()" class="px-5 py-2.5 rounded-xl border border-brand-blue text-brand-blue hover:bg-brand-bluelight transition text-sm font-bold w-full text-center">
                                Tutup
                            </button>
                            <button type="button" class="px-5 py-2.5 rounded-xl bg-brand-blue text-white hover:bg-indigo-700 transition shadow-[0_4px_12px_-4px_rgba(79,70,229,0.5)] text-sm font-bold w-full text-center whitespace-nowrap">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
