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
        $response->assertSee('Ringkasan Studio & Konten');
        $response->assertSee('Karya Galeri');
        $response->assertSee('Slide Aktif');
    }

    public function test_admin_can_create_new_gallery(): void
    {
        $admin = User::first();

        $payload = [
            'title' => 'Robot Kucing Masa Depan',
            'description' => 'Eksplorasi karakter robot sahabat belajar.',
            'category' => 'Karakter',
            'image_url' => 'images/gallery/artwork-3-mesin-waktu-kucing.svg',
            'sort_order' => 10,
            'is_published' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('admin.galleries.store'), $payload);

        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', [
            'title' => 'Robot Kucing Masa Depan',
            'category' => 'Karakter',
        ]);
    }

    public function test_admin_can_update_site_settings(): void
    {
        $admin = User::first();

        $payload = [
            'site_title' => 'Dapur Kartun Indonesia',
            'site_tagline' => 'Dapur Imajinasi Visual',
            'contact_email' => 'kontak@dapurkartun.id',
            'whatsapp_number' => '628999888777',
            'contact_phone' => '+62 899-9888-777',
            'studio_address' => 'Bandung, Indonesia',
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
    }

    public function test_admin_can_view_and_delete_contact(): void
    {
        $admin = User::first();
        $contact = Contact::first();

        // View contact details marks it as read
        $response = $this->actingAs($admin)->get(route('admin.contacts.show', $contact));
        $response->assertStatus(200);
        $this->assertTrue($contact->fresh()->is_read);

        // Delete contact
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.contacts.destroy', $contact));
        $deleteResponse->assertRedirect(route('admin.contacts.index'));
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
