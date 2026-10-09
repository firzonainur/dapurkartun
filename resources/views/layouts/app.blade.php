<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('meta_title', !empty($settings['meta_title']) ? $settings['meta_title'] : (($settings['site_title'] ?? 'Dapur Kartun') . ' - ' . ($settings['site_tagline'] ?? 'Studio Ilustrasi dan Animasi Penuh Cerita')))</title>
    <meta name="description" content="@yield('meta_description', !empty($settings['meta_description']) ? $settings['meta_description'] : ($settings['about_story'] ?? 'Dapur Kartun adalah studio visual kreatif yang mengolah ide menjadi ilustrasi kartun, karakter orisinal, dan animasi bercerita.'))">
    <meta name="keywords" content="dapur kartun, ilustrasi kartun, studio animasi, desain karakter, kartun indonesia, ilustrator buku anak">
    <meta name="author" content="{{ $settings['site_title'] ?? 'Dapur Kartun Studio' }}">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', !empty($settings['meta_title']) ? $settings['meta_title'] : (($settings['site_title'] ?? 'Dapur Kartun') . ' - Studio Ilustrasi dan Animasi Penuh Cerita'))">
    <meta property="og:description" content="@yield('og_description', !empty($settings['meta_description']) ? $settings['meta_description'] : ($settings['site_tagline'] ?? 'Tempat ide kreatif diolah menjadi karya visual yang penuh warna, cerita, dan imajinasi.'))">
    <meta property="og:image" content="@yield('og_image', asset('images/slides/slide-1-dapur-imajinasi.svg'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', !empty($settings['meta_title']) ? $settings['meta_title'] : ($settings['site_title'] ?? 'Dapur Kartun'))">
    <meta name="twitter:description" content="@yield('og_description', !empty($settings['meta_description']) ? $settings['meta_description'] : ($settings['site_tagline'] ?? 'Studio Ilustrasi dan Animasi Penuh Cerita'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/slides/slide-1-dapur-imajinasi.svg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset($settings['site_favicon'] ?? 'images/logo.svg') }}">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/dapurkartun.css') }}">

    @stack('styles')
</head>
<body>
    @include('components.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/dapurkartun.js') }}"></script>
    @stack('scripts')
</body>
</html>
