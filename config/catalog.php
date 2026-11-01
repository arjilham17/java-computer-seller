<?php

return [
    'store_name' => 'Java Computer Seller',
    'tagline' => 'Pusat Laptop, PC Rakitan, Printer, Monitor & Aksesoris Bergaransi',
    'whatsapp_number' => env('STORE_WHATSAPP', '6281234567890'),
    'address' => 'Jl. Raya Utama, Indonesia (Siap Kirim & Ambil di Toko)',
    'hours' => 'Senin – Sabtu, 09.00 – 20.00 WIB',
    'instagram_url' => 'https://instagram.com/javacomputer',
    'tiktok_url' => 'https://tiktok.com/@javacomputer',
    'facebook_url' => 'https://facebook.com/javacomputer',

    'hero_deal' => [
        'badge' => 'FLASH DEAL • STOK TERBATAS MINGGU INI',
        'title' => 'Lenovo IdeaPad Slim 3 14" FHD',
        'subtitle' => 'Intel Core i3-1215U • RAM 8GB • SSD NVMe • Windows 11 Original',
        'original_price' => 6499000,
        'promo_price' => 5899000,
        'bonus' => 'Hemat Rp 600.000 + Gratis Tas & Instalasi Aplikasi',
    ],

    'categories' => ['Semua', 'Laptop', 'PC', 'Printer', 'Monitor', 'Aksesoris'],

    'about_title' => 'KEUNGGULAN JAVA COMPUTER',
    'about_subtitle' => 'Kami bukan sekadar penjual e-commerce biasa. Kami bengkel hardware dan pusat konsultasi komputer fisik yang beroperasi nyata setiap hari.',
    'about_features' => [
        [
            'title' => 'Garansi Resmi & Toko Tukar Baru',
            'desc' => 'Semua unit 100% original. Garansi tukar unit baru dalam 7 hari jika terdapat cacat manufaktur tanpa perdebatan.',
            'icon' => 'verified_user',
        ],
        [
            'title' => 'Packing Kayu Aman & Asuransi',
            'desc' => 'Pengiriman luar kota dibungkus berlapis bubble wrap tebal plus rangka kayu kokoh agar barang tiba mulus tanpa baret.',
            'icon' => 'inventory',
        ],
        [
            'title' => 'Gratis Software Siap Pakai',
            'desc' => 'Windows teraktivasi, Office, driver terpasang, hingga software utilitas dasar telah disiapkan secara cuma-cuma.',
            'icon' => 'terminal',
        ],
        [
            'title' => 'Support Teknisi Seumur Hidup',
            'desc' => 'Ada pertanyaan kendala software atau ingin konsultasi upgrade part di kemudian hari? Teknisi kami siap bantu via WA.',
            'icon' => 'headset_mic',
        ],
    ],

    'contact_title' => 'KUNJUNGI TOKO FISIK',
    'contact_subtitle' => 'Mau cek fisik barang sebelum beli atau konsultasi spek langsung ke teknisi kami? Silakan mampir ke workshop kami.',
    'map_image' => 'https://maps.google.com/maps?q=-7.3425692,108.1080775&hl=id&z=17&output=embed',
    'map_link' => 'https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8',

    'faqs' => [
        [
            'q' => 'Bagaimana alur pemesanan via WhatsApp?',
            'a' => 'Cukup klik tombol "Pesan via WhatsApp" pada produk dan varian yang Anda kehendaki. Anda akan diarahkan ke WhatsApp admin dengan teks pesanan yang sudah terisi otomatis (nama produk, varian, qty, dan harga). Admin akan mengonfirmasi ketersediaan stok, ongkir, serta nomor rekening resmi toko.',
        ],
        [
            'q' => 'Bagaimana jika unit ada kendala setelah diterima?',
            'a' => 'Kami memberikan garansi tukar baru 7 hari pertama untuk kerusakan manufaktur/hardware bawaan. Selanjutnya, klaim garansi resmi dapat kami bantu antar ke service center rekanan resmi (Asus, Lenovo, Epson, LG) tanpa biaya administrasi toko.',
        ],
        [
            'q' => 'Apakah bisa rakit PC dengan spesifikasi kustom sendiri?',
            'a' => 'Sangat bisa! Anda bisa menekan tombol "Tanya Admin WA" di atas lalu kirimkan daftar part yang diinginkan atau sebutkan budget total Anda. Tim teknisi kami akan meracik kombinasi part yang seimbang (tanpa bottleneck) beserta penawaran harga terbaik.',
        ],
        [
            'q' => 'Metode pembayaran apa saja yang didukung?',
            'a' => 'Kami melayani Transfer Bank (BCA, Mandiri, BNI, BRI), QRIS Instan, Pembayaran Tunai / Debit di Toko Fisik, serta opsi COD (Cash on Delivery) via kurir instant toko.',
        ],
    ],

    'products' => [
        [
            'id' => 'laptop-lenovo-ideapad',
            'name' => 'Lenovo IdeaPad Slim 3 14"',
            'brand' => 'Lenovo',
            'category' => 'Laptop',
            'badge' => 'Best Seller Kerja & Kuliah',
            'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80',
            'specs' => ['Layar 14" FHD Anti-Glare', 'Garansi Resmi 2 Tahun', 'Windows 11 + OHS Asli'],
            'variants' => [
                ['label' => 'Core i3-1215U / 8GB / 256GB SSD', 'promo_price' => 5899000, 'original_price' => 6499000],
                ['label' => 'Core i3-1215U / 8GB / 512GB SSD', 'promo_price' => 6199000, 'original_price' => 6799000],
                ['label' => 'Core i5-1235U / 16GB / 512GB SSD', 'promo_price' => 7999000, 'original_price' => 8699000],
            ],
        ],
        [
            'id' => 'laptop-asus-vivobook',
            'name' => 'ASUS VivoBook Go 14 Ryzen Series',
            'brand' => 'ASUS',
            'category' => 'Laptop',
            'badge' => 'Promo Terbatas',
            'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
            'specs' => ['Bobot Ringan 1.38 kg', 'Engsel 180° Lay-Flat', 'Baterai Tahan Seharian'],
            'variants' => [
                ['label' => 'Ryzen 3 7320U / 8GB LPDDR5 / 256GB SSD', 'promo_price' => 5650000, 'original_price' => 6199000],
                ['label' => 'Ryzen 3 7320U / 8GB LPDDR5 / 512GB SSD', 'promo_price' => 5990000, 'original_price' => 6599000],
                ['label' => 'Ryzen 5 7520U / 16GB LPDDR5 / 512GB SSD', 'promo_price' => 7450000, 'original_price' => 8199000],
            ],
        ],
        [
            'id' => 'pc-rakitan-java',
            'name' => 'PC Desktop Java Custom Series',
            'brand' => 'Java Custom PC',
            'category' => 'PC',
            'badge' => 'Siap Pakai + Rapi',
            'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80',
            'specs' => ['PSU 80+ Certified', 'Manajemen Kabel Rapi', 'Garansi Part 1–3 Tahun'],
            'variants' => [
                ['label' => 'Paket Admin/Kasir (i3-10105 / 8GB / SSD 256GB)', 'promo_price' => 3490000, 'original_price' => 3950000],
                ['label' => 'Paket Desain/Office (i5-12400 / 16GB / NVMe 512GB)', 'promo_price' => 5490000, 'original_price' => 6100000],
                ['label' => 'Paket Gaming/Render (i5-12400F / RTX 3050 / 16GB / 512GB)', 'promo_price' => 8390000, 'original_price' => 9200000],
            ],
        ],
        [
            'id' => 'printer-epson-ecotank',
            'name' => 'Epson EcoTank Ink Tank Printer',
            'brand' => 'Epson',
            'category' => 'Printer',
            'badge' => 'Hemat Tinta',
            'image' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?auto=format&fit=crop&w=800&q=80',
            'specs' => ['Termasuk 1 Set Tinta Original', 'Hasil Cetak Dokumen & Foto Tajam', 'Garansi Resmi Epson'],
            'variants' => [
                ['label' => 'EcoTank L121 (Print Only — Ekonomis)', 'promo_price' => 1750000, 'original_price' => 1950000],
                ['label' => 'EcoTank L3210 (Print, Scan, Copy — USB)', 'promo_price' => 2350000, 'original_price' => 2650000],
                ['label' => 'EcoTank L3250 (Print, Scan, Copy + WiFi Direct)', 'promo_price' => 2690000, 'original_price' => 2990000],
            ],
        ],
        [
            'id' => 'monitor-lg-ips',
            'name' => 'LG UltraFine & FHD IPS Monitor',
            'brand' => 'LG',
            'category' => 'Monitor',
            'badge' => 'Layar IPS 100Hz',
            'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
            'specs' => ['Panel IPS 99% sRGB', 'Fitur Eye Care Flicker Safe', 'Termasuk Kabel HDMI'],
            'variants' => [
                ['label' => '22" FHD 100Hz Borderless (22MR410)', 'promo_price' => 1190000, 'original_price' => 1390000],
                ['label' => '24" IPS FHD 100Hz (24MR400)', 'promo_price' => 1450000, 'original_price' => 1690000],
                ['label' => '27" IPS FHD 100Hz (27MR400)', 'promo_price' => 1890000, 'original_price' => 2190000],
            ],
        ],
        [
            'id' => 'aksesoris-logitech-kingston',
            'name' => 'Paket Aksesoris & Upgrade Komputer',
            'brand' => 'Logitech / Kingston',
            'category' => 'Aksesoris',
            'badge' => 'Promo Bundling',
            'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=800&q=80',
            'specs' => ['Produk 100% Original', 'Garansi Tukar Baru', 'Gratis Pasang di Toko'],
            'variants' => [
                ['label' => 'Combo Keyboard + Mouse Wireless Logitech MK240', 'promo_price' => 285000, 'original_price' => 349000],
                ['label' => 'SSD NVMe PCIe 4.0 Kingston NV2 500GB', 'promo_price' => 625000, 'original_price' => 720000],
                ['label' => 'RAM SODIMM DDR4 8GB 3200MHz Upgrade Laptop', 'promo_price' => 295000, 'original_price' => 360000],
            ],
        ],
    ],
];
