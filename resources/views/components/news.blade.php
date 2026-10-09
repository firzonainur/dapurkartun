{{-- Section News pada Landing Page Dapur Kartun --}}
<section class="section news-section" id="news" aria-labelledby="news-heading">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center" style="max-width: 680px; margin: 0 auto 3.5rem auto;">
            <div class="section-badge" style="display: inline-block; background-color: var(--c-yellow-light); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.35rem 1rem; border-radius: var(--r-full); font-weight: 700; font-size: 0.875rem; box-shadow: var(--shadow-cartoon-sm); margin-bottom: 1rem;">
                Kabar Studio &amp; Inspirasi
            </div>
            <h2 id="news-heading" class="section-title" style="font-size: clamp(1.85rem, 3.5vw, 2.6rem); margin-bottom: 1rem; line-height: 1.25;">
                Cerita Terbaru dari Dapur Kartun
            </h2>
            <p class="section-subtitle" style="font-size: 1.05rem; color: var(--c-text-muted); line-height: 1.6;">
                Temukan kabar terbaru, cerita di balik karya, dan berbagai inspirasi kreatif dari Dapur Kartun.
            </p>
        </div>

        @if(isset($latestNews) && $latestNews->isNotEmpty())
            <!-- Grid 3 Berita Terbaru -->
            <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3.5rem;">
                @foreach($latestNews as $item)
                    <article class="news-card card-cartoon" style="background: var(--c-cream-card); border: var(--stroke-width) solid var(--c-midnight); border-radius: var(--r-md); overflow: hidden; box-shadow: var(--shadow-cartoon); display: flex; flex-direction: column; transition: transform var(--trans-normal), box-shadow var(--trans-normal);">
                        <!-- Thumbnail Wrapper -->
                        <div class="news-card-thumbnail" style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background-color: var(--c-cream-alt); border-bottom: var(--stroke-width) solid var(--c-midnight);">
                            <a href="{{ route('news.show', $item->slug) }}" aria-label="Baca {{ $item->title }}" style="display: block; width: 100%; height: 100%;">
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                            </a>
                            @if($item->category)
                                <span class="news-card-category" style="position: absolute; top: 1rem; left: 1rem; background-color: var(--c-cream); color: var(--c-midnight); border: 2px solid var(--c-midnight); padding: 0.25rem 0.75rem; border-radius: var(--r-full); font-size: 0.775rem; font-weight: 700; box-shadow: var(--shadow-cartoon-sm);">
                                    {{ $item->category->name }}
                                </span>
                            @endif
                            @if($item->is_featured)
                                <span class="news-card-featured" style="position: absolute; top: 1rem; right: 1rem; background-color: var(--c-orange); color: #FFFFFF; border: 2px solid var(--c-midnight); padding: 0.25rem 0.7rem; border-radius: var(--r-full); font-size: 0.75rem; font-weight: 800; box-shadow: var(--shadow-cartoon-sm);">
                                    Unggulan
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="news-card-body" style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                            <div class="news-card-meta" style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.85rem; color: var(--c-text-muted); margin-bottom: 0.75rem;">
                                <time datetime="{{ $item->published_at ? $item->published_at->toIso8601String() : $item->created_at->toIso8601String() }}">
                                    {{ $item->published_at ? $item->published_at->locale('id')->translatedFormat('d F Y') : $item->created_at->locale('id')->translatedFormat('d F Y') }}
                                </time>
                                <span>&bull;</span>
                                <span>{{ $item->reading_time }} mnt baca</span>
                            </div>

                            <h3 class="news-card-title" style="font-size: 1.25rem; font-weight: 800; line-height: 1.35; margin-bottom: 0.75rem;">
                                <a href="{{ route('news.show', $item->slug) }}" style="color: var(--c-midnight); text-decoration: none; transition: color 0.2s ease;">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            <p class="news-card-excerpt" style="font-size: 0.95rem; color: var(--c-text-muted); line-height: 1.55; margin-bottom: 1.5rem; flex-grow: 1;">
                                {{ Str::limit($item->excerpt, 120) }}
                            </p>

                            <div class="news-card-footer" style="padding-top: 1rem; border-top: 1px dashed var(--c-border-subtle); display: flex; align-items: center; justify-content: space-between;">
                                <a href="{{ route('news.show', $item->slug) }}" class="btn-read-more" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 700; color: var(--c-orange); text-decoration: none; font-size: 0.925rem; transition: transform 0.2s ease, color 0.2s ease;">
                                    <span>Baca Selengkapnya</span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                                @if($item->author)
                                    <span style="font-size: 0.8rem; color: var(--c-text-muted);">
                                        Oleh {{ $item->author->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Tombol Lihat Semua Berita -->
            <div class="news-actions text-center" style="margin-top: 1rem;">
                <a href="{{ route('news.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; justify-content: center; min-height: 48px; padding: 0.75rem 2rem; font-weight: 700; border-radius: var(--r-full); background: var(--c-cream); color: var(--c-midnight); border: 2px solid var(--c-midnight); box-shadow: var(--shadow-cartoon); text-decoration: none; transition: all var(--trans-normal);">
                    Lihat Semua Berita
                </a>
            </div>
        @else
            <!-- Kondisi Kosong (Empty State) yang Dirancang Baik -->
            <div class="news-empty-state card-cartoon text-center" style="max-width: 600px; margin: 0 auto; padding: 3rem 2rem; background: var(--c-cream-card); border: var(--stroke-width) solid var(--c-midnight); border-radius: var(--r-md); box-shadow: var(--shadow-cartoon);">
                <div style="width: 72px; height: 72px; margin: 0 auto 1.5rem auto; background: var(--c-yellow-light); border: 2px solid var(--c-midnight); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    🎨
                </div>
                <h3 style="font-size: 1.35rem; margin-bottom: 0.75rem; color: var(--c-midnight);">
                    Cerita Baru Sedang Disiapkan
                </h3>
                <p style="color: var(--c-text-muted); font-size: 0.975rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    Tim ilustrator dan animator kami sedang meracik kabar dan inspirasi terbaru dari meja kerja studio. Kunjungi kembali dalam waktu dekat untuk membaca rilis artikel perdana kami!
                </p>
                <a href="#kontak" class="btn btn-primary btn-sm" style="display: inline-block;">
                    Hubungi Studio Kami
                </a>
            </div>
        @endif
    </div>
</section>
