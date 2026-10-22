<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="ie=edge" http-equiv="X-UA-Compatible">

<!-- Primary SEO Meta Tags -->
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="{{ $metaAuthor }}">
<meta name="robots" content="{{ $metaRobots }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook / LinkedIn / WhatsApp -->
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
@endif
<meta property="og:site_name" content="{{ config('app.name', 'DanialFolio') }}">

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
@if($ogImage)
<meta name="twitter:image" content="{{ $ogImage }}">
@endif

<!-- Schema.org JSON-LD Structured Data -->
@if(!empty($jsonLd))
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif

<!-- Favicon -->
<link rel="icon" href="{{ $favicon ? asset('storage/' . \Illuminate\Support\Str::after($favicon, 'public/')) : asset('img/core/favicon.png') }}"
    type="image/x-icon">

@if($headerScripts)
<!-- Header Scripts -->
{!! $headerScripts !!}
@endif

<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

@if($googleSiteVerification)
<!-- Google Site Verification -->
{!! $googleSiteVerification !!}
@endif

@if($googleAnalytics)
<!-- Google Analytics -->
{!! $googleAnalytics !!}
@endif

<!-- Scripts & Styles -->
@filamentStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])

@if ($googleFonts != 'Inter')
<!-- Google Fonts -->
{!! $googleFontsCode !!}
<style>
    body {
        font-family: '{{ $googleFonts }}',
        'Inter',
        sans-serif;
    }
</style>
@else
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
<link as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>
@endif
