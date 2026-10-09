@extends('layouts.app')

@section('content')
<div class="news-page-wrapper" style="padding-top: 6rem; padding-bottom: 5rem; background-color: var(--c-cream);">
    <!-- Header Banner Editorial -->
    <header class="news-editorial-header" style="padding: 3rem 0 2.5rem 0; text-align: center; background: radial-gradient(circle at 50% 0%, var(--c-cream-alt) 0%, var(--c-cream) 70%); border-bottom: 2px solid var(--c-border-subtle); margin-bottom: 3.5rem;">
        <div class="container" style="max-width: 840px;">
            <div class="section-badge" style="display: inline-block; background-color: var(--c-yellow-light); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.35rem 1.25rem; border-radius: var(--r-full); font-weight: 800; font-size: 0.875rem; box-shadow: var(--shadow-cartoon-sm); margin-bottom: 1.25rem;">
                Kabar, Cerita &amp; Inspirasi Studio
            </div>
            <h1 style="font-size: clamp(2.4rem, 5vw, 3.6rem); font-weight: 800; line-height: 1.15; color: var(--c-midnight); margin-bottom: 1rem;">
                Berita &amp; Cerita
            </h1>
            <p style="font-size: clamp(1.05rem, 2vw, 1.25rem); color: var(--c-text-muted); line-height: 1.6; max-width: 660px; margin: 0 auto;">
                Temukan kabar terbaru, cerita di balik karya visual, dan berbagai inspirasi kreatif langsung dari studio Dapur Kartun.
            </p>
        </div>
    </header>

    <div class="container">
        <!-- Search & Category Filter Toolbar -->
        <div class="news-toolbar" style="margin-bottom: 3rem; display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Search Form -->
            <form action="{{ route('news.index') }}" method="GET" class="news-search-form" style="display: flex; gap: 0.75rem; max-width: 580px; width: 100%; margin: 0 auto;">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div style="position: relative; flex-grow: 1;">
                    <input 
                        type="search" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari judul berita atau artikel..." 
                        aria-label="Cari artikel berita"
                        style="width: 100%; min-height: 48px; padding: 0.75rem 1rem 0.75rem 2.75rem; border-radius: var(--r-full); border: 2px solid var(--c-midnight); background: #FFFFFF; font-family: var(--font-body); font-size: 0.95rem; box-shadow: var(--shadow-cartoon-sm);"
                    >
                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--c-text-muted); pointer-events: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary" style="min-height: 48px; padding: 0 1.5rem; border-radius: var(--r-full); white-space: nowrap; font-weight: 700;">
                    Cari
                </button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('news.index') }}" class="btn btn-outline" style="min-height: 48px; display: inline-flex; align-items: center; justify-content: center; padding: 0 1.25rem; border-radius: var(--r-full); text-decoration: none; font-size: 0.875rem;" title="Reset filter">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Category Filter Tabs -->
            <nav class="news-category-pills" aria-label="Filter Kategori Berita" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.65rem;">
                <a 
                    href="{{ route('news.index', array_filter(['search' => request('search')])) }}" 
                    class="category-pill {{ !request('kategori') || request('kategori') === 'semua' ? 'active' : '' }}"
                    style="padding: 0.5rem 1.15rem; border-radius: var(--r-full); font-size: 0.875rem; font-weight: 700; text-decoration: none; border: 2px solid var(--c-midnight); transition: all 0.2s ease; {{ !request('kategori') || request('kategori') === 'semua' ? 'background: var(--c-orange); color: #FFFFFF; box-shadow: var(--shadow-cartoon-sm);' : 'background: #FFFFFF; color: var(--c-midnight);' }}"
                >
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a 
                        href="{{ route('news.index', array_filter(['kategori' => $cat->slug, 'search' => request('search')])) }}" 
                        class="category-pill {{ request('kategori') === $cat->slug ? 'active' : '' }}"
                        style="padding: 0.5rem 1.15rem; border-radius: var(--r-full); font-size: 0.875rem; font-weight: 700; text-decoration: none; border: 2px solid var(--c-midnight); transition: all 0.2s ease; {{ request('kategori') === $cat->slug ? 'background: var(--c-orange); color: #FFFFFF; box-shadow: var(--shadow-cartoon-sm);' : 'background: #FFFFFF; color: var(--c-midnight);' }}"
                    >
                        {{ $cat->name }} ({{ $cat->news_count }})
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Featured News Hero Banner (Only when on front page without active search/category filter) -->
        @if(isset($featuredNews) && $featuredNews)
            <div class="news-featured-hero card-cartoon" style="margin-bottom: 4rem; background: var(--c-cream-card); border: var(--stroke-width-thick) solid var(--c-midnight); border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--shadow-cartoon-lg); display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
                <!-- Large Image -->
                <div class="featured-image-wrapper" style="position: relative; min-height: 320px; background: var(--c-cream-alt); overflow: hidden; border-right: var(--stroke-width) solid var(--c-midnight);">
                    <a href="{{ route('news.show', $featuredNews->slug) }}" style="display: block; width: 100%; height: 100%;">
                        <img src="{{ $featuredNews->thumbnail_url }}" alt="{{ $featuredNews->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </a>
                    <span style="position: absolute; top: 1.25rem; left: 1.25rem; background: var(--c-yellow); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.35rem 0.85rem; border-radius: var(--r-full); font-size: 0.8rem; font-weight: 800; box-shadow: var(--shadow-cartoon-sm);">
                        ⭐ Berita Pilihan
                    </span>
                </div>

                <!-- Featured Details -->
                <div class="featured-content-wrapper" style="padding: clamp(1.75rem, 4vw, 3rem); display: flex; flex-direction: column; justify-content: center;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; font-size: 0.875rem; color: var(--c-text-muted);">
                        @if($featuredNews->category)
                            <span style="background: var(--c-blue-light); color: var(--c-blue-dark); font-weight: 700; padding: 0.2rem 0.65rem; border-radius: var(--r-full); border: 1.5px solid var(--c-midnight);">
                                {{ $featuredNews->category->name }}
                            </span>
                        @endif
                        <time datetime="{{ $featuredNews->published_at ? $featuredNews->published_at->toIso8601String() : $featuredNews->created_at->toIso8601String() }}">
                            {{ $featuredNews->published_at ? $featuredNews->published_at->locale('id')->translatedFormat('d F Y') : $featuredNews->created_at->locale('id')->translatedFormat('d F Y') }}
                        </time>
                        <span>&bull;</span>
                        <span>{{ $featuredNews->reading_time }} mnt baca</span>
                    </div>

                    <h2 style="font-size: clamp(1.6rem, 2.8vw, 2.25rem); font-weight: 800; line-height: 1.25; margin-bottom: 1rem;">
                        <a href="{{ route('news.show', $featuredNews->slug) }}" style="color: var(--c-midnight); text-decoration: none;">
                            {{ $featuredNews->title }}
                        </a>
                    </h2>

                    <p style="font-size: 1.05rem; color: var(--c-text-muted); line-height: 1.6; margin-bottom: 2rem;">
                        {{ $featuredNews->excerpt }}
                    </p>

                    <div>
                        <a href="{{ route('news.show', $featuredNews->slug) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.65rem; font-weight: 800; padding: 0.85rem 1.75rem;">
                            <span>Baca Kisah Selengkapnya</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Articles Grid -->
        @if($newsList->isNotEmpty())
            <div class="news-articles-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.25rem; margin-bottom: 3.5rem;">
                @foreach($newsList as $article)
                    <article class="news-card card-cartoon" style="background: var(--c-cream-card); border: var(--stroke-width) solid var(--c-midnight); border-radius: var(--r-md); overflow: hidden; box-shadow: var(--shadow-cartoon); display: flex; flex-direction: column; transition: transform var(--trans-normal), box-shadow var(--trans-normal);">
                        <!-- Thumbnail -->
                        <div class="news-card-thumbnail" style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background-color: var(--c-cream-alt); border-bottom: var(--stroke-width) solid var(--c-midnight);">
                            <a href="{{ route('news.show', $article->slug) }}" style="display: block; width: 100%; height: 100%;">
                                <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                            @if($article->category)
                                <span style="position: absolute; top: 1rem; left: 1rem; background-color: var(--c-cream); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.25rem 0.75rem; border-radius: var(--r-full); font-size: 0.775rem; font-weight: 700; box-shadow: var(--shadow-cartoon-sm);">
                                    {{ $article->category->name }}
                                </span>
                            @endif
                            @if($article->is_featured)
                                <span style="position: absolute; top: 1rem; right: 1rem; background-color: var(--c-orange); color: #FFFFFF; border: 2px solid var(--c-midnight); padding: 0.25rem 0.7rem; border-radius: var(--r-full); font-size: 0.75rem; font-weight: 800; box-shadow: var(--shadow-cartoon-sm);">
                                    Unggulan
                                </span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="news-card-body" style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                            <div class="news-card-meta" style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.85rem; color: var(--c-text-muted); margin-bottom: 0.75rem;">
                                <time datetime="{{ $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String() }}">
                                    {{ $article->published_at ? $article->published_at->locale('id')->translatedFormat('d F Y') : $article->created_at->locale('id')->translatedFormat('d F Y') }}
                                </time>
                                <span>&bull;</span>
                                <span>{{ $article->reading_time }} mnt baca</span>
                            </div>

                            <h3 class="news-card-title" style="font-size: 1.25rem; font-weight: 800; line-height: 1.35; margin-bottom: 0.75rem;">
                                <a href="{{ route('news.show', $article->slug) }}" style="color: var(--c-midnight); text-decoration: none;">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <p class="news-card-excerpt" style="font-size: 0.95rem; color: var(--c-text-muted); line-height: 1.55; margin-bottom: 1.5rem; flex-grow: 1;">
                                {{ Str::limit($article->excerpt, 120) }}
                            </p>

                            <div class="news-card-footer" style="padding-top: 1rem; border-top: 1px dashed var(--c-border-subtle); display: flex; align-items: center; justify-content: space-between;">
                                <a href="{{ route('news.show', $article->slug) }}" class="btn-read-more" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 700; color: var(--c-orange); text-decoration: none; font-size: 0.925rem;">
                                    <span>Baca Selengkapnya</span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                                @if($article->author)
                                    <span style="font-size: 0.8rem; color: var(--c-text-muted);">
                                        Oleh {{ $article->author->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="news-pagination-wrapper" style="display: flex; justify-content: center; margin-top: 3rem;">
                {{ $newsList->links() }}
            </div>
        @else
            <!-- No Results Empty State -->
            <div class="news-empty card-cartoon text-center" style="max-width: 600px; margin: 3rem auto; padding: 3rem 2rem; background: var(--c-cream-card); border: var(--stroke-width) solid var(--c-midnight); border-radius: var(--r-md); box-shadow: var(--shadow-cartoon);">
                <div style="font-size: 2.5rem; margin-bottom: 1rem;">🔍</div>
                <h3 style="font-size: 1.35rem; font-weight: 800; margin-bottom: 0.75rem; color: var(--c-midnight);">
                    Tidak Ada Artikel yang Ditemukan
                </h3>
                <p style="color: var(--c-text-muted); font-size: 0.975rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    @if(request('search'))
                        Tidak ditemukan artikel dengan kata kunci "<strong>{{ request('search') }}</strong>". Silakan coba kata kunci lain atau lihat kategori lainnya.
                    @else
                        Belum ada artikel yang dipublikasikan pada kategori ini. Kunjungi kembali dalam waktu dekat untuk mengikuti artikel terbaru kami.
                    @endif
                </p>
                <a href="{{ route('news.index') }}" class="btn btn-primary" style="display: inline-block;">
                    Tampilkan Semua Berita
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
