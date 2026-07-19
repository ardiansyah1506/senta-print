<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senta Print - Admin</title>
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
    <x-sidebar-admin />

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f4f7f9] z-0 relative">
        <!-- Topbar -->
        <x-dashboard-topbar role="Admin" title="Dasbor" />

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield("content")
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
