<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Senta Print</title>
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
                        brand: {
                            blue: '#4f46e5', // Indigo 600
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex h-screen items-center justify-center p-4 selection:bg-brand-blue selection:text-white font-sans antialiased overflow-y-auto">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 sm:p-10 my-8">
        <div class="flex justify-center mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-10 h-10 text-brand-blue" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/>
                    <path d="M12 10.5l-3 6h6l-3-6z" fill="currentColor"/>
                </svg>
                <span class="font-extrabold text-2xl tracking-tight text-gray-900 uppercase">Senta Print</span>
            </div>
        </div>

        <h2 class="text-center text-2xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
        <p class="text-center text-sm text-gray-500 mb-8">Lengkapi data di bawah ini untuk mendaftar</p>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-semibold mb-6 border border-red-100">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800" placeholder="John Doe">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-bold text-gray-700 mb-1.5">No. WhatsApp</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <input type="text" name="phone" id="phone" required value="{{ old('phone') }}" class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800" placeholder="081234567890">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" required class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800" placeholder="Minimal 6 karakter">
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800" placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-blue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition mt-4">
                Daftar Akun
            </button>
            <p class="text-center text-sm text-gray-500 mt-6 pt-6 border-t border-gray-100">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-brand-blue hover:text-indigo-800 transition">Masuk di sini</a>
            </p>
        </form>
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
