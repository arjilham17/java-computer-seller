# Product Requirements Document (PRD)
## Website Landing Page — Java Computer Seller

---

### 1. Informasi Umum Proyek
- **Nama Toko / Brand:** Java Computer Seller
- **Jenis Website:** Landing Page Katalog & Promo Penjualan Perangkat Komputer
- **Framework Backend & Templating:** Laravel 11 (PHP 8.2 via XAMPP `/c/xampp/php/php.exe` + Blade Template Engine)
- **Framework UI / CSS:** Bootstrap 5.3 (`bootstrap.min.css` & `bootstrap.bundle.min.js` + Bootstrap Icons)
- **Alur Konversi (CTA):** Checkout langsung ke WhatsApp (`https://wa.me/<NOMOR_WA>?text=...`) dengan pesan otomatis berisi nama barang, merek, varian spesifikasi, jumlah unit, dan estimasi total harga.

---

### 2. Latar Belakang & Tujuan
**Java Computer Seller** menjual perangkat komputer meliputi **Laptop, PC Desktop/Rakitan, Printer, Monitor, dan Aksesoris Komputer** dengan berbagai pilihan merek dan varian spesifikasi (prosesor, RAM, SSD, ukuran layar, atau paket konektivitas).
Tujuan landing page ini adalah:
1. Menampilkan **Promo Terbatas / Flash Deal** secara menonjol di bagian atas halaman (Hero Banner).
2. Memudahkan calon pembeli membandingkan **spesifikasi dan harga varian** secara cepat dengan tampilan **Clean & Minimalis Modern** berbasis komponen Bootstrap 5.
3. Mengubah pengunjung menjadi pembeli melalui tombol **Pesan via WhatsApp** yang otomatis menyusun detail pesanan tanpa perlu registrasi akun atau keranjang belanja yang rumit.

---

### 3. Target Pengguna
- **Pelajar & Mahasiswa:** Mencari laptop atau printer bergaransi dengan harga hemat sesuai anggaran.
- **Pekerja Kantoran & UMKM:** Mencari paket PC desktop/kasir, monitor IPS, dan printer EcoTank siap pakai.
- **Gamer & Kreator Konten:** Mencari laptop/PC dengan varian spesifikasi RAM/GPU lebih tinggi dan konsultasi upgrade cepat via WhatsApp.

---

### 4. Ruang Lingkup Fitur (Functional Requirements)

#### 4.1. Sticky Navbar (Bootstrap `navbar`)
- Menampilkan identitas **Java Computer Seller** dan sub-label kategori (`Laptop • PC • Printer • Monitor • Aksesoris`).
- Tombol cepat **Chat Admin WhatsApp** (`btn btn-success`) di kanan atas untuk konsultasi spesifikasi umum.

#### 4.2. Hero Banner + Penawaran Promo Terbatas
- Menggunakan grid responsif Bootstrap (`row align-items-center g-4`).
- **Kolom Kiri (Value Proposition):**
  - Badge promo terbatas (`badge text-bg-primary`).
  - Headline utama yang tegas, deskripsi singkat keunggulan toko (garansi jelas, gratis instalasi/konsultasi), serta tombol navigasi ke katalog (`#katalog`).
- **Kolom Kanan (Kartu Promo Utama / Flash Deal):**
  - Kartu Bootstrap (`card border-primary shadow-sm`) yang menampilkan produk promo unggulan minggu ini, harga coret (`text-decoration-line-through text-muted`), harga promo besar, nominal penghematan, dan tombol ambil promo langsung ke WhatsApp.

#### 4.3. Katalog Produk & Varian Spesifikasi
- **Filter Kategori & Pencarian:**
  - Tombol filter kategori menggunakan Bootstrap `nav-pills` / `btn-group` (`Semua`, `Laptop`, `PC`, `Printer`, `Monitor`, `Aksesoris`) dan input pencarian merek/spesifikasi (`form-control`).
- **Kartu Produk (`card h-100 shadow-sm border-0`):**
  - Foto produk, badge promo/kondisi, label kategori & merek.
  - Daftar spesifikasi inti (`badge text-bg-light border`).
  - Dropdown pemilih varian spesifikasi (`form-select`) — misalnya pilihan kapasitas `RAM/SSD` pada Laptop/PC atau tipe `Print Only vs WiFi` pada Printer.
  - Baris harga dinamis: menampilkan **Harga Coret**, **Harga Promo**, dan **Badge Hemat** yang langsung berubah mengikuti varian yang dipilih.
  - Input jumlah barang (`form-control` tipe `number`, minimal `1`).

#### 4.4. Generator Pesan WhatsApp Otomatis
- Saat pembeli mengubah varian spesifikasi atau jumlah (`qty`), tombol **Pesan via WhatsApp** (`btn btn-success w-100`) otomatis memperbarui URL `https://wa.me/<NOMOR_WA>?text=...` dengan format:
  ```text
  Halo Java Computer Seller, saya ingin memesan:
  - Produk: <Nama Produk> (<Merek>)
  - Varian/Spesifikasi: <Label Varian>
  - Harga Promo: Rp <Harga Satuan> / unit
  - Jumlah: <Qty> unit
  - Total Estimasi: Rp <Total Harga>
  Apakah stok promo ini masih tersedia?
  ```

#### 4.5. Halaman Login & Dashboard Admin (`/admin/login` & `/admin`)
- **Halaman Login Admin (`GET /admin/login`):** Form password admin dengan proteksi CSRF (`@csrf`) dan session Laravel (`ADMIN_PASSWORD` di `.env`, dicek dengan `hash_equals`).
- **Halaman Dashboard Admin (`GET /admin`):** Satu halaman terpadu berbasis Bootstrap 5 untuk mengatur seluruh isi landing page:
  1. **Form Profil Toko & Hero Flash Deal (`POST /admin/settings`):** Mengubah nama toko, tagline, nomor WhatsApp, alamat, jam buka, serta badge, judul, subjudul, harga coret, harga promo, dan info bonus Hero Flash Deal.
  2. **Form Tambah/Edit Produk & Varian (`POST /admin/products`):** Menambah atau mengedit produk pada 5 kategori (`Laptop`, `PC`, `Printer`, `Monitor`, `Aksesoris`), merek, foto, poin spesifikasi, dan daftar varian (`Label | Harga Promo | Harga Coret`).
  3. **Tabel Daftar Produk & Hapus (`DELETE /admin/products/{id}`):** Menampilkan daftar produk aktif dengan tombol Edit dan Hapus.

---

### 5. Arsitektur Teknis (Laravel + Bootstrap 5)
Sesuai prinsip *lean engineering* (YAGNI):
- **Penyimpanan Konten Dinamis (`storage/app/catalog.json`):** Data toko, promo hero, dan katalog varian diinisialisasi otomatis dari `config/catalog.php` ke `storage/app/catalog.json`. Setiap perubahan dari halaman `/admin` disimpan ke file JSON tersebut dan langsung tampil di landing page publik (`/`). *(shortcut: single-file JSON store in storage/app/catalog.json, upgrade to MySQL/SQLite tables when concurrent multi-admin edits or >200 SKUs are needed).*
- **Struktur File Utama Laravel (Total 3 Halaman Blade):**
  - `config/catalog.php` & `storage/app/catalog.json` — Data awal & penyimpanan aktif konten landing page.
  - `app/Http/Controllers/CatalogController.php` — Menangani tampilan publik, autentikasi admin, validasi input form, serta simpan/hapus pengaturan & produk.
  - `routes/web.php` — Route publik (`GET /`) dan route admin (`GET/POST /admin/login`, `POST /admin/logout`, `GET /admin`, `POST /admin/settings`, `POST /admin/products`, `DELETE /admin/products/{id}`).
  - `resources/views/landing.blade.php` — Halaman 1: Landing page publik **Bootstrap 5.3**.
  - `resources/views/admin/login.blade.php` — Halaman 2: Login Admin.
  - `resources/views/admin/dashboard.blade.php` — Halaman 3: Dashboard Admin pengelola konten landing page.
  - `tests/Feature/LandingPageTest.php` — Pengujian otomatis PHPUnit (`php artisan test`) untuk halaman publik dan CRUD admin.

---

### 6. Kebutuhan Data dari Pemilik Toko (Checklist Sebelum Rilis)
1. **Nomor WhatsApp Admin Aktif** (format internasional tanpa `+`, contoh: `62812xxxxxxx`).
2. **Alamat Toko & Jam Operasional** untuk bagian footer.
3. **Daftar Produk & Harga Promo Asli** beserta foto produk (bisa disimpan di `public/images/products/`).

---

### 7. Kriteria Penerimaan (Acceptance Criteria)
1. `php artisan test` lulus 100% tanpa error.
2. Halaman menggunakan komponen **Bootstrap 5.3** dengan tampilan clean-minimalis dan responsif di mobile (360px+) maupun desktop (1280px+).
3. Lima kategori utama (`Laptop`, `PC`, `Printer`, `Monitor`, `Aksesoris`) tampil dan dapat difilter tanpa reload lambat.
4. Mengganti dropdown varian spesifikasi atau jumlah unit pada kartu produk langsung memperbarui harga coret, harga promo, nominal hemat, dan isi pesan pada tombol WhatsApp.
