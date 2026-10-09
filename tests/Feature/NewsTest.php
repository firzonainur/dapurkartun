<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected NewsCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->admin = User::first();
        $this->category = NewsCategory::first();
    }

    /**
     * 1. Admin dapat menambahkan artikel.
     */
    public function test_admin_can_add_news_article(): void
    {
        $payload = [
            'title' => 'Judul Artikel Uji Coba Studio',
            'slug' => 'judul-artikel-uji-coba-studio',
            'category_id' => $this->category->id,
            'excerpt' => 'Ini adalah ringkasan berita uji coba.',
            'content' => '<h2>Subjudul Cerita</h2><p>Paragraf isi berita yang ditulis oleh admin.</p>',
            'status' => 'published',
            'published_at' => now('Asia/Jakarta')->format('Y-m-d\TH:i'),
            'is_featured' => 1,
            'seo_title' => 'SEO Title Khusus',
            'seo_description' => 'SEO Description Khusus',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), $payload);

        $response->assertRedirect(route('admin.news.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('news', [
            'title' => 'Judul Artikel Uji Coba Studio',
            'slug' => 'judul-artikel-uji-coba-studio',
            'category_id' => $this->category->id,
            'status' => 'published',
            'is_featured' => true,
        ]);
    }

    /**
     * 2. Admin dapat mengedit dan menghapus artikel.
     */
    public function test_admin_can_edit_and_delete_news_article(): void
    {
        $news = News::first();

        // Edit
        $updatePayload = [
            'title' => 'Judul Artikel Diperbarui',
            'slug' => $news->slug,
            'category_id' => $this->category->id,
            'excerpt' => 'Ringkasan yang diperbarui oleh admin.',
            'content' => '<p>Konten yang telah direvisi.</p>',
            'status' => 'published',
            'published_at' => now('Asia/Jakarta')->format('Y-m-d\TH:i'),
            'is_featured' => 0,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.news.update', $news->id), $updatePayload);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Judul Artikel Diperbarui',
        ]);

        // Hapus
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.news.destroy', $news->id));
        $deleteResponse->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseMissing('news', ['id' => $news->id]);
    }

    /**
     * 3. Slug artikel unik dan URL detail berfungsi.
     */
    public function test_unique_slug_and_detail_url_works(): void
    {
        $existing = News::first();

        // Coba buat dengan judul yang sama persis tanpa mengisi slug manual
        $payload = [
            'title' => $existing->title,
            'category_id' => $this->category->id,
            'excerpt' => 'Ringkasan artikel kedua dengan judul mirip.',
            'content' => '<p>Konten artikel.</p>',
            'status' => 'published',
            'published_at' => now('Asia/Jakarta')->format('Y-m-d\TH:i'),
        ];

        $this->actingAs($this->admin)->post(route('admin.news.store'), $payload);

        // Harus menghasilkan slug unik berpola {slug}-1
        $this->assertDatabaseHas('news', [
            'slug' => $existing->slug . '-1',
        ]);

        // URL detail artikel yang sudah terbit dapat diakses publik
        $detailResponse = $this->get(route('news.show', $existing->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($existing->title);
    }

    /**
     * 4. Draft tidak terlihat di halaman publik.
     */
    public function test_draft_article_is_hidden_from_public(): void
    {
        $draft = News::where('status', 'draft')->first();
        $this->assertNotNull($draft);

        // Kunjungi URL detail publik artikel draft
        $response = $this->get(route('news.show', $draft->slug));
        $response->assertStatus(404);

        // Kunjungi daftar berita publik
        $listResponse = $this->get(route('news.index'));
        $listResponse->assertDontSee($draft->title);

        // Kunjungi landing page publik
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertDontSee($draft->title);
    }

    /**
     * 5. Artikel terjadwal tidak tampil sebelum waktunya.
     */
    public function test_scheduled_article_is_hidden_before_time(): void
    {
        $scheduled = News::where('status', 'scheduled')->first();
        $this->assertNotNull($scheduled);

        // Publik tidak dapat mengakses detail berita terjadwal
        $response = $this->get(route('news.show', $scheduled->slug));
        $response->assertStatus(404);

        // Tidak muncul di daftar berita publik
        $listResponse = $this->get(route('news.index'));
        $listResponse->assertDontSee($scheduled->title);
    }

    /**
     * 6. Artikel terjadwal otomatis tampil ketika waktunya tiba.
     */
    public function test_scheduled_article_becomes_visible_when_time_arrives(): void
    {
        // Buat artikel terjadwal yang tanggalnya sudah lewat (misal 5 menit lalu)
        $pastScheduled = News::create([
            'title' => 'Artikel Terjadwal yang Waktunya Sudah Tiba',
            'slug' => 'artikel-terjadwal-sudah-tiba',
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'excerpt' => 'Ringkasan artikel jadwal lewat.',
            'content' => '<p>Konten artikel jadwal lewat.</p>',
            'status' => 'scheduled',
            'published_at' => Carbon::now('Asia/Jakarta')->subMinutes(5),
        ]);

        // Harus langsung dapat diakses publik via query scope
        $response = $this->get(route('news.show', $pastScheduled->slug));
        $response->assertStatus(200);
        $response->assertSee('Artikel Terjadwal yang Waktunya Sudah Tiba');
    }

    /**
     * 7. Artikel terbit muncul di landing page dan daftar berita.
     */
    public function test_published_article_appears_on_home_and_news_list(): void
    {
        $published = News::where('status', 'published')->first();
        $this->assertNotNull($published);

        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Cerita Terbaru dari Dapur Kartun');
        $homeResponse->assertSee($published->title);

        $listResponse = $this->get(route('news.index'));
        $listResponse->assertStatus(200);
        $listResponse->assertSee($published->title);
    }

    /**
     * 8. Pencarian, filter kategori, dan pagination berfungsi.
     */
    public function test_search_and_category_filtering(): void
    {
        $first = News::where('status', 'published')->first();

        // Pencarian judul yang cocok
        $searchResponse = $this->get(route('news.index', ['search' => $first->title]));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee($first->title);

        // Pencarian kata kunci yang tidak ada
        $noResultResponse = $this->get(route('news.index', ['search' => 'XYZKataKunciMustahil999']));
        $noResultResponse->assertStatus(200);
        $noResultResponse->assertSee('Tidak Ada Artikel yang Ditemukan');

        // Filter kategori
        $catResponse = $this->get(route('news.index', ['kategori' => $first->category->slug]));
        $catResponse->assertStatus(200);
        $catResponse->assertSee($first->title);
    }

    /**
     * 9. Gambar thumbnail dapat diunggah dan disimpan.
     */
    public function test_thumbnail_upload_and_storage(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('thumbnail-cerita.jpg', 800, 600);

        $payload = [
            'title' => 'Artikel dengan Gambar Unggahan Baru',
            'category_id' => $this->category->id,
            'excerpt' => 'Ringkasan gambar unggahan.',
            'content' => '<p>Konten artikel dengan berkas gambar.</p>',
            'status' => 'published',
            'published_at' => now('Asia/Jakarta')->format('Y-m-d\TH:i'),
            'thumbnail_file' => $file,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), $payload);
        $response->assertRedirect(route('admin.news.index'));

        $created = News::where('title', 'Artikel dengan Gambar Unggahan Baru')->first();
        $this->assertNotNull($created);
        $this->assertStringStartsWith('storage/news/', $created->thumbnail);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $created->thumbnail));
    }

    /**
     * 10. Sanitasi HTML mencegah injeksi XSS pada konten artikel.
     */
    public function test_html_content_is_sanitized_against_xss(): void
    {
        $dirtyContent = '<h2>Judul Bagus</h2><script>alert("XSS")</script><p onclick="stealCookies()">Paragraf bersih <img src="x" onerror="evil()"><a href="javascript:bad()">Tautan</a></p>';

        $payload = [
            'title' => 'Artikel Uji Sanitasi Konten',
            'category_id' => $this->category->id,
            'excerpt' => 'Ringkasan artikel uji sanitasi.',
            'content' => $dirtyContent,
            'status' => 'published',
            'published_at' => now('Asia/Jakarta')->format('Y-m-d\TH:i'),
        ];

        $this->actingAs($this->admin)->post(route('admin.news.store'), $payload);

        $saved = News::where('title', 'Artikel Uji Sanitasi Konten')->first();
        $this->assertNotNull($saved);
        $this->assertStringNotContainsString('<script>', $saved->content);
        $this->assertStringNotContainsString('onclick', $saved->content);
        $this->assertStringNotContainsString('onerror', $saved->content);
        $this->assertStringNotContainsString('javascript:', $saved->content);
        $this->assertStringContainsString('<h2>Judul Bagus</h2>', $saved->content);
    }

    /**
     * 11. Metadata SEO mengikuti data artikel.
     */
    public function test_seo_metadata_matches_article(): void
    {
        $article = News::where('status', 'published')->first();

        $response = $this->get(route('news.show', $article->slug));
        $response->assertStatus(200);
        $response->assertSee('<title>' . ($article->seo_title ?: $article->title) . ' - Dapur Kartun</title>', false);
        $response->assertSee('content="' . ($article->seo_description ?: $article->excerpt) . '"', false);
        $response->assertSee('property="og:type" content="article"', false);
    }

    /**
     * 12. Pengunjung yang tidak login tidak dapat mengakses halaman admin news.
     */
    public function test_unauthorized_guest_cannot_access_admin_news(): void
    {
        $response = $this->get(route('admin.news.index'));
        $response->assertRedirect(route('admin.login'));

        $createResponse = $this->get(route('admin.news.create'));
        $createResponse->assertRedirect(route('admin.login'));
    }

    /**
     * 13. Kategori yang masih memiliki artikel tidak dapat dihapus.
     */
    public function test_category_with_articles_cannot_be_deleted(): void
    {
        $catWithArticles = NewsCategory::has('news')->first();
        $this->assertNotNull($catWithArticles);

        $response = $this->actingAs($this->admin)->delete(route('admin.news-categories.destroy', $catWithArticles->id));
        $response->assertRedirect(route('admin.news-categories.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('news_categories', ['id' => $catWithArticles->id]);
    }

    /**
     * 14. Command news:publish-scheduled memperbarui status artikel yang telah tiba waktunya.
     */
    public function test_publish_scheduled_command(): void
    {
        $dueScheduled = News::create([
            'title' => 'Artikel Harus Dipublikasikan Scheduler',
            'slug' => 'artikel-harus-scheduler',
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'excerpt' => 'Ringkasan scheduler.',
            'content' => '<p>Konten scheduler.</p>',
            'status' => 'scheduled',
            'published_at' => Carbon::now('Asia/Jakarta')->subMinute(),
        ]);

        $this->artisan('news:publish-scheduled')
            ->assertExitCode(0);

        $dueScheduled->refresh();
        $this->assertEquals('published', $dueScheduled->status);
    }
}
