<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo-meta', [
        'title' => 'Detail Produk - ' . $product->product_name,
        'description' => 'Detail produk ' . $product->product_name,
        'robots' => 'index, follow'
    ])
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo_mark.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo_mark.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">
    <!-- Navbar -->
    <x-public-navbar />
    
    <div class="pt-28 pb-16 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
        <a href="{{ route('public.catalog') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-brand-600 mb-8 transition group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>

        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <!-- Product Image -->
                <div class="w-full md:w-1/2 p-4 md:p-8">
                    @if($product->photo)
                        <img src="{{ asset('storage/' . $product->photo) }}" class="w-full h-auto max-h-[500px] object-cover rounded-3xl shadow-sm" alt="{{ $product->product_name }}">
                    @else
                        <div class="w-full aspect-square bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 border border-gray-200">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col justify-center border-t md:border-t-0 md:border-l border-gray-100 bg-gray-50/50">
                    <div class="mb-3">
                        <span class="inline-block px-3 py-1 bg-brand-100 text-brand-700 text-[10px] font-extrabold rounded-full uppercase tracking-wider">{{ $product->category->name ?? 'Kategori' }}</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $product->product_name }}</h1>
                    <p class="text-gray-400 text-sm font-semibold mb-8 uppercase tracking-wider">Kode: <span class="text-gray-600">{{ $product->product_code }}</span></p>

                    @if($product->prices->isNotEmpty())
                    <div class="mb-10">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 tracking-wide uppercase">Pricelist Grosir</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($product->prices as $priceTier)
                            <div class="bg-white border border-gray-200 rounded-2xl p-4 flex justify-between items-center text-sm shadow-sm">
                                <span class="font-bold text-gray-700">
                                    {{ $priceTier->min_qty }} @if($priceTier->max_qty)- {{ $priceTier->max_qty }}@else+ @endif pcs
                                </span>
                                <span class="font-extrabold text-brand-600">Rp {{ number_format($priceTier->price, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="mb-10 text-gray-500 text-sm font-medium">Hubungi CS untuk informasi harga produk ini.</div>
                    @endif

                    <div class="flex flex-col gap-4 mt-auto">
                        <a href="{{ route('public.order') }}" class="w-full bg-brand-900 hover:bg-brand-950 text-white font-bold py-4 px-6 rounded-2xl text-center shadow-xl shadow-brand-900/20 transition-all hover:-translate-y-0.5">Mulai Pesan Sekarang</a>
                        <a href="https://wa.me/6281380069798" target="_blank" class="w-full bg-white hover:bg-gray-50 text-gray-800 border border-gray-200 font-bold py-4 px-6 rounded-2xl text-center transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            Tanya Customer Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
