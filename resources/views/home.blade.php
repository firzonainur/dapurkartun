@extends('layouts.app')

@section('content')
    {{-- 1. Hero Section with Parallax Multi-layer and Interactive Slider --}}
    @include('components.hero')

    {{-- 2. About Us Section with Storyteller Mascot & Editorial Stats --}}
    @include('components.about')

    {{-- 3. Galeri Karya Section with Category Filtering & Lightbox Modal --}}
    @include('components.gallery')

    {{-- 4. Testimoni Section with Cartoon Speech Bubble Cards & Ratings --}}
    @include('components.testimonials')

    {{-- 5. Kontak Section with Validated SQLite Form & WhatsApp Integration --}}
    @include('components.contact')
@endsection
