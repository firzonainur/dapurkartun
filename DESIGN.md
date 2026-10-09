# Panduan Identitas Visual Dapur Kartun (DESIGN.md)

Dokumen ini menjadi acuan tunggal seluruh elemen visual, komposisi, animasi, dan tipografi untuk website Dapur Kartun. Setiap halaman, komponen Blade, dan aset grafis wajib mematuhi panduan ini agar tampilan konsisten, memiliki karakter kuat, dan bebas dari pola generik (Anti-Slop compliant).

Dial: ENERGY 3 / RHYTHM 3 / MOTION 3

---

## 1. Identitas Visual dan Esensi Brand

- **Nama Brand:** Dapur Kartun
- **Karakter Brand:** Playful, artistik, hangat, imajinatif, dan premium.
- **Konsep Inti:** "Dapur" sebagai laboratorium kreasi tempat ide-ide segar "dimasak" menjadi karakter hidup, ilustrasi penuh warna, dan animasi bercerita.
- **Daya Tarik Utama:** Pengunjung merasa sedang diajak melangkah masuk ke dalam buku cerita kartun hidup dengan kedalaman visual bertingkat (multi-layer cartoon world).
- **Focal Point:** Ilustrasi hero bertingkat dengan karakter maskot koki kartun, kuas ajaib, buku gambar, dan awan melayang yang merespons pergerakan scroll.

---

## 2. Palet Warna dan Aturan Penggunaan

Palet Dapur Kartun terdiri dari 3 warna inti, 1 warna aksen bertenaga, dan 2 warna dasar netral hangat. Rasio kontras teks wajib memenuhi standar WCAG AA (minimal 4.5:1 untuk teks biasa dan 3:1 untuk teks besar).

### Warna Inti:
1. **Midnight Eggplant / Tinta Ungu Malam (`#1F1135` / `#2B174D`)**
   - *Fungsi:* Warna latar header solid saat scroll, teks judul utama di atas latar terang, kartu sorotan gelap, dan footer atmosferik.
   - *Alasan:* Memberikan kedalaman warna yang lebih kaya daripada hitam murni, memperkuat nuansa studio animasi malam hari yang magis.

2. **Warm Cream / Kertas Sketsa Hangat (`#FFFDF8` / `#FFF7EB`)**
   - *Fungsi:* Warna latar belakang utama halaman, kartu konten, dan bidang bacaan utama.
   - *Alasan:* Menghindari warna putih klinis (#FFFFFF) agar mata nyaman dan memunculkan sensasi kertas gambar kanvas manual.

3. **Sky Blue / Biru Langit Ceria (`#2AA9E0` / `#0284C7`)**
   - *Fungsi:* Latar langit hero section, tag kategori animasi, dan elemen awan dekoratif.
   - *Alasan:* Menciptakan suasana terbuka, lapang, dan kebebasan berimajinasi.

### Warna Aksen:
4. **Cartoon Tangerine / Oranye Jeruk Segar (`#FF6B35` / `#F95738`)**
   - *Fungsi:* Tombol aksi utama (CTA), tombol kirim, badge sorotan terpilih, dan efek hover navigasi aktif.
   - *Alasan:* Menarik perhatian mata secara terarah tanpa mengaburkan elemen di sekitarnya.

5. **Warm Sunshine Yellow (`#FFC107` / `#FBBF24`)**
   - *Fungsi:* Bintang rating, pendaran lampu kreatif, percikan kuas, dan aksen ceria.
   - *Alasan:* Simbol energi keceriaan anak-anak dan inspirasi kartun.

### Aturan Penerapan Warna:
- **Dilarang:** Menggunakan gradasi ungu-ke-pink neon generik di seluruh halaman.
- **Wajib:** Menguji kontras teks. Teks di atas latar ungu malam harus krem (`#FFFDF8`), teks di atas latar krem harus ungu tua (`#1F1135`).

---

## 3. Jenis Huruf dan Hierarki Tipografi

Tipografi memadukan font rounded display berkarakter kartun modern untuk judul utama dengan sans-serif humanis yang sangat nyaman dibaca untuk paragraf dan antarmuka formulir.

### Pemilihan Font:
- **Display / Judul:** `Plus Jakarta Sans` / `Fredoka` (Google Fonts), bobot Bold (700) hingga Extra Bold (800).
  - *Karakter:* Ujung kurva yang bersahabat, proporsi huruf yang kokoh, tidak kaku seperti font bisnis korporat, namun tetap terbaca sempurna di berbagai resolusi.
- **Teks Tubuh & UI:** `Plus Jakarta Sans` / `Inter`, bobot Regular (400), Medium (500), dan SemiBold (600).
  - *Karakter:* Geometris bersih, legibilitas tinggi untuk deskripsi karya dan input data admin.

### Skala Hierarki:
- **Hero Title (H1):** `3.25rem` (52px) desktop / `2.25rem` (36px) mobile, line-height 1.15, ExtraBold.
- **Section Title (H2):** `2.25rem` (36px) desktop / `1.75rem` (28px) mobile, line-height 1.25, Bold.
- **Card / Subheading (H3):** `1.35rem` (21px), line-height 1.35, SemiBold.
- **Body Text:** `1rem` (16px), line-height 1.6, Regular, warna `#372A4B` (kontras 8.2:1 di atas krem).
- **Small / Meta:** `0.875rem` (14px), line-height 1.5, Medium.

---

## 4. Gaya Ilustrasi Kartun

Ilustrasi adalah jiwa dari Dapur Kartun. Seluruh aset ilustrasi dirancang dengan spesifikasi berikut:
- **Gaya Garis (Line Art):** Outlines bersih dengan ketebalan proporsional (2px - 3.5px), sudut melengkung halus, tidak ada garis kasar patah-patah.
- **Warna & Bayangan:** Flat illustration dengan cel-shading lembut (1 tingkat bayangan hangat, bukan gradasi gelap acak).
- **Elemen Karakter:** Karakter maskot koki kreatif yang membawa palet cat, pensil raksasa, dan kuas animasi.
- **Elemen Pendukung:** Balon udara kecil, bintang kilau empat titik kartun, awan bulat berlapis, dan gelembung ide.
- **Format:** SVG vektor tajam dan gambar WebP teroptimasi yang dimuat secara instan tanpa glitch.

---

## 5. Aturan Komposisi Setiap Bagian Halaman

Setiap section memiliki struktur yang berbeda untuk menjaga ritme visual (RHYTHM 3):

1. **Header / Navigasi:**
   - Desain melayang (floating pill / full-width sticky).
   - Awalnya transparan menyatu dengan pemandangan langit hero section.
   - Berubah menjadi latar krem hangat atau ungu malam semi-solid saat digulir melewati 60px.
   - Dilengkapi menu mobile drawer yang ramah jempol.

2. **Hero Section (Full Viewport 90-100vh):**
   - Komposisi 2 kolom asimetris: teks narasi kuat di sisi kiri, panggung ilustrasi hidup berlapis di sisi kanan dengan latar belakang langit dan awan melayang.
   - Parallax slider minimal 3 slide yang dapat berganti secara otomatis maupun manual dengan transisi halus.

3. **Section Tentang Kami (Editorial Story Layout):**
   - Bukan sekadar grid kartu statis. Menampilkan kisah lahirnya Dapur Kartun dengan ilustrasi karakter di sisi samping, kutipan misi, dan ringkasan nilai studio.
   - Sorotan metrik studio yang dapat diubah administrator melalui database.

4. **Galeri Karya (Asymmetric / Masonry Grid):**
   - Menampilkan portofolio karya dengan kartu berbagai proporsi (potret, lanskap, bujur sangkar).
   - Filter tab kategori interaktif: Semua, Ilustrasi Kartun, Karakter, Animasi, Desain Kreatif.
   - Hover zoom lembut dengan info judul karya.
   - Modal lightbox resolusi penuh yang dapat ditutup dengan tombol Escape atau klik luar.

5. **Section Testimoni (Creative Bubble Cards):**
   - Menampilkan kutipan cerita pengalaman klien dalam bentuk kartu gelembung dialog kartun yang menyenangkan.
   - Dilengkapi foto avatar, nama klien, peran proyek, dan bintang kepuasan.
   - Ditandai secara jujur sebagai contoh data awal yang dapat diperbarui kapan saja di panel admin.

6. **Section Kontak (Surat Kolaborasi Interaktif):**
   - Menghadirkan formulir kontak yang terhubung langsung ke SQLite dengan validasi server-side dan perlindungan anti-spam honeypot.
   - Dilengkapi tombol cepat WhatsApp resmi yang nomornya dapat diatur dari pengaturan admin.

7. **Footer (Dunia Bawah Langit Studio):**
   - Latar ungu malam pekat dengan ornamen bukit kartun atau siluet atap studio.
   - Informasi navigasi, copyright dinamis, dan tautan sosial media aktif.

---

## 6. Prinsip Penggunaan Efek Parallax dan Gerakan

- **Tujuan Parallax:** Menciptakan ilusi kedalaman spasial (depth of field). Lapisan langit paling lambat (`speed: 0.15`), awan sedang (`speed: 0.3`), karakter utama bergerak dinamis (`speed: 0.5`), dan elemen foreground bergerak paling responsif.
- **Performa:** Menggunakan CSS `transform: translate3d()` atau `translateY()` yang dioptimalkan oleh GPU browser, tanpa memicu reflow tata letak berulang.
- **Aksesibilitas:** Menghormati media query `@media (prefers-reduced-motion: reduce)`. Jika pengguna memilih mode tanpa animasi, efek parallax dinonaktifkan secara otomatis dan konten ditampilkan dalam posisi statis yang nyaman.

---

## 7. Panduan Tampilan Desktop dan Perangkat Seluler (Mobile-First)

- **Target Sentuh Mobile:** Seluruh tombol dan tautan navigasi memiliki tinggi minimal 44px dengan padding nyaman.
- **Pencegahan Horizontal Overflow:** Tidak boleh ada elemen dengan lebar tetap (fixed width) yang melebihi 100vw.
- **Adaptasi Mobile:**
  - Slider hero menyederhanakan layer parallax untuk menghemat baterai perangkat.
  - Galeri beralih dari grid 3 kolom desktop menjadi 1 atau 2 kolom pada smartphone.
  - Drawer menu mobile mudah dijangkau satu tangan dengan animasi slide-in halus.

---

## 8. Standar Kode dan Arsitektur Laravel

- Struktur MVC rapi: Model Eloquent, Controller berfokus, Request validation tersendiri, dan Blade Components modular.
- Seluruh data (slider, galeri, testimoni, kontak, pengaturan situs) terpusat pada database SQLite yang tangguh dan ringan.
- Panel admin diamankan dengan autentikasi sesi bawaan Laravel, proteksi CSRF di setiap form, dan hashing password Bcrypt.
