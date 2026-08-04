@php($googleAnalyticsId = config('services.google_analytics.measurement_id'))

@if ($googleAnalyticsId)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json($googleAnalyticsId));
    </script>
@endif
