<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\Slide;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DapurKartunTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_renders_with_brand_and_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Dapur Kartun');
        $response->assertSee('Selamat Datang di Dunia Dapur Kartun');
        $response->assertSee('Kreativitas Penuh Cerita');
        $response->assertSee('Petualangan di Atas Awan');
        $response->assertSee('Hubungi Kami');
    }

    public function test_contact_form_submits_and_stores_in_sqlite(): void
    {
        $payload = [
            'name' => 'Fajar Pratama',
            'email' => 'fajar@example.com',
            'phone' => '081298765432',
            'subject' => 'Proyek Maskot Minuman',
            'message' => 'Halo Dapur Kartun, kami ingin membuat maskot untuk produk minuman anak.',
            'website_trap' => '', // honeypot empty
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', [
            'name' => 'Fajar Pratama',
            'email' => 'fajar@example.com',
            'subject' => 'Proyek Maskot Minuman',
            'is_read' => false,
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_contact_form_honeypot_silently_ignores_spam(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.com',
            'message' => 'Buy cheap links now!',
            'website_trap' => 'http://spamurl.com', // Filled by bot
        ];

        $initialCount = Contact::count();
        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect();
        $this->assertEquals($initialCount, Contact::count());
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@dapurkartun.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_login_fails_with_invalid_password(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@dapurkartun.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_admin_can_view_dashboard(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Dashboard Studio');
        $response->assertSee('Karya Dipublikasikan');
        $response->assertSee('Slide Aktif');
        $response->assertSee('Testimoni Dipublikasikan');
        $response->assertSee('Pesan Belum Dibaca');
    }

    public function test_admin_can_manage_slides(): void
    {
        $admin = User::first();

        // Create slide
        $payload = [
            'title' => 'Slide Baru Petualangan',
            'subtitle' => 'Eksplorasi dunia warna-warni.',
            'image_url' => 'images/slides/slide-1-dapur-imajinasi.svg',
            'button_text' => 'Lihat Sekarang',
            'button_url' => '#galeri',
            'sort_order' => 5,
            'is_active' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('admin.slides.store'), $payload);
        $response->assertRedirect(route('admin.slides.index'));
        $this->assertDatabaseHas('slides', ['title' => 'Slide Baru Petualangan']);

        $slide = Slide::where('title', 'Slide Baru Petualangan')->first();

        // Toggle active
        $this->actingAs($admin)->post(route('admin.slides.toggle-active', $slide));
        $this->assertFalse((bool) $slide->fresh()->is_active);

        // Edit slide
        $updatePayload = array_merge($payload, ['title' => 'Slide Diperbarui']);
        $this->actingAs($admin)->put(route('admin.slides.update', $slide), $updatePayload);
        $this->assertEquals('Slide Diperbarui', $slide->fresh()->title);

        // Delete slide
        $this->actingAs($admin)->delete(route('admin.slides.destroy', $slide));
        $this->assertDatabaseMissing('slides', ['id' => $slide->id]);
    }

    public function test_admin_can_create_new_gallery_with_custom_category(): void
    {
        $admin = User::first();

        $payload = [
            'title' => 'Robot Kucing Masa Depan',
            'description' => 'Eksplorasi karakter robot sahabat belajar.',
            'new_category' => 'Komik Strip Kustom',
            'image_url' => 'images/gallery/artwork-3-mesin-waktu-kucing.svg',
            'sort_order' => 10,
            'is_published' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('admin.galleries.store'), $payload);

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', [
            'title' => 'Robot Kucing Masa Depan',
            'category' => 'Komik Strip Kustom',
        ]);

        $gallery = Gallery::where('title', 'Robot Kucing Masa Depan')->first();

        // Toggle publish
        $this->actingAs($admin)->post(route('admin.galleries.toggle-publish', $gallery));
        $this->assertFalse((bool) $gallery->fresh()->is_published);
    }

    public function test_admin_gallery_singular_alias_route_works(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->get('/admin/gallery');
        $response->assertStatus(200);

        $createResponse = $this->actingAs($admin)->get('/admin/gallery/create');
        $createResponse->assertStatus(200);
    }

    public function test_admin_can_manage_testimonials(): void
    {
        $admin = User::first();

        $payload = [
            'customer_name' => 'Citra Dewi',
            'role' => 'Direktur Kreatif (Data Contoh)',
            'message' => 'Hasil ilustrasi dan karakternya sangat hidup dan menyenangkan.',
            'rating' => 5,
            'avatar_url' => 'images/avatars/avatar-2.svg',
            'sort_order' => 10,
            'is_published' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('admin.testimonials.store'), $payload);
        $response->assertRedirect(route('admin.testimonials.index'));
        $testi = Testimonial::where('customer_name', 'Citra Dewi')->first();


        // Toggle publish
        $this->actingAs($admin)->post(route('admin.testimonials.toggle-publish', $testi));
        $this->assertFalse((bool) $testi->fresh()->is_published);

        // Delete
        $this->actingAs($admin)->delete(route('admin.testimonials.destroy', $testi));
        $this->assertDatabaseMissing('testimonials', ['id' => $testi->id]);
    }

    public function test_admin_can_update_site_settings(): void
    {
        $admin = User::first();

        $payload = [
            'site_title' => 'Dapur Kartun Indonesia',
            'site_tagline' => 'Dapur Imajinasi Visual',
            'meta_title' => 'Dapur Kartun - Studio Visual Terbaik',
            'meta_description' => 'Studio ilustrasi kartun terbaik untuk kreasi anak.',
            'contact_email' => 'kontak@dapurkartun.id',
            'whatsapp_number' => '628999888777',
            'contact_phone' => '+62 899-9888-777',
            'studio_address' => 'Bandung, Indonesia',
            'footer_info' => 'Hak cipta studio terlindungi.',
            'instagram_url' => 'https://instagram.com/dapurkartun',
            'about_title' => 'Dunia Kreatif Kami',
            'about_story' => 'Cerita baru tentang studio kartun kami.',
            'stat_illustrations' => '500+ Karya (Data Contoh)',
            'stat_characters' => '150+ Karakter (Data Contoh)',
            'stat_animations' => '40+ Serial (Data Contoh)',
            'stat_creators' => '10 Artis (Data Contoh)',
        ];

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), $payload);

        $response->assertRedirect();
        $this->assertEquals('Dapur Kartun Indonesia', SiteSetting::get('site_title'));
        $this->assertEquals('kontak@dapurkartun.id', SiteSetting::get('contact_email'));
        $this->assertEquals('Dapur Kartun - Studio Visual Terbaik', SiteSetting::get('meta_title'));
    }

    public function test_admin_can_view_toggle_and_delete_contact(): void
    {
        $admin = User::first();
        $contact = Contact::first();

        // View contact details marks it as read
        $response = $this->actingAs($admin)->get(route('admin.contacts.show', $contact));
        $response->assertStatus(200);
        $this->assertTrue($contact->fresh()->is_read);

        // Toggle read back to unread
        $this->actingAs($admin)->post(route('admin.contacts.toggle-read', $contact));
        $this->assertFalse((bool) $contact->fresh()->is_read);

        // Delete contact
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.contacts.destroy', $contact));
        $deleteResponse->assertRedirect(route('admin.contacts.index'));
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_admin_logout_revokes_session(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post(route('admin.logout'));
        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}

