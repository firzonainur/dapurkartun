@extends('layouts.app')

@section('meta_title', ($news->seo_title ?: $news->title) . ' - Dapur Kartun')
@section('meta_description', $news->seo_description ?: $news->excerpt)
@section('canonical_url', route('news.show', $news->slug))
@section('og_type', 'article')
@section('og_title', $news->seo_title ?: $news->title)
@section('og_description', $news->seo_description ?: $news->excerpt)
@section('og_image', $news->thumbnail_url)

@section('content')
<div class="news-detail-wrapper" style="padding-top: 6rem; padding-bottom: 5rem; background-color: var(--c-cream);">
    @if(isset($isPreview) && $isPreview)
        <!-- Banner Pratinjau Admin -->
        <aside class="admin-preview-banner" role="status" style="background-color: var(--c-yellow); border-bottom: 3px solid var(--c-midnight); padding: 0.85rem 1rem; text-align: center; font-weight: 800; color: var(--c-midnight); position: sticky; top: 0; z-index: 100;">
            ⚠️ MODE PRATINJAU ADMIN &mdash; Status: <span style="text-transform: uppercase;">{{ $news->status_label }}</span> (Artikel ini belum terlihat oleh pengunjung umum)
            <a href="{{ route('admin.news.edit', $news->id) }}" style="margin-left: 1rem; color: var(--c-midnight); text-decoration: underline;">
                Kembali ke Formulir Edit &rarr;
            </a>
        </aside>
    @endif

    <article class="news-article-container" style="max-width: 820px; margin: 0 auto; padding: 2rem 1.5rem 0 1.5rem;">
        <!-- Breadcrumb & Back Link -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
            <a href="{{ route('news.index') }}" style="color: var(--c-orange); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
                <span aria-hidden="true">&larr;</span>
                <span>Semua Berita</span>
            </a>
            @if($news->category)
                <span style="color: var(--c-text-muted);">&bull;</span>
                <a href="{{ route('news.index', ['kategori' => $news->category->slug]) }}" style="color: var(--c-text-muted); text-decoration: none;">
                    {{ $news->category->name }}
                </a>
            @endif
        </nav>

        <!-- Article Header -->
        <header class="news-article-header" style="margin-bottom: 2.5rem;">
            <!-- Category and Meta Row -->
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem;">
                @if($news->category)
                    <span style="background-color: var(--c-cream-alt); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.35rem 0.95rem; border-radius: var(--r-full); font-size: 0.825rem; font-weight: 800; box-shadow: var(--shadow-cartoon-sm);">
                        {{ $news->category->name }}
                    </span>
                @endif
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--c-text-muted);">
                    <time datetime="{{ $news->published_at ? $news->published_at->toIso8601String() : $news->created_at->toIso8601String() }}">
                        {{ $news->published_at ? $news->published_at->locale('id')->translatedFormat('l, d F Y') : $news->created_at->locale('id')->translatedFormat('l, d F Y') }}
                    </time>
                    <span>&bull;</span>
                    <span>{{ $news->reading_time }} menit baca</span>
                </div>
            </div>

            <!-- Title -->
            <h1 style="font-size: clamp(2rem, 4.2vw, 3.1rem); font-weight: 800; line-height: 1.2; color: var(--c-midnight); margin-bottom: 1.5rem;">
                {{ $news->title }}
            </h1>

            <!-- Author info -->
            <div style="display: flex; align-items: center; gap: 0.85rem; padding-bottom: 1.5rem; border-bottom: 2px dashed var(--c-border-subtle);">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--c-orange-light); border: 2px solid var(--c-midnight); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    🎨
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem; color: var(--c-midnight);">
                        {{ $news->author ? $news->author->name : 'Tim Redaksi Dapur Kartun' }}
                    </div>
                    <div style="font-size: 0.8rem; color: var(--c-text-muted);">
                        Studio Ilustrasi &amp; Animasi
                    </div>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <figure class="news-featured-figure card-cartoon" style="margin-bottom: 3rem; background: var(--c-cream-card); border: var(--stroke-width-thick) solid var(--c-midnight); border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--shadow-cartoon-lg);">
            <img src="{{ $news->thumbnail_url }}" alt="{{ $news->title }}" style="width: 100%; max-height: 480px; object-fit: cover; display: block;">
            @if(!empty($news->excerpt))
                <figcaption style="padding: 1rem 1.5rem; font-size: 0.925rem; font-style: italic; color: var(--c-text-muted); background: var(--c-cream-alt); border-top: 2px solid var(--c-midnight);">
                    {{ $news->excerpt }}
                </figcaption>
            @endif
        </figure>

        <!-- Article Rich Body Content -->
        <div class="news-article-body article-prose" style="font-size: 1.125rem; line-height: 1.85; color: #2B1E3F; margin-bottom: 3.5rem;">
            {!! $news->content !!}
        </div>

        <!-- Share and Action Section -->
        <section class="news-share-box card-cartoon" aria-labelledby="share-heading" style="background: var(--c-cream-card); border: var(--stroke-width) solid var(--c-midnight); border-radius: var(--r-md); padding: 1.75rem; box-shadow: var(--shadow-cartoon); margin-bottom: 4rem;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem;">
                <div>
                    <h2 id="share-heading" style="font-size: 1.1rem; font-weight: 800; color: var(--c-midnight); margin-bottom: 0.25rem;">
                        Bagikan Cerita Ini
                    </h2>
                    <p style="font-size: 0.875rem; color: var(--c-text-muted); margin: 0;">
                        Sebarkan inspirasi kreatif ini kepada teman dan keluarga.
                    </p>
                </div>

                <div class="share-buttons" style="display: flex; flex-wrap: wrap; gap: 0.65rem; align-items: center;">
                    @php
                        $articleUrl = route('news.show', $news->slug);
                        $shareText = $news->title . ' - Dapur Kartun';
                    @endphp

                    <!-- WhatsApp -->
                    <a 
                        href="https://api.whatsapp.com/send?text={{ rawurlencode($shareText . "\n" . $articleUrl) }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="btn-share" 
                        aria-label="Bagikan ke WhatsApp"
                        style="display: inline-flex; align-items: center; gap: 0.5rem; min-height: 44px; padding: 0.5rem 1rem; border-radius: var(--r-full); background: #25D366; color: #FFFFFF; font-weight: 700; font-size: 0.875rem; text-decoration: none; border: 2px solid var(--c-midnight); box-shadow: var(--shadow-cartoon-sm);"
                    >
                        <span>WhatsApp</span>
                    </a>

                    <!-- Twitter / X -->
                    <a 
                        href="https://twitter.com/intent/tweet?text={{ rawurlencode($shareText) }}&url={{ rawurlencode($articleUrl) }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="btn-share" 
                        aria-label="Bagikan ke X Twitter"
                        style="display: inline-flex; align-items: center; gap: 0.5rem; min-height: 44px; padding: 0.5rem 1rem; border-radius: var(--r-full); background: #0F1419; color: #FFFFFF; font-weight: 700; font-size: 0.875rem; text-decoration: none; border: 2px solid var(--c-midnight); box-shadow: var(--shadow-cartoon-sm);"
                    >
                        <span>X / Twitter</span>
                    </a>

                    <!-- Facebook -->
                    <a 
                        href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($articleUrl) }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="btn-share" 
                        aria-label="Bagikan ke Facebook"
                        style="display: inline-flex; align-items: center; gap: 0.5rem; min-height: 44px; padding: 0.5rem 1rem; border-radius: var(--r-full); background: #1877F2; color: #FFFFFF; font-weight: 700; font-size: 0.875rem; text-decoration: none; border: 2px solid var(--c-midnight); box-shadow: var(--shadow-cartoon-sm);"
                    >
                        <span>Facebook</span>
                    </a>

                    <!-- Copy Link Button -->
                    <button 
                        type="button" 
                        onclick="copyArticleLink('{{ $articleUrl }}')" 
                        id="copyLinkBtn"
                        class="btn-share" 
                        aria-label="Salin tautan artikel"
                        style="display: inline-flex; align-items: center; gap: 0.5rem; min-height: 44px; padding: 0.5rem 1rem; border-radius: var(--r-full); background: var(--c-cream); color: var(--c-midnight); font-weight: 700; font-size: 0.875rem; border: 2px solid var(--c-midnight); box-shadow: var(--shadow-cartoon-sm); cursor: pointer;"
                    >
                        <span>Salin Tautan</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Back to list action -->
        <div style="text-align: center; margin-bottom: 4.5rem;">
            <a href="{{ route('news.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem; min-height: 48px; padding: 0.75rem 2rem; border-radius: var(--r-full); font-weight: 700; text-decoration: none; background: #FFFFFF; color: var(--c-midnight); border: 2px solid var(--c-midnight); box-shadow: var(--shadow-cartoon);">
                <span aria-hidden="true">&larr;</span>
                <span>Kembali ke Daftar Berita</span>
            </a>
        </div>
    </article>

    <!-- Related Articles Section -->
    @if(isset($relatedNews) && $relatedNews->isNotEmpty())
        <section class="related-news-section" style="border-top: 2px dashed var(--c-border-subtle); padding-top: 4rem; background-color: var(--c-cream-alt);">
            <div class="container" style="max-width: 1040px;">
                <div style="text-align: center; margin-bottom: 2.5rem;">
                    <div class="section-badge" style="display: inline-block; background-color: var(--c-yellow-light); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.25rem 0.95rem; border-radius: var(--r-full); font-weight: 700; font-size: 0.8rem; box-shadow: var(--shadow-cartoon-sm); margin-bottom: 0.75rem;">
                        Rekomendasi Bacaan
                    </div>
                    <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--c-midnight);">
                        Cerita Terkait Lainnya
                    </h2>
                </div>

                <div class="related-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem;">
                    @foreach($relatedNews as $related)
                        <article class="news-card card-cartoon" style="background: var(--c-cream-card); border: var(--stroke-width) solid var(--c-midnight); border-radius: var(--r-md); overflow: hidden; box-shadow: var(--shadow-cartoon); display: flex; flex-direction: column;">
                            <div style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background: var(--c-cream-alt); border-bottom: var(--stroke-width) solid var(--c-midnight);">
                                <a href="{{ route('news.show', $related->slug) }}" style="display: block; width: 100%; height: 100%;">
                                    <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                @if($related->category)
                                    <span style="position: absolute; top: 0.75rem; left: 0.75rem; background: var(--c-cream); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.2rem 0.65rem; border-radius: var(--r-full); font-size: 0.75rem; font-weight: 700; box-shadow: var(--shadow-cartoon-sm);">
                                        {{ $related->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1;">
                                <div style="font-size: 0.8rem; color: var(--c-text-muted); margin-bottom: 0.5rem;">
                                    <time datetime="{{ $related->published_at ? $related->published_at->toIso8601String() : $related->created_at->toIso8601String() }}">
                                        {{ $related->published_at ? $related->published_at->locale('id')->translatedFormat('d F Y') : $related->created_at->locale('id')->translatedFormat('d F Y') }}
                                    </time>
                                </div>
                                <h3 style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 0.75rem;">
                                    <a href="{{ route('news.show', $related->slug) }}" style="color: var(--c-midnight); text-decoration: none;">
                                        {{ $related->title }}
                                    </a>
                                </h3>
                                <p style="font-size: 0.875rem; color: var(--c-text-muted); line-height: 1.5; margin-bottom: 1rem; flex-grow: 1;">
                                    {{ Str::limit($related->excerpt, 90) }}
                                </p>
                                <div>
                                    <a href="{{ route('news.show', $related->slug) }}" style="color: var(--c-orange); font-weight: 700; text-decoration: none; font-size: 0.875rem;">
                                        Baca Selengkapnya &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

<script>
function copyArticleLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(showCopiedFeedback);
    } else {
        const temp = document.createElement('textarea');
        temp.value = url;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        showCopiedFeedback();
    }
}

function showCopiedFeedback() {
    const btn = document.getElementById('copyLinkBtn');
    if (btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span>Tautan Disalin!</span>';
        btn.style.backgroundColor = 'var(--c-yellow-light)';
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.backgroundColor = 'var(--c-cream)';
        }, 2500);
    }
}
</script>
@endsection
