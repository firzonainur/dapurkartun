<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        // 1. Categories
        $categoriesData = [
            [
                'name' => 'Berita Dapur Kartun',
                'slug' => 'berita-dapur-kartun',
                'description' => 'Kabar terbaru seputar aktivitas, kolaborasi, dan perkembangan studio Dapur Kartun.',
            ],
            [
                'name' => 'Proyek Terbaru',
                'slug' => 'proyek-terbaru',
                'description' => 'Informasi proses produksi karya animasi, buku cerita, dan ilustrasi komersial.',
            ],
            [
                'name' => 'Cerita di Balik Karya',
                'slug' => 'cerita-di-balik-karya',
                'description' => 'Eksplorasi proses kreatif, riset visual, dan cerita lahirnya karakter dari meja gambar.',
            ],
            [
                'name' => 'Inspirasi Kreatif',
                'slug' => 'inspirasi-kreatif',
                'description' => 'Tips menggambar, panduan visual kartun, dan percikan ide untuk pegiat seni kreatif.',
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi, jadwal lokakarya, dan agenda kegiatan komunitas Dapur Kartun.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $catData) {
            $categories[$catData['slug']] = NewsCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 2. Initial News Articles
        $now = Carbon::now('Asia/Jakarta');

        $articles = [
            [
                'category_id' => $categories['berita-dapur-kartun']->id,
                'user_id' => $adminId,
                'title' => 'Dapur Kartun Membuka Studio Terbuka: Mengintip Dapur Ide di Balik Karakter Orisinal',
                'slug' => 'dapur-kartun-membuka-studio-terbuka-mengintip-dapur-ide-di-balik-karakter-orisinal',
                'excerpt' => 'Menyambut ulang tahun studio, kami mengundang para kreator muda dan pecinta seni visual untuk melihat langsung bagaimana ide sketsa berkembang menjadi animasi bercerita.',
                'content' => '<h2>Membawa Penonton Masuk ke Ruang Kreasi</h2><p>Bagi tim Dapur Kartun, setiap karakter kartun bermula dari pertanyaan sederhana: <em>cerita apa yang ingin kita bagikan hari ini?</em> Di balik garis-garis lembut dan pilihan warna hangat, tersimpan proses pencarian bentuk yang memakan waktu berhari-hari.</p><p>Melalui sesi Studio Terbuka yang kami selenggarakan bulan ini, kami ingin meruntuhkan sekat antara kreator dan penikmat karya. Siapa pun dapat melihat langsung meja kerja para ilustrator, arsip sketsa awal yang tidak pernah tayang di media sosial, hingga uji coba gerakan animasi pada tahap awal.</p><h3>Tiga Ruang Eksplorasi</h3><p>Studio kami dibagi menjadi tiga area utama:</p><ul><li><strong>Ruang Olah Gagasan:</strong> Tempat catatan sketsa kasar, papan inspirasi warna, dan eksplorasi ekspresi wajah karakter digantung.</li><li><strong>Meja Animasi Tradisional & Digital:</strong> Tempat garis-garis sketsa diuji coba ritme gerakannya bingkai demi bingkai.</li><li><strong>Ruang Uji Rasa Visual:</strong> Ruang evaluasi bersama untuk memastikan setiap karya tetap ramah anak, berjiwa ceria, dan memiliki kedalaman emosi.</li></ul><blockquote><p>Karya kartun yang bermakna tidak lahir dari kecanggihan perangkat semata, melainkan dari kehangatan pesan yang ingin dititipkan ke dalam setiap goresan tangan.</p></blockquote><p>Kami percaya bahwa berbagi cerita tentang proses berkarya adalah cara terbaik untuk merawat api imajinasi bersama. Sampai jumpa di sudut-sudut studio kami!</p>',
                'thumbnail' => 'images/slides/slide-1-dapur-imajinasi.svg',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(2),
                'seo_title' => 'Studio Terbuka Dapur Kartun: Mengintip Proses Kreasi Karakter Orisinal',
                'seo_description' => 'Intip proses kreatif di balik lahirnya karakter orisinal Dapur Kartun dalam sesi studio terbuka bersama para ilustrator dan animator kami.',
            ],
            [
                'category_id' => $categories['proyek-terbaru']->id,
                'user_id' => $adminId,
                'title' => 'Serial Animasi "Petualangan Awan Kecil" Resmi Memasuki Tahap Animasi Kasar',
                'slug' => 'serial-animasi-petualangan-awan-kecil-resmi-memasuki-tahap-animasi-kasar',
                'excerpt' => 'Setelah melewati masa pengembangan cerita selama enam bulan, petualangan Gumpal si awan kecil kini mulai menemukan ritme gerakannya di meja animasi studio kami.',
                'content' => '<h2>Dari Papan Cerita ke Bingkai Bergerak</h2><p>Proyek animasi pendek mandiri terbaru kami, <strong>"Petualangan Awan Kecil"</strong>, kini telah menyelesaikan seluruh tahapan papan cerita (storyboard) dan pencatatan audio suara latar. Pekan ini tim animator utama resmi memulai tahapan animasi kasar (rough animation).</p><p>Tokoh utama serial ini bernama <em>Gumpal</em>, awan kecil berhidung kancing yang takut pada kilat namun bercita-cita menyiram taman bunga di puncak bukit tertinggi. Karakter ini dirancang dengan garis kontur tebal khas Dapur Kartun dan palet warna pastel hangat yang menenangkan.</p><h3>Tantangan Dinamika Bentuk Awan</h3><p>Berbeda dari karakter bertubuh kaku, awan memiliki sifat fluida yang lentur. Animator kami harus menjaga konsistensi volume tubuh Gumpal sembari membiarkan ujung-ujung tubuhnya bergelombang mengikuti embusan angin fantasi.</p><ul><li>Total 120 adegan telah disetujui untuk babak pertama.</li><li>Musik latar digubah menggunakan instrumen marimba dan seruling kayu untuk menghadirkan nuansa petualangan dongeng anak.</li><li>Target penyelesaian animasi penuh dijadwalkan pada pertengahan tahun ini.</li></ul><p>Nantikan cuplikan pertama dan lembar karakter visual yang akan kami bagikan secara berkala di kanal resmi Dapur Kartun.</p>',
                'thumbnail' => 'images/gallery/artwork-1-petualangan-awan.svg',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDay(),
                'seo_title' => 'Proyek Animasi Petualangan Awan Kecil Masuki Tahap Animasi Kasar',
                'seo_description' => 'Simak kemajuan produksi proyek serial animasi orisinal Dapur Kartun berjudul Petualangan Awan Kecil yang kini memasuki tahap animasi kasar.',
            ],
            [
                'category_id' => $categories['inspirasi-kreatif']->id,
                'user_id' => $adminId,
                'title' => '5 Kebiasaan Sederhana untuk Menjaga Percikan Imajinasi Setiap Hari',
                'slug' => '5-kebiasaan-sederhana-untuk-menjaga-percikan-imajinasi-setiap-hari',
                'excerpt' => 'Rasa jenuh dan kebuntuan ide adalah hal lumrah bagi ilustrator. Berikut lima kebiasaan kecil yang rutin dipraktikkan tim kami untuk menjaga kesegaran berpikir.',
                'content' => '<h2>Merawat Otot Kreatif Tanpa Tekanan</h2><p>Kreativitas sering disalahpahami sebagai petir yang menyambar tiba-tiba. Di studio kami, kami memandangnya lebih seperti memasak sup hangat: butuh bahan segar, api yang pas, dan kesabaran mengaduk.</p><p>Berikut lima rutinitas harian yang membantu kami tetap bersemangat saat menghadapi lembar kanvas putih:</p><ol><li><strong>Sketsa 10 Menit Tanpa Menghapus:</strong> Ambil pensil atau pulpen tinta tahan air, lalu gambarlah benda di sekitar meja tanpa menyentuh karet penghapus. Tujuannya melatih keberanian tangan.</li><li><strong>Mengamati Gerak Keseharian:</strong> Perhatikan cara daun jatuh tertiup angin, ekspresi kucing saat menunggu makanan, atau langkah anak kecil di taman. Gerakan organik ini adalah sumber referensi gerak kartun yang kaya.</li><li><strong>Koleksi Palet Warna Alami:</strong> Foto kombinasi warna yang Anda temukan di pasar tradisional, kulit buah mangga, atau langit senja, lalu terapkan pada satu objek gambar mini.</li><li><strong>Membaca Buku Cerita Anak Bergambar:</strong> Melihat kembali buku cerita klasik melatih mata menyederhanakan bentuk rumit menjadi siluet yang bersahabat.</li><li><strong>Istirahat dan Menjauh dari Layar:</strong> Berjalan santai selama lima belas menit sering kali menjadi momen ide terbaik muncul tanpa dipaksa.</li></ol><p>Cobalah salah satu dari kebiasaan di atas hari ini dan amati bagaimana garis gambar Anda terasa lebih rileks dan mengalir.</p>',
                'thumbnail' => 'images/gallery/artwork-4-hutan-jamur-ajaib.svg',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subHours(4),
                'seo_title' => '5 Kebiasaan Sederhana Menjaga Imajinasi Kreatif - Dapur Kartun',
                'seo_description' => 'Temukan 5 tips menjaga kesegaran ide kreatif dan melatih konsistensi menggambar dari para ilustrator studio Dapur Kartun.',
            ],
            [
                'category_id' => $categories['pengumuman']->id,
                'user_id' => $adminId,
                'title' => 'Jadwal Rilis Episode Spesial Akhir Tahun Dapur Kartun',
                'slug' => 'jadwal-rilis-episode-spesial-akhir-tahun-dapur-kartun',
                'excerpt' => 'Kami sedang mempersiapkan sebuah tayangan istimewa bertema persahabatan di musim hujan yang akan tayang perdana menjelang penutupan tahun.',
                'content' => '<h2>Sebuah Kado Hangat Menjelang Pergantian Musim</h2><p>Untuk menyambut liburan akhir tahun, seluruh tim animator Dapur Kartun tengah merampungkan episode spesial berdurasi 12 menit. Tayangan ini didedikasikan untuk seluruh keluarga dan sahabat kecil yang telah setia menemani perjalanan karya kami.</p><p>Detail tanggal rilis, penayangan perdana daring, dan lembar aktivitas mewarnai gratis akan diumumkan lengkap saat waktu publikasi artikel ini tiba.</p>',
                'thumbnail' => 'images/gallery/artwork-6-buku-cerita-raksasa.svg',
                'status' => 'scheduled',
                'is_featured' => false,
                'published_at' => $now->copy()->addDays(5),
                'seo_title' => 'Jadwal Rilis Episode Spesial Akhir Tahun Dapur Kartun',
                'seo_description' => 'Pengumuman jadwal tayang episode animasi spesial akhir tahun dari Dapur Kartun.',
            ],
            [
                'category_id' => $categories['cerita-di-balik-karya']->id,
                'user_id' => $adminId,
                'title' => 'Catatan Eksplorasi Konsep Karakter Baru (Konsep Awal)',
                'slug' => 'catatan-eksplorasi-konsep-karakter-baru-konsep-awal',
                'excerpt' => 'Draf internal catatan perancangan siluet, ekspresi, dan backstory untuk karakter koki kue ajaib yang masih dalam tahap pengembangan tim desain.',
                'content' => '<h2>Draf Rahasia Studio</h2><p>Artikel ini berstatus draft dan hanya dapat diakses oleh administrator studio. Berisi catatan riset proporsi tubuh kepala-ke-badan 1:2 untuk karakter koki kue ajaib bernama Bolu.</p>',
                'thumbnail' => 'images/gallery/artwork-2-koki-bintang.svg',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
                'seo_title' => 'Draf Konsep Karakter Baru',
                'seo_description' => 'Catatan internal tim Dapur Kartun.',
            ],
        ];

        foreach ($articles as $art) {
            News::updateOrCreate(
                ['slug' => $art['slug']],
                $art
            );
        }
    }
}
