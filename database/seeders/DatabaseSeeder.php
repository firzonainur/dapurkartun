<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\Slide;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@dapurkartun.id'],
            [
                'name' => 'Admin Dapur Kartun',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Site Settings
        $settings = [
            'site_title' => 'Dapur Kartun',
            'site_tagline' => 'Studio Ilustrasi dan Animasi Penuh Cerita',
            'contact_email' => 'halo@dapurkartun.id',
            'contact_phone' => '+62 812-3456-7890',
            'whatsapp_number' => '6281234567890',
            'studio_address' => 'Jl. Cerita Kreatif No. 42, Bandung, Jawa Barat',
            'instagram_url' => 'https://instagram.com/dapurkartun',
            'youtube_url' => 'https://youtube.com/@dapurkartun',
            'behance_url' => 'https://behance.net/dapurkartun',
            'about_title' => 'Kreativitas Penuh Cerita',
            'about_story' => 'Dapur Kartun adalah studio visual independen tempat ide-ide segar diolah menjadi ilustrasi kartun, karakter orisinal, dan animasi bercerita. Kami menggabungkan keterampilan sketsa manual dengan kehangatan warna digital untuk menciptakan karya yang hidup, berkarakter, dan ramah untuk segala usia.',
            'stat_illustrations' => '450+ Karya (Data Contoh)',
            'stat_characters' => '120+ Karakter (Data Contoh)',
            'stat_animations' => '35+ Serial (Data Contoh)',
            'stat_creators' => '8 Artis (Data Contoh)',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Slides
        Slide::truncate();
        $slides = [
            [
                'title' => 'Selamat Datang di Dunia Dapur Kartun',
                'subtitle' => 'Tempat ide kreatif diolah menjadi karya visual yang penuh warna, cerita, dan imajinasi.',
                'image' => 'images/slides/slide-1-dapur-imajinasi.svg',
                'button_text' => 'Jelajahi Karya',
                'button_url' => '#galeri',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Karakter Hidup, Cerita yang Memikat Hati',
                'subtitle' => 'Menciptakan maskot dan karakter kartun orisinal yang meninggalkan kesan mendalam bagi penonton.',
                'image' => 'images/slides/slide-2-dunia-karakter.svg',
                'button_text' => 'Kenali Kami',
                'button_url' => '#tentang',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Animasi Penuh Energi dan Gerakan Halus',
                'subtitle' => 'Dari sketsa storyboard hingga animasi 2D yang membawa pesan cerita Anda melompat lebih hidup.',
                'image' => 'images/slides/slide-3-animasi-cerita.svg',
                'button_text' => 'Mulai Kolaborasi',
                'button_url' => '#kontak',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            Slide::create($slide);
        }

        // 4. Galleries
        Gallery::truncate();
        $galleries = [
            [
                'title' => 'Petualangan di Atas Awan',
                'description' => 'Ilustrasi buku cerita bertema pulau melayang dan kapal balon udara ramah anak.',
                'image' => 'images/gallery/artwork-1-petualangan-awan.svg',
                'category' => 'Ilustrasi Kartun',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Koki Cilik Pemetik Bintang',
                'description' => 'Pengembangan desain maskot anak untuk serial edukasi kuliner keluarga.',
                'image' => 'images/gallery/artwork-2-koki-bintang.svg',
                'category' => 'Karakter',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Mesin Waktu Kucing Penjelajah',
                'description' => 'Konsep animasi pendek tentang kucing cerdik dengan perangkat jam mekanik ajaib.',
                'image' => 'images/gallery/artwork-3-mesin-waktu-kucing.svg',
                'category' => 'Animasi',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Hutan Jamur Bercahaya Malam',
                'description' => 'Latar pemandangan fantasi bergaya cel-shading lembut dengan nuansa magis.',
                'image' => 'images/gallery/artwork-4-hutan-jamur-ajaib.svg',
                'category' => 'Ilustrasi Kartun',
                'sort_order' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Kelinci Antariksa dan Wortel Kosmik',
                'description' => 'Desain karakter maskot anak muda untuk kampanye gaya hidup sehat ceria.',
                'image' => 'images/gallery/artwork-5-kelinci-antariksa.svg',
                'category' => 'Karakter',
                'sort_order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Dongeng Kastel Buku Lipat 3D',
                'description' => 'Desain visual cover dan merchandise buku pop-up interaktif.',
                'image' => 'images/gallery/artwork-6-buku-cerita-raksasa.svg',
                'category' => 'Desain Kreatif',
                'sort_order' => 6,
                'is_published' => true,
            ],
            [
                'title' => 'Orkestra Hewan Hutan Ceria',
                'description' => 'Rangkaian animasi musik anak-anak dengan ritme visual yang ceria dan edukatif.',
                'image' => 'images/gallery/artwork-7-orkestra-hewan-ceria.svg',
                'category' => 'Animasi',
                'sort_order' => 7,
                'is_published' => true,
            ],
            [
                'title' => 'Kemasan Susu Moo-Moo Strawberry',
                'description' => 'Identitas visual kemasan kartun anak dengan palet warna cerah dan menggemaskan.',
                'image' => 'images/gallery/artwork-8-kemasan-susu-kartun.svg',
                'category' => 'Desain Kreatif',
                'sort_order' => 8,
                'is_published' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }

        // 5. Testimonials
        Testimonial::truncate();
        $testimonials = [
            [
                'customer_name' => 'Budi Wicaksono',
                'role' => 'Penerbit Buku Anak Mentari (Data Contoh)',
                'avatar' => 'images/avatars/avatar-1.svg',
                'message' => 'Karakter kartun yang dibuat oleh Dapur Kartun memiliki jiwa dan kehangatan tersendiri. Anak-anak langsung terpikat pada pandangan pertama.',
                'rating' => 5,
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'customer_name' => 'Siti Rahmania',
                'role' => 'Produser Serial Web Komik (Data Contoh)',
                'avatar' => 'images/avatars/avatar-2.svg',
                'message' => 'Komunikasi sangat lancar dan pengerjaan tepat waktu. Proses dari sketsa awal sampai pewarnaan digital terasa sangat profesional.',
                'rating' => 5,
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'customer_name' => 'Reza Pratama',
                'role' => 'Pemilik Brand Camilan Sehat (Data Contoh)',
                'avatar' => 'images/avatars/avatar-3.svg',
                'message' => 'Maskot yang diciptakan membuat kemasan produk kami langsung menonjol di rak toko. Hasilnya jauh melampaui ekspektasi tim kami.',
                'rating' => 5,
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'role' => 'Direktur Kreatif Studio Indie (Data Contoh)',
                'avatar' => 'images/avatars/avatar-4.svg',
                'message' => 'Eksplorasi gaya visual kartun modern yang segar dan tidak pasaran. Dapur Kartun benar-benar mengerti arti bercerita lewat gambar.',
                'rating' => 5,
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // 6. Contact message sample
        Contact::truncate();
        Contact::create([
            'name' => 'Andi Santoso',
            'email' => 'andi@contoh.com',
            'phone' => '08123456789',
            'subject' => 'Proyek Ilustrasi Buku Cerita',
            'message' => 'Halo tim Dapur Kartun, kami berencana membuat serial buku dongeng 5 jilid dan ingin berkonsultasi mengenai gaya karakter kartunnya. Terima kasih!',
            'is_read' => false,
        ]);

        // 7. News Categories and Articles
        $this->call(NewsSeeder::class);
    }
}
