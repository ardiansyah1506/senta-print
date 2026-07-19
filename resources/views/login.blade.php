<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Senta Print</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<body class="bg-gray-50 flex h-screen items-center justify-center p-4 selection:bg-brand-blue selection:text-white font-sans antialiased">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 sm:p-10">
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-3">
                <svg class="w-10 h-10 text-brand-blue" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/>
                    <path d="M12 10.5l-3 6h6l-3-6z" fill="currentColor"/>
                </svg>
                <span class="font-extrabold text-2xl tracking-tight text-gray-900 uppercase">Senta Print</span>
            </div>
        </div>

        <h2 class="text-center text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
        <p class="text-center text-sm text-gray-500 mb-8">Please sign in to your account</p>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-semibold mb-6 flex items-start gap-3 border border-red-100">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800" placeholder="admin@sentaprint.com">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" required class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition bg-gray-50/50 text-gray-800" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-brand-blue focus:ring-brand-blue border-gray-300">
                    <span class="text-sm font-medium text-gray-600">Remember me</span>
                </label>
                <a href="#" class="text-sm font-bold text-brand-blue hover:text-indigo-800 transition">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full bg-brand-blue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
