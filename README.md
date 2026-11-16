# Java Computer Seller

Landing page katalog hardware dan promo penjualan perangkat komputer (**Laptop, PC Desktop/Rakitan, Printer, Monitor, dan Aksesoris**) berbasis **Laravel 11** dengan alur konversi pesanan instan langsung ke **WhatsApp** (*zero-friction checkout*) dan dashboard admin terpadu.

---

## 🚀 Fitur Utama

### 1. Halaman Publik (Landing Page)
- **Hero Banner & Flash Deal:** Menampilkan promo unggulan mingguan lengkap dengan harga normal (coret), harga promo, badge penghematan, dan tombol klaim instan via WhatsApp.
- **Katalog & Pemilih Varian Spesifikasi Dinamis:** 
  - Filter kategori instan (`Semua`, `Laptop`, `PC`, `Printer`, `Monitor`, `Aksesoris`).
  - Pencarian real-time berdasarkan nama produk, spesifikasi, atau merek.
  - Pemilihan varian spesifikasi (contoh: RAM/SSD atau tipe printer) dan input jumlah unit (`qty`) yang langsung menghitung harga total dan memperbarui draf chat WhatsApp secara otomatis.
- **Penanganan Status Sold Out:** Produk habis otomatis diturunkan ke urutan bawah katalog dengan badge khusus, dan tombol WhatsApp otomatis beralih menjadi format pesan "Tanya Restock".
- **Galeri Multi-Foto:** Didukung carousel Bootstrap untuk melihat detail produk dari berbagai sudut.
- **Informasi Toko Fisik & Workshop:** Jam operasional, alamat workshop, embed Google Maps responsif, tautan media sosial (Instagram, TikTok, Facebook), profil keunggulan, ulasan pelanggan, serta accordion FAQ.

### 2. Panel Admin (`/admin`)
- **Autentikasi Terproteksi:** Login admin berbasis sesi dengan proteksi CSRF, rate limiter (`throttle:10,1`), dan pencocokan kata sandi menggunakan `hash_equals`.
- **Pengaturan Profil Toko & Hero Deal:** Ubah nama toko, tagline, nomor WhatsApp admin, alamat, jam buka, sosmed, hingga detail kartu Flash Deal.
- **Pengelolaan Konten Statis:** Edit bagian profil keunggulan workshop, embed peta, dan daftar FAQ langsung dari dashboard.
- **Manajemen Produk Satuan:** Tambah dan perbarui produk dengan upload multi-foto, kompresi gambar otomatis (client-side Canvas & server-side GD untuk file > 4MB), spesifikasi, dan daftar varian harga.
- **Posting Massal (Excel / CSV):** Unduh template CSV/Excel, isi banyak produk sekaligus, dan unggah via SheetJS tanpa instalasi library backend yang berat.
- **Generator Story Card Promosi (9:16):** Tombol *Story* pada setiap produk untuk merender poster promosi beresolusi 1080 × 1920 px (pilihan foto, varian harga, diskon hemat, spesifikasi, dan info toko), unduh PNG siap upload ke status WhatsApp / Instagram Story, dukungan *Web Share API* untuk perangkat HP, serta salin caption promosi otomatis dengan tautan langsung ke produk.
- **Kontrol Cepat:** Tombol satu kali klik untuk toggle status *Sold Out* / *Ready Stock*.
- **Pembersihan File Bersih:** Gambar fisik di `public/uploads/` otomatis dihapus saat produk atau logo dihapus/diubah untuk mencegah penumpukan file *orphan*.
- **Backup Data Mandiri:** Fitur unduh snapshot katalog format `.json` sewaktu-waktu.

---

## 🛠️ Arsitektur & Teknologi

- **Backend Framework:** Laravel 11 (PHP 8.2+)
- **UI / Styling:** Bootstrap 5.3 & Tailwind CSS (Industrial Brutalist Hardware theme)
- **Tipografi:** Space Grotesk, JetBrains Mono, Work Sans, Material Symbols
- **Penyimpanan Data:** File-based JSON Store di `storage/app/catalog.json` (dengan fallback otomatis ke `config/catalog.php`) sesuai prinsip *Lean Architecture / YAGNI* tanpa dependensi database server eksternal.

---

## 📦 Prasyarat Sistem

- **PHP:** Versi 8.2 atau lebih baru (ekstensi: `fileinfo`, `gd`, `json`, `mbstring`, `openssl`)
- **Composer:** Dependency manager PHP
- **Web Server:** Apache / Nginx / PHP Built-in Server (XAMPP didukung)

---

## ⚙️ Panduan Instalasi & Menjalankan

1. **Clone repositori dan masuk ke direktori proyek:**
   ```bash
   git clone <URL_REPOSITORI>
   cd java-computer-seller
   ```

2. **Pasang dependensi Composer:**
   ```bash
   composer install
   ```

3. **Salin file konfigurasi environment:**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasikan variabel penting di file `.env`:**
   ```env
   # Nomor WhatsApp Admin (format internasional tanpa '+', contoh: 6281234567890)
   STORE_WHATSAPP=6281234567890

   # Password masuk Dashboard Admin (/admin/login)
   ADMIN_PASSWORD=javacomputer123
   ```

6. **Jalankan server pengembangan:**
   ```bash
   php artisan serve
   ```
   Buka peramban di [http://localhost:8000](http://localhost:8000).

---

## 🔐 Akses Dashboard Admin

- **URL Login:** `http://localhost:8000/admin/login`
- **Password Default:** Nilai dari `ADMIN_PASSWORD` di file `.env` (default: `javacomputer123`).

---

## 🧪 Pengujian (Testing)

Proyek ini dilengkapi dengan unit & feature tests lengkap menggunakan PHPUnit:

```bash
# Menjalankan seluruh pengujian otomatis
php artisan test
```

Cakupan pengujian meliputi:
- Render halaman publik, verifikasi komponen Bootstrap, dan seluruh kategori produk.
- Validasi varian produk dan generator link WhatsApp.
- Alur autentikasi dan otorisasi admin.
- CRUD produk satuan, upload multi-foto, dan kompresi file > 4MB.
- Impor massal template CSV/Excel.
- Toggle status Sold Out dan urutan tampil produk.
- Pembersihan file upload fisik saat data dihapus.
- Download backup data katalog JSON.

---

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT](LICENSE).
