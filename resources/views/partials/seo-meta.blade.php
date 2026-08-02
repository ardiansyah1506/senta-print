@php
    $defaultTitle = 'Senta Print - Wujudkan Desain Impian dengan Kualitas Terbaik';
    $pageTitle = isset($title) && !empty($title) ? $title : $defaultTitle;

    $defaultDescription = 'Platform manajemen konveksi modern Senta Print. Pesan kaos, seragam, jaket, polo, dan produk custom lainnya dengan tracking real-time dan jaminan kualitas 100%.';
    $pageDescription = isset($description) && !empty($description) ? $description : $defaultDescription;

    $defaultKeywords = 'senta print, konveksi semarang, pesan kaos custom, cetak seragam, jaket hoodie custom, polo shirt custom, merchandise custom, tracking pesanan konveksi, konveksi murah';
    $pageKeywords = isset($keywords) && !empty($keywords) ? $keywords : $defaultKeywords;

    $pageAuthor = isset($author) && !empty($author) ? $author : 'Senta Group';
    $pageRobots = isset($robots) && !empty($robots) ? $robots : 'noindex, follow';
    $pageCanonical = isset($canonicalUrl) && !empty($canonicalUrl) ? $canonicalUrl : url()->current();
    $pageImage = isset($imageUrl) && !empty($imageUrl) ? $imageUrl : 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&q=80&w=1200&h=630';
    $pageType = isset($type) && !empty($type) ? $type : 'website';
    $siteName = 'Senta Print';

    $jsonLdData = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => $siteName,
        'image' => $pageImage,
        'description' => $pageDescription,
        'url' => url('/'),
        'telephone' => '+6281234567890',
        'email' => 'info@sentraprint.com',
        'priceRange' => '$$',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jl. Sendang Utara 2, Gemah, Kec. Pedurungan',
            'addressLocality' => 'Kota Semarang',
            'addressRegion' => 'Jawa Tengah',
            'postalCode' => '50246',
            'addressCountry' => 'ID'
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => '-7.01311',
            'longitude' => '110.46162'
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday'
                ],
                'opens' => '08:00',
                'closes' => '19:00'
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => [
                    'Saturday'
                ],
                'opens' => '08:00',
                'closes' => '18:00'
            ]
        ],
        'sameAs' => [
            'https://wa.me/6281234567890'
        ]
    ];
@endphp

<!-- Basic Meta Tags -->
<title>{{ $pageTitle }}</title>
<meta name="title" content="{{ $pageTitle }}">
<meta name="description" content="{{ $pageDescription }}">
<meta name="keywords" content="{{ $pageKeywords }}">
<meta name="author" content="{{ $pageAuthor }}">
<meta name="robots" content="{{ $pageRobots }}">
<link rel="canonical" href="{{ $pageCanonical }}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('logo/logo_mark.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('logo/logo_mark.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logo/logo_mark.png') }}">

<!-- Open Graph / Facebook / WhatsApp Meta Tags -->
<meta property="og:type" content="{{ $pageType }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $pageCanonical }}">
<meta property="og:image" content="{{ $pageImage }}">
<meta property="og:locale" content="id_ID">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@@sentaprint">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">

<!-- Structured Data / JSON-LD Schema.org -->
<script type="application/ld+json">
{!! json_encode($jsonLdData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<!-- FontAwesome & Lucide Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LPGQJBQ8TM"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LPGQJBQ8TM');
</script>
