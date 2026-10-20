# Hamago Pest Solutions — WordPress Theme

Theme WordPress modern untuk **hamagopest.co.id**, dibangun dari desain
`hamagopest-template.html` dengan standar WordPress terbaru.

## ✨ Fitur Utama

| Fitur | Detail |
|---|---|
| 🎨 Warna brand | **Rebrand v1.1.0** — Navy `#0D1438` (dominan), Azure `#3F6DF2`, Gold `#FFC233` (tombol lebih cerah). Tanpa hijau. |
| 🔤 Tipografi | **Sora** untuk heading, **Inter** untuk body |
| 🔄 Hero animasi | Icon hama **berputar mengorbit** radar (2 orbit, arah berlawanan), radar sweep, ripple, counter-rotate agar icon tetap tegak. **v1.5.0:** hero juga mendukung **upload gambar** — 1 gambar = background statis, **lebih dari 1 gambar = slider otomatis** (autoplay, panah, dots, swipe) dengan **overlay bayangan gelap default 30%** (adjustable 0–90%) |
| 🌀 Parallax | Smooth parallax on scroll (blob hero, radar, visual, banner) dengan rAF lerp |
| 🎬 Scroll reveal | Semua section muncul dengan animasi fade-up/left/right/zoom (IntersectionObserver) |
| 📱 Responsive | Desktop, iPad/tablet (980px), mobile (720px) + reduced-motion accessibility |
| 🎛️ Homepage editor | **v1.7.0** — seluruh konten homepage diedit via **Customizer** (Appearance → Customize → Hamago Pest — Pengaturan → Homepage — ...): hero (teks, tombol, 3 statistik, **5 slot gambar** — 2+ gambar jadi slider otomatis, overlay default 30%), USP, Tentang, 7 Layanan + metode, Cara Kerja, Video CTA, Klien, Testimoni, Booking — plus show/hide per section |
| 🧩 Elementor (opsional) | **14 widget kustom** kategori **"Hamago Elements"** — termasuk Hero Halaman (banner inner page), Tentang Kami (Halaman), Daftar Layanan (Halaman), dan Kontak & Maps — + template otomatis di Saved Templates: "Beranda", "Tentang Kami", "Layanan", "Kontak" — Hamago (Theme) |
| 📝 Blog rapi | Halaman `/blog` menampilkan **grid 3 kolom, 6 artikel/halaman + pagination** — artikel dobel akibat Query Loop block tersalin otomatis hilang (template `page-blog.php` mengabaikan isi editor; berlaku juga bila Blog di-set sebagai Posts page) |
| 📍 Maps | Halaman Kontak menampilkan **Google Maps embed** — URL bisa diisi per-widget, via Customizer, atau otomatis dari alamat kantor |
| 🖼️ Logo editable | Customizer → Situs Identity → Logo (header) + logo footer |
| 📞 Kontak & sosial | Semua nomor telepon, WhatsApp, alamat, sosial media editable via Customizer |

## 📦 Instalasi

1. Zip folder `hamagopest/` → **Appearance → Themes → Add New → Upload** → aktifkan.
   (Atau salin folder ke `wp-content/themes/`.)
2. **Settings → Reading** → *Your homepage displays* → **A static page** → pilih halaman
   beranda (atau biarkan default: theme otomatis menampilkan homepage demo lengkap).
3. **Appearance → Customize → Situs Identity** → unggah **Logo** (header).
4. **Appearance → Customize → Hamago Pest — Pengaturan** → isi nomor telepon,
   nomor WhatsApp, alamat, email, sosial media, teks footer, dan logo footer.

## 🏠 Beranda Elementor (Template JSON)

File **`hamagopest-beranda-elementor.json`** (copy identik ada di
`inc/elementor/beranda-template.json`) adalah template Elementor **Beranda**
yang isinya sama persis dengan homepage demo — 10 section memakai widget
Hamago Elements: Hero (radar orbit), USP, Tentang, Layanan, Cara Kerja,
Video CTA, Klien, Testimoni, Artikel, Booking WhatsApp.

Dua cara pakai:

1. **Otomatis (disarankan):** aktifkan theme → klik notice di dashboard
   *"Siapkan Halaman Beranda (Elementor)"* → halaman Beranda dibuat,
   template langsung diterapkan, dan editor Elementor terbuka. Tinggal edit.
2. **Manual:** buat halaman baru → **Edit dengan Elementor** → ikon folder
   (Templates) → **Import Template** → upload `hamagopest-beranda-elementor.json`.

> Di widget Hero, upload 2+ gambar pada tab *Gambar Hero* untuk mengubah hero
> menjadi slider otomatis (overlay bayangan gelap default 30%).

## 📥 Import Demo Content (Sekali Klik)

File `hamagopest-demo-content.xml` berisi **seluruh isi website demo** dalam satu file
WXR: 11 halaman (termasuk 4 halaman layanan), 4 artikel blog, 4 kategori, dan
2 menu navigasi lengkap dengan submenu.

1. **Tools → Import → WordPress** → Install Now (sekali saja) → **Run Importer**.
2. Upload `hamagopest-demo-content.xml` → pilih author → centang
   *Download and import file attachments* (opsional) → **Submit**.
3. Selesai ✨ — menu **otomatis ditempel** ke lokasi *Menu Utama (Header)* dan
   *Menu Footer* saat pertama kali halaman dibuka (fitur auto-assign theme),
   dan homepage demo tetap tampil selama halaman beranda belum diisi konten.

Hasil import:

| Jenis | Isi |
|---|---|
| Halaman | Beranda, Tentang Kami, Layanan, FAQ, Kontak, Booking, Blog |
| Layanan (child) | Pengendalian Rayap, Pengendalian Serangga, Pengendalian Tikus, Desinfektan |
| Artikel | 4 artikel edukasi hama (rayap, chikungunya, DBD, malaria) + kategori |
| Menu | **Menu Utama (Header)** & **Menu Footer** + submenu layanan |

> 💡 Opsional tapi disarankan: **Settings → Reading** → Homepage = **Beranda**,
> Posts page = **Blog** agar daftar artikel muncul di `/blog`.
> Lalu isi **Customizer → Hamago Pest — Pengaturan** (WA, telepon, alamat).

## 🧩 Editing Section dengan Elementor

1. Install & aktifkan plugin **Elementor** (gratis, versi terbaru).
2. Buat/edit halaman → **Edit with Elementor**.
3. Di panel widget, cari kategori **"Hamago Elements"**. Tersedia:

   | Widget | Fungsi |
   |---|---|
   | Hamago — Hero (Icon Berputar) | Headline, tombol, statistik, radar orbit lengkap (icon, kecepatan, warna per-icon bisa diatur) |
   | Hamago — Keunggulan (USP) | 4 keunggulan di atas background navy |
   | Hamago — Tentang Kami | Kotak statistik + narasi |
   | Hamago — Layanan | Kartu layanan (icon, judul, deskripsi, link, 2–4 kolom) |
   | Hamago — Cara Kerja | Langkah bernomor |
   | Hamago — Video CTA | Banner navy + tombol play (lightbox) |
   | Hamago — Klien & Mitra | Pill klien / logo, opsi marquee |
   | Hamago — Testimoni | Kartu testimoni + bintang |
   | Hamago — Artikel Terbaru | Post terbaru otomatis |
   | Hamago — Booking CTA | Banner emas + tombol WhatsApp otomatis |
   | **Hamago — Hero Halaman (Banner)** | Banner navy halaman dalam: breadcrumb, judul, deskripsi, blob & ring animasi — untuk Tentang/Layanan/Kontak/FAQ |
   | **Hamago — Tentang Kami (Halaman)** | Foto bertumpuk + badge melayang, checklist, **statistik count-up**, kartu nilai, timeline perjalanan, pill sertifikasi |
   | **Hamago — Daftar Layanan (Halaman)** | Kartu layanan modern (gambar + icon chip + badge + chips metode + link), 2–4 kolom, CTA WhatsApp |
   | **Hamago — Kontak & Maps** | Kartu info otomatis Customizer (telepon/WA/email/alamat/jam), slot shortcode form (CF7/WPForms), **Google Maps embed** |

4. Setiap widget punya opsi **background section** dan **Animasi Parallax saat Scroll**.
5. Gunakan **Elementor Pro Theme Builder** (opsional) untuk mengganti header/footer —
   theme otomatis mendeteksi dan memberi lokasi `header`, `footer`, `single`, `archive`.

> 💡 Tip: set Layout halaman Elementor ke **Full Width / Canvas** untuk hasil terbaik,
> karena setiap widget Hamago sudah membawa lebar konten & padding section-nya sendiri.

## 🖼️ Desain Modern untuk Tentang Kami / Layanan / Kontak (1 Klik)

Theme menyertakan **template desain modern** untuk halaman inner (banner hero animasi + konten modern + CTA). Tiga cara memakainya:

1. **Otomatis (disarankan):** buka **WP Dashboard** → notice "Hamago Theme" menampilkan tombol
   **"Terapkan Desain Modern — Tentang Kami / Layanan / Kontak"** → klik → konten halaman diganti desain baru dan **editor Elementor langsung terbuka**.
   Saat membuka halaman lama, admin juga melihat **hint melayang** kiri bawah dengan link yang sama.
2. **Dari editor Elementor:** ikon folder (Templates) → **My Templates** → sisipkan
   "Tentang Kami — Hamago (Theme)" / "Layanan — Hamago (Theme)" / "Kontak — Hamago (Theme)"
   (terdaftar otomatis, tanpa import file).
3. **Import manual:** file JSON ada di `inc/elementor/tentang-kami-template.json`, `layanan-template.json`, `kontak-template.json`.

> ⚠️ Menerapkan template **mengganti konten lama** halaman tersebut (konten editor dikosongkan).
> Foto, teks, dan angka kemudian diedit bebas via Elementor.

## 📝 Halaman Blog (Grid + Pagination)

- Page dengan slug **`blog`** otomatis memakai template `page-blog.php`: **grid 3 kolom · 6 artikel per halaman · pagination** bila artikel > 6. Sekaligus membetulkan artikel **tampil dobel** (penyebab: Query Loop block tersalin berkali-kali di konten halaman — isi editor kini diabaikan).
- Bila Blog di-set sebagai **Posts page** (Settings → Reading), `index.php` dipakai dengan hero modern yang sama + **6 artikel/halaman**.
- Ganti jumlah per halaman: filter `hamagopest_blog_posts_per_page` (di child theme / Code Snippets).

## 📍 Peta Google Maps (Halaman Kontak)

Widget **Hamago — Kontak & Maps** mencari URL embed dengan urutan:
1. Isian **URL Embed Peta** di widget;
2. **Customizer → Hamago Pest — Pengaturan → Kontak & WhatsApp → URL Embed Google Maps**;
3. **Fallback otomatis**: peta pencarian berdasarkan **Alamat Kantor** (tanpa API key).

Cara ambil URL: Google Maps → cari lokasi → **Bagikan → Sematkan peta** → salin (boleh seluruh kode iframe — `src` diekstrak otomatis).

## 🔧 Kustomisasi Hero (icon berputar)

Widget Hero → tab **Radar — Icon Berputar**:
- **Icon Tengah (Core)** — ganti icon perisai di tengah radar.
- **Icon Hama** — repeater: pilih icon (30+ icon line SVG), orbit (luar/dalam),
  warna (navy/gold), dan posisi awal (derajat).
- **Kecepatan Rotasi** — slider detik/putaran untuk orbit luar & dalam.
- **Radar Sweep / Ripple** — hidupkan-matikan efek sapuan & gelombang.

## 🗂️ Struktur

```
hamagopest/
├── style.css                    (meta theme)
├── theme.json                   (palette + font global editor)
├── functions.php
├── header.php / footer.php      (topbar, sticky header, drawer, footer, WA float)
├── front-page.php               (Elementor page atau demo homepage)
├── page-blog.php                (halaman Blog: grid 3 kolom + 6/halaman + pagination)
├── template-parts/home-demo.php (homepage default, icon berputar)
├── assets/css/main.css          (seluruh styling + animasi + responsive)
├── assets/css/elementor.css     (layer kompatibilitas Elementor + responsive)
├── assets/js/main.js            (reveal, parallax smooth, drawer, back-top, count-up)
└── inc/
    ├── customizer.php
    ├── template-tags.php
    ├── admin-pages.php          (template & tombol "Desain Modern" Tentang/Layanan/Kontak)
    └── elementor/               (14 widget "Hamago Elements" + 4 template JSON)
```

## ✅ Checklist Kompatibilitas

- WordPress 6.0+ · **PHP 7.4 – 8.2+ (aman di cPanel PHP 8.2)** · Elementor 3.x terbaru
- Registrasi widget mendukung Elementor **3.5+ dan versi lebih lama**
- Elementor Pro Theme Builder locations (`header`, `footer`, `single`, `archive`)
- Gutenberg / block editor (theme.json + editor styles)
- Responsive semua device & `prefers-reduced-motion`

> ⚠️ **Penting untuk cPanel / shared hosting (PHP 8.2):**
> 1. Pastikan plugin **Elementor di-update ke versi terbaru** — Elementor lama
>    (< 3.12) fatal di PHP 8.2 (bukan bug theme).
> 2. Naikkan memory limit di `wp-config.php` (editor Elementor butuh ≥256MB):
>    `define( 'WP_MEMORY_LIMIT', '256M' );`
> 3. Jika editor Elementor blank/error 500, cek **ModSecurity** di cPanel
>    (minta host men-whitelist `/wp-admin/admin-ajax.php` dan editor Elementor).
> 4. Untuk melihat error pasti: aktifkan log via `define( 'WP_DEBUG_LOG', true );`
>    lalu lihat `wp-content/debug.log`.

## 📋 Changelog

### v1.9.0 — Mode Manual: Otomasi Dihapus Total
- **Semua tombol/aksi otomatis DIHAPUS** dari `inc/admin-pages.php`: notice dashboard "Terapkan Desain Modern", handler apply, hint melayang di front-end, tombol "Perbaiki Widget", penangkap fatal, self-heal widget, auto-sync Saved Templates. File kini hanya berisi `hamagopest_apply_page_template_file()` karena masih dipakai sistem Beranda.
- **Desain modern diterapkan MANUAL via import JSON**: Elementor → Templates → Saved Templates → Import Templates → pilih file dari `hamago-elementor-templates-IMPORT/` (tentang-kami, layanan, kontak, beranda) → sisipkan ke halaman lewat editor (tab My Templates).
- Widget halaman modern tetap teregistrasi lewat jalur hook Elementor standar (lazim & aman); guard v1.8.6 dipertahankan sehingga file theme yang belum lengkap tidak pernah memicu fatal.
- Entry Saved Templates lama hasil auto-sync (mis. "Tentang Kami — Hamago (Theme)") boleh dihapus manual bila tidak dipakai.

### v1.8.6 — Theme Load Anti-Fatal Total
- **`hamagopest_elementor_init()` kini tidak pernah memicu fatal**: `class-widget-base.php` diverifikasi (ada + ukuran wajar) SEBELUM file widget dimuat; bila base hilang, seluruh pemuatan widget dilewati dengan aman (self-heal di admin-pages.php mengambil alih begitu file tersedia). Sebelumnya: elementor.php baru + base hilang = fatal di SEMUA halaman.
- Semua `require` widget kini juga dijaga `filesize() > 200` (file terpotong 0 byte pun tidak ikut termuat).

### v1.8.5 — Kebal Upload Parsial (root cause halaman kosong)
- **Diagnosis pasti (dari penangkap fatal v1.8.4):** `class-widget-base.php` tidak ada/kosong di server + `elementor.php` kemungkinan versi lama — widget halaman modern tidak pernah dimuat/teregistrasi, itulah akar "halaman kosong" sejak awal. PHP server 8.2 (bukan masalah versi).
- **Pre-flight di tombol Perbaiki**: seluruh file dependensi diperiksa (ada + ukuran wajar) SEBELUM require — bila ada yang bermasalah, tampil daftar file + solusi upload, TANPA fatal error.
- **Self-heal permanen** (`hamagopest_selfheal_modern_widgets`): dipasang dari admin-pages.php (selalu versi baru) langsung ke hook `elementor/widgets/register` — memuat base/icons/4 widget dan mendaftarkannya secara LAZY tepat saat Elementor butuh, TIDAK bergantung pada elementor.php. Setelah file lengkap ter-upload, semua halaman/template yang “kosong” langsung tampil normal tanpa perlu apply ulang.

### v1.8.4 — Perbaiki Widget Anti-Fatal + Diagnostik
- **Naikkan memory limit & time limit** saat aksi perbaikan (`wp_raise_memory_limit('admin')` + 120 dtk) — inisialisasi seluruh widget Elementor di request admin pernah memicu fatal error di shared hosting.
- **Penangkap fatal error** (`register_shutdown_function`): fatal parse/runtime yang tak bisa ditangkap try/catch kini tercatat lengkap (langkah berjalan, pesan, file, baris, versi PHP) ke option `hamagopest_repair_last_error` + error_log, dan ditampilkan sebagai **notice merah** di dashboard — mengubah layar "critical error" polos menjadi data diagnosis presisi.
- `hamagopest_repair_last_result` menyimpan hasil terakhir perbaikan (PHP, memory_limit, file hilang, jumlah widget terdaftar).
- Registrasi kini lewat jalur hook normal: `get_widget_types()` dipanggil sekali di awal (memicu `elementor/widgets/register`), lalu hanya widget yang benar-benar belum terdaftar yang di-`register` manual.

### v1.8.3 — Tombol Perbaiki Widget + Diagnosis Presisi
- **Notice warning kini membedakan 2 penyebab**: (1) file widget TIDAK ADA di server → upload theme belum lengkap, (2) file ADA tapi tidak termuat → OPcache basi. Pesan solusinya spesifik per kasus.
- **Tombol “Perbaiki Sekarang” (satu klik)** di notice: force-require file widget langsung dari `inc/admin-pages.php` (file yang dijamin versi baru), daftarkan semua widget theme ke widgets_manager, lalu bersihkan cache CSS Elementor. Jalur ini tidak bergantung pada `elementor.php` yang mungkin masih ter-cache lama — file widget baru otomatis dikompilasi segar oleh PHP karena path-nya belum pernah ada di OPcache.
- Konfirmasi hijau setelah perbaikan berhasil (`hmg_repaired` + nonce).
- Catatan: template yang diimport ke Saved Templates juga tampil kosong selama widget belum termuat — setelah tombol perbaikan sukses, template tersebut langsung tampil normal tanpa perlu import ulang.

### v1.8.2 — Fix Halaman Kosong Setelah Terapkan Desain Modern
- **[FIX] Halaman/Editor jadi KOSONG setelah "Terapkan Desain Modern"** — akar masalah BUKAN format template, melainkan widget theme tidak teregistrasi di server (upload theme parsial atau OPcache menyajikan file PHP lama). Elementor me-render widget tak dikenal sebagai **kosong tanpa peringatan** (container terlihat, isi hilang) — data template sendiri tersimpan benar di database.
  - Registrasi widget kini **self-healing per-widget**: diperiksa satu per satu di hook `init` DAN `wp_loaded` (`hamagopest_register_widgets_safe()`) — begitu file tersedia/cache bersih, widget langsung teregistrasi & halaman yang "kosong" tampil sendiri tanpa perlu apply ulang.
  - **Deteksi partial upload**: tombol apply kini memeriksa keempat kelas widget lebih dulu — bila hilang, muncul pesan jelas + solusi (upload ulang ZIP lengkap / bersihkan OPcache) BUKAN halaman kosong diam-diam. Notice warning juga muncul di dashboard.
  - Urutan handler dirapikan: konten editor lama dikosongkan SEBELUM meta Elementor ditulis.
- **File import JSON siap pakai**: `../hamago-elementor-templates-IMPORT/` + `../hamago-elementor-templates-IMPORT.zip` (di luar folder theme) berisi 4 template: hamago-tentang-kami.json, hamago-layanan.json, hamago-kontak.json, hamago-beranda.json — bisa diimport via Elementor → Templates → Saved Templates → Import.

### v1.8.1 — Fix Tombol "Terapkan Desain Modern" (403)
- **[FIX] "Sorry, you are not allowed to access this page" saat klik Terapkan Desain Modern** — tombol memakai query param `page` pada `admin.php`, padahal itu variabel **reserved** WordPress core untuk halaman plugin. Core memvalidasi menu akses di `wp-admin/menu.php` (sebelum hook `admin_init` theme berjalan), tidak menemukan menu dengan slug tersebut, dan menolak akses — termasuk untuk super admin. Param diganti menjadi `hmg_page` (aman, tidak dibaca core).

### v1.8.0 — Blog Rapi & Halaman Inner Modern
- **[FIX UTAMA] Blog tampil dobel** — halaman `/blog` berisi Query Loop block Gutenberg yang tersalin beberapa kali sehingga tiap artikel muncul berulang. Template baru `page-blog.php` (otomatis dipakai page slug `blog`) **mengabaikan isi editor** dan menampilkan **grid 3 kolom · 6 artikel/halaman · pagination**. Bila Blog di-set sebagai Posts page, `index.php` tampil dengan hero modern + 6/halaman via `pre_get_posts`. Bila halaman blog dibangun sendiri dengan Elementor (ada kontennya), konten Elementor yang dirender.
- **4 widget Elementor baru** (total 14): Hero Halaman (Banner), Tentang Kami (Halaman) — statistik **count-up**, Daftar Layanan (Halaman) — link ke 4 halaman detail layanan, Kontak & Maps — **Google Maps embed** + slot shortcode form.
- **Template desain modern 1-klik** untuk Tentang Kami / Layanan / Kontak: otomatis di Saved Templates, tombol "Terapkan Desain Modern" di dashboard, hint melayang di halaman (khusus admin). Eksplisit via tombol — theme tidak pernah menimpa konten diam-diam.
- **Customizer baru**: Jam Operasional & URL Embed Google Maps.
- **JS**: animasi count-up `[data-count]` (support "1.200+", "98%", "4.9"; hormat reduced-motion).
- **CSS**: blok Halaman Inner Modern (page hero blob/grid/ring, about, layanan, kontak) + responsive + reduced-motion.
- Refactor: `hamagopest_apply_page_template_file()` generik; sinkronisasi Saved Templates disatukan di `inc/admin-pages.php`.
### v1.4.2 — Perbaikan Logo Turun ke Bawah (Nested Anchor)
- **[FIX UTAMA] HTML invalid `<a>` di dalam `<a>`** — header.php/footer.php
  dulu membungkus output `hamagopest_site_logo()` dengan `<a>` sendiri, padahal
  `the_custom_logo()` sudah mengeluarkan `<a class="custom-logo-link">` miliknya.
  Browser memecah DOM akibat nested anchor → logo gambar "turun ke bawah" /
  tidak sejajar dengan menu. Kini fungsi logo selalu membawa anchor sendiri
  dan pemanggil tidak lagi membungkus.
- **CSS branding dirapikan** — `.site-branding` jadi flex container dengan
  `align-items: center`, `.custom-logo-link` inline-flex + `line-height: 0`
  (menghilangkan celah baseline inline yang membuat logo tampak lebih rendah).
- **Logo responsive bertingkat**: 54px desktop → 48px tablet (≤980px) →
  44px mobile (≤720px) → 40px mobile kecil (≤400px); teks brand ikut mengecil.

### v1.4.1 — Perbaikan Menu Numpuk & Dropdown
- **[FIX UTAMA] Dropdown submenu desktop** — menu sebelumnya tidak punya
  styling dropdown sama sekali, sehingga menu bertingkat (mis. "Layanan"
  dengan submenu dari import demo) dirender menumpuk vertikal di header.
  Kini submenu tampil sebagai dropdown card melayang (hover + keyboard
  focus), rapi & smooth.
- **Fallback menu tidak lagi membajak settingan user** — dulu theme diam-diam
  menempel menu pertama alfabetis ke lokasi header/footer ketika lokasi kosong
  (nav_menu_locations ditulis permanen), sehingga header menampilkan menu yang
  salah. Sekarang theme hanya menampilkan menu bila slug cocok dengan hasil
  import demo (menu-utama/menu-footer) — tanpa menulis settingan.
- **Burger lebih awal (≤1080px)** — menu banyak item tidak lagi melipat 2
  baris di layar sedang; langsung berubah jadi drawer mobile.
- **Drawer mobile menampilkan submenu** (depth 2) dengan indentasi rapi +
  penanda ▸ untuk item yang punya anak.
- `.main-menu` kini `flex-wrap: nowrap` dan item tidak menyusut.

### v1.4.0 — Hardening Anti-Error (PHP 8.2 / cPanel)
- **Integrasi Elementor kini fail-safe total** — seluruh inisialisasi,
  registrasi widget/kategori/lokasi dibungkus `try/catch \Throwable` dan
  dicatat ke error log, sehingga apapun yang salah di integrasi TIDAK PERNAH
  menjatuhkan website (tidak ada white screen).
- **45 pengaman akses array** — semua akses data repeater/settings di 10
  widget diberi null-coalescing (`??`) untuk mencegah warning
  "Undefined array key" yang di PHP 8.2 tampil sebagai error di layar
  bila `display_errors` aktif (umum di cPanel).
- `get_style_depends()` widget dikembalikan kosong — CSS theme memang sudah
  dimuat global; mencegah notice "handle tidak terdaftar" di editor Elementor.
- Hook registrasi diberi guard `has_action()` + guard statis anti ganda.
- File widget hanya dimuat bila `is_readable()`.

### v1.3.0 — Perbaikan Kompatibilitas Elementor & Responsive
- **[FIX KRITIS] Integrasi Elementor tidak pernah berjalan** — pola lama
  `add_action('elementor/loaded')` di theme adalah *dead code*: WordPress
  memuat plugin dulu, jadi hook `elementor/loaded` sudah terpicu sebelum
  `functions.php` theme dibaca. Akibatnya widget "Hamago Elements" tidak
  pernah teregistrasi & Theme Builder tidak terdeteksi. Sekarang theme
  menjalankan integrasi langsung via `did_action('elementor/loaded')`.
- **Front page Elementor kini tampil** — dulu theme mendeteksi halaman via
  `post_content` (yang selalu **kosong** pada halaman Elementor karena data
  tersimpan di `_elementor_data`), sehingga hasil edit Elementor tidak pernah
  muncul. Sekarang deteksi memakai meta `_elementor_edit_mode`.
- **Halaman Elementor tidak lagi terjepit** — konten dulu dibungkus
  `.single-content` (max-width 780px); sekarang halaman yang dibangun dengan
  Elementor dirender full-width tanpa wrapper & tanpa judul duplikat.
- **Perbaikan fatal error potensial** — `hamagopest_is_elementor_page()` dulu
  memanggil method pada nilai `false` (white screen di beberapa kasus);
  sekarang aman berbasis meta.
- **UI editor Elementor tidak lagi rusak** — `main.css` dulu dimuat ke halaman
  admin editor dan class `.wrap` theme bertabrakan dengan `.wrap` WordPress
  admin. Kini CSS theme hanya dimuat di **iframe preview**; editor hanya
  memuat font.
- **Registrasi widget kompatibel semua versi** — hook `elementor/widgets/register`
  (Elementor 3.5+) + fallback `widgets_registered` (`register_widget_type`)
  untuk versi lebih lama.
- **Elementor Pro Theme Builder lengkap** — lokasi `single` & `archive` kini
  juga didukung (sebelumnya hanya `header` & `footer`).
- **CSS layer Elementor terpisah** — baru `assets/css/elementor.css`, dimuat
  hanya di halaman Elementor: perbaikan lebar container, grid 1-kolom mobile,
  tipografi, dan preview editor.
- **JS aman di editor** — intersepsi anchor smooth-scroll otomatis nonaktif
  saat Elementor editor aktif.
- Pembersihan aturan CSS yang bisa menimpa tipografi kit Elementor.

### v1.2.0 — Penambahan Layanan
- Section layanan kini **7 kartu**: Rodent Control, Pest Control, Termite
  Control (dengan daftar metode: **Pipanisasi**, **Baiting/Pengumpanan**,
  **Injeksi/Penyuntikan Chemical Anti Rayap**), **Fumigasi**,
  Disinfeksi & Sanitasi, Pengendalian Hewan Pengganggu (ular, biawak, kucing
  liar, tawon, lebah), dan Pengharum Ruangan (kantor & hotel).
- Icon baru di library theme: `fumigation`, `snake`, `scent`.
- Widget Elementor "Hamago — Layanan": field baru **Daftar Metode / Poin**
  (satu poin per baris, tampil sebagai bullet di kartu).
- Link layanan di footer mengikuti daftar layanan baru.
- Demo statis: `hamagopest-demo.html` & `hamagopest-template.html` diperbarui.

### v1.1.0 — Rebrand Warna (Navy)
- Warna dominan diganti **Navy `#0D1438`** (topbar, header section gelap, USP,
  video CTA, footer, mobile drawer, radar core, tombol `btn-pine`).
- **Semua nuansa hijau dihilangkan** — accent `leaf` diganti **Azure `#3F6DF2`**
  (eyebrow, hover card, link, radar sweep/ripple, blob hero).
- **Tombol lebih cerah** — `btn-gold` kini gradient `#ffd23f → #ffb92e` dengan
  glow lebih kuat + hover `brightness(1.06)`; booking banner & bintang testimoni
  ikut lebih cerah (`#FFC233`).
- Palet `theme.json`, editor style, dan label pilihan warna widget Elementor
  ikut diperbarui (nilai `pine`/`gold` pada setting lama tetap kompatibel).
- Demo statis: `hamagopest-demo.html` ikut direbrand.

### v1.0.0 — Rilis awal
- Theme WordPress + 10 widget Elementor "Hamago Elements" + demo content XML.
# hamagopest
