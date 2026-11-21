<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin: {{ $catalog['store_name'] }}</title>
    <link rel="icon" type="image/x-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.ico' }}">
    <link rel="icon" type="image/svg+xml" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.svg' }}">
    <link rel="apple-touch-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/apple-touch-icon.png' }}">
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@600;700&amp;family=Space+Grotesk:wght@600;700&amp;family=Work+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fcf9f3;
            color: #1c1c18;
            font-family: 'Work Sans', sans-serif;
        }
        h1, h2, h3, .font-headline {
            font-family: 'Space Grotesk', sans-serif;
            text-transform: uppercase;
        }
        a[href], button, input[type="submit"], input[type="reset"], input[type="checkbox"], select, label[for] {
            cursor: pointer;
        }
        .brutal-nav {
            background-color: #F3ECE1;
            border-bottom: 3px solid #111111;
            box-shadow: 0 4px 0px #111111;
        }
        .brutal-card {
            background-color: #ffffff;
            border: 2.5px solid #111111;
            box-shadow: 4px 4px 0px #111111;
            border-radius: 0;
        }
        .form-control, .form-select {
            background-color: #F3ECE1;
            border: 2px solid #111111;
            border-radius: 0;
        }
        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: #111111;
            box-shadow: 3px 3px 0px #111111;
        }
        .btn {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            border: 2px solid #111111 !important;
            box-shadow: 2px 2px 0px #111111;
            border-radius: 0;
        }
        .btn-primary {
            background-color: #d49b55;
            color: #1A1A1A;
        }
        .btn-primary:hover {
            background-color: #E5AC67;
            color: #1A1A1A;
        }
        .btn-success {
            background-color: #22C55E;
            color: #1A1A1A;
        }
        .btn-success:hover {
            background-color: #16A34A;
            color: #ffffff;
        }
        .btn-warning {
            background-color: #E5AC67;
            color: #1A1A1A;
        }
        .btn-warning:hover {
            background-color: #B87834;
            color: #ffffff;
        }
        .brutal-tabs .nav-link {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            color: #1A1A1A;
            background-color: #F3ECE1;
            border: 2px solid #111111;
            border-radius: 0;
            padding: 0.45rem 0.65rem;
            margin-right: 4px;
            margin-bottom: 4px;
        }
        .brutal-tabs .nav-link.active {
            background-color: #E5AC67;
            color: #1A1A1A;
            box-shadow: 2px 2px 0px #111111;
        }
        .pw-toggle-btn {
            background-color: #ffffff;
            color: #1A1A1A;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            border: 2px solid #111111;
            border-left: 0;
            border-radius: 0;
            padding: 0 0.65rem;
        }
        .pw-toggle-btn:hover, .pw-toggle-btn:focus-visible {
            background-color: #E5AC67;
            outline: 2px solid #111111;
        }
        .icon-picker-details {
            border: 2px solid #111111;
            background-color: #F3ECE1;
        }
        .icon-picker-details summary {
            padding: 0.45rem 0.65rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            background-color: #E5AC67;
            color: #1A1A1A;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .icon-picker-details summary::-webkit-details-marker {
            display: none;
        }
        .icon-picker-body {
            padding: 0.6rem;
            border-top: 2px solid #111111;
            max-height: 270px;
            overflow-y: auto;
            background-color: #fcf9f3;
        }
        .icon-picker-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(112px, 1fr));
            gap: 6px;
        }
        .icon-pick-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            padding: 6px 4px;
            background-color: #ffffff;
            color: #1A1A1A;
            border: 1.5px solid #111111;
            text-align: center;
            transition: background-color 0.12s ease, transform 0.1s ease;
        }
        .icon-pick-btn:hover, .icon-pick-btn:focus-visible {
            background-color: #E5AC67;
            color: #1A1A1A;
            outline: 2px solid #111111;
            transform: translateY(-1px);
        }
        .icon-pick-btn .material-symbols-outlined {
            font-size: 20px;
            line-height: 1;
        }
        .icon-pick-label {
            font-size: 0.68rem;
            font-weight: 700;
            line-height: 1.15;
        }
        .icon-pick-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.6rem;
            color: #4e4539;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar brutal-nav py-3 mb-4">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h1 class="fw-bold font-headline fs-5 mb-0">Dashboard Admin: {{ $catalog['store_name'] }}</h1>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" id="btn-open-video-framer" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#videoFrameModal" title="Tambahkan bingkai toko ke video langsung di browser tanpa membebani server">Bingkai Video</button>
                <a href="/admin/backup" class="btn btn-light btn-sm" title="Download backup data katalog JSON">Backup JSON</a>
                <a href="/" target="_blank" class="btn btn-primary btn-sm">Lihat Landing Page</a>
                <form method="POST" action="/admin/logout" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<main class="container pb-5">
    @if (session('status'))
        <div class="alert alert-success rounded-0 border-2 border-dark fw-semibold" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger rounded-0 border-2 border-dark" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $aboutFeaturesText = implode("\n", array_map(function($f) {
            $line = ($f['title'] ?? '') . ' | ' . ($f['desc'] ?? '');
            if (!empty($f['icon'])) {
                $line .= ' | ' . $f['icon'];
            }
            return $line;
        }, $catalog['about_features'] ?? []));

        $faqsText = implode("\n", array_map(function($faq) {
            return ($faq['q'] ?? '') . ' | ' . ($faq['a'] ?? '');
        }, $catalog['faqs'] ?? []));

        $trustStatsText = implode("\n", array_map(function($stat) {
            return ($stat['value'] ?? '') . ' | ' . ($stat['label'] ?? '');
        }, $catalog['trust_stats'] ?? []));

        $heroBadgesText = implode("\n", array_map(function($b) {
            $line = ($b['title'] ?? '') . ' | ' . ($b['desc'] ?? '');
            if (!empty($b['icon'])) {
                $line .= ' | ' . $b['icon'];
            }
            return $line;
        }, $catalog['hero_badges'] ?? []));

        $iconCatalog = [
            'Garansi & Keamanan' => [
                ['code' => 'verified', 'label' => 'Terverifikasi'],
                ['code' => 'verified_user', 'label' => 'Perisai Garansi'],
                ['code' => 'shield', 'label' => 'Perisai Proteksi'],
                ['code' => 'gpp_good', 'label' => 'Keamanan Resmi'],
                ['code' => 'workspace_premium', 'label' => 'Medali Kualitas'],
                ['code' => 'military_tech', 'label' => 'Bintang Juara'],
                ['code' => 'check_circle', 'label' => 'Centang Bulat'],
                ['code' => 'task_alt', 'label' => 'Lolos Uji QC'],
                ['code' => 'new_releases', 'label' => 'Segel / Baru'],
                ['code' => 'thumb_up', 'label' => 'Rekomendasi'],
            ],
            'Layanan & Teknisi' => [
                ['code' => 'support_agent', 'label' => 'Konsultasi CS'],
                ['code' => 'headset_mic', 'label' => 'Support Teknisi'],
                ['code' => 'chat', 'label' => 'Chat WhatsApp'],
                ['code' => 'forum', 'label' => 'Diskusi 1-on-1'],
                ['code' => 'build', 'label' => 'Rakit / Servis'],
                ['code' => 'handyman', 'label' => 'Peralatan'],
                ['code' => 'engineering', 'label' => 'Ahli Hardware'],
                ['code' => 'troubleshoot', 'label' => 'Cek Fisik'],
                ['code' => 'tune', 'label' => 'Custom Spek'],
                ['code' => 'terminal', 'label' => 'Gratis Software'],
            ],
            'Pengiriman & Toko' => [
                ['code' => 'local_shipping', 'label' => 'Kirim Kurir'],
                ['code' => 'inventory', 'label' => 'Packing Kayu'],
                ['code' => 'inventory_2', 'label' => 'Stok Gudang'],
                ['code' => 'package_2', 'label' => 'Paket Aman'],
                ['code' => 'storefront', 'label' => 'Toko Fisik'],
                ['code' => 'location_on', 'label' => 'Lokasi / COD'],
                ['code' => 'schedule', 'label' => 'Respon Cepat'],
                ['code' => 'bolt', 'label' => 'Proses Kilat'],
                ['code' => 'rocket_launch', 'label' => 'Siap Pakai'],
                ['code' => 'handshake', 'label' => 'Serah Terima'],
            ],
            'Hardware & Komputer' => [
                ['code' => 'laptop_mac', 'label' => 'Laptop'],
                ['code' => 'computer', 'label' => 'PC Desktop'],
                ['code' => 'desktop_windows', 'label' => 'Monitor'],
                ['code' => 'memory', 'label' => 'CPU / RAM'],
                ['code' => 'hard_drive', 'label' => 'SSD / Storage'],
                ['code' => 'print', 'label' => 'Printer'],
                ['code' => 'keyboard', 'label' => 'Keyboard'],
                ['code' => 'mouse', 'label' => 'Mouse'],
                ['code' => 'headphones', 'label' => 'Headset / Audio'],
                ['code' => 'router', 'label' => 'Jaringan / WiFi'],
                ['code' => 'videogame_asset', 'label' => 'Gaming Gear'],
                ['code' => 'battery_charging_full', 'label' => 'Baterai Awet'],
            ],
            'Harga & Promo' => [
                ['code' => 'sell', 'label' => 'Harga Terbaik'],
                ['code' => 'local_offer', 'label' => 'Diskon Promo'],
                ['code' => 'payments', 'label' => 'Transaksi Aman'],
                ['code' => 'savings', 'label' => 'Hemat Budget'],
                ['code' => 'redeem', 'label' => 'Bonus Gratis'],
                ['code' => 'local_fire_department', 'label' => 'Flash Deal'],
            ],
        ];
    @endphp

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="brutal-card p-4 mb-4">
                <h2 class="h5 fw-bold mb-3">1. Profil Toko &amp; Konten Landing</h2>
                <ul class="nav brutal-tabs mb-3" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-profil-btn" data-bs-toggle="tab" data-bs-target="#tab-profil" type="button" role="tab" aria-controls="tab-profil" aria-selected="true">Profil &amp; Sosmed</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-hero-btn" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab" aria-controls="tab-hero" aria-selected="false">Hero Promo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-konten-btn" data-bs-toggle="tab" data-bs-target="#tab-konten" type="button" role="tab" aria-controls="tab-konten" aria-selected="false">Tentang &amp; FAQ</button>
                    </li>
                </ul>

                <form method="POST" action="/admin/settings" enctype="multipart/form-data" id="settings-form">
                    @csrf
                    <div class="tab-content">
                        <!-- TAB 1: PROFIL & SOSMED -->
                        <div class="tab-pane fade show active" id="tab-profil" role="tabpanel" aria-labelledby="tab-profil-btn">
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-logo">Logo Toko (PNG/JPG/WEBP, maks 2MB)</label>
                                <div class="d-flex align-items-center gap-2">
                                    @if (!empty($catalog['logo']))
                                        <img src="{{ $catalog['logo'] }}" alt="Logo saat ini" width="40" height="40" style="height: 40px; width: auto;" class="border border-2 border-dark p-1 bg-white">
                                    @else
                                        <span class="badge p-2 border border-2 border-dark rounded-0" style="background:#B87834;color:#fff;">JC</span>
                                    @endif
                                    <input type="file" name="logo" id="f-logo" class="form-control form-control-sm" accept="image/png,image/jpeg,image/webp">
                                </div>
                                @if (!empty($catalog['logo']))
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="remove_logo" value="1" id="f-remove-logo">
                                        <label class="form-check-label small" for="f-remove-logo">Hapus logo (kembali ke badge JC)</label>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-store-name">Nama Toko</label>
                                <input type="text" name="store_name" id="f-store-name" class="form-control form-control-sm" value="{{ old('store_name', $catalog['store_name']) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-tagline">Tagline</label>
                                <input type="text" name="tagline" id="f-tagline" class="form-control form-control-sm" value="{{ old('tagline', $catalog['tagline']) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-wa-number">Nomor WhatsApp (Format 628...)</label>
                                <input type="text" name="whatsapp_number" id="f-wa-number" class="form-control form-control-sm" value="{{ old('whatsapp_number', $catalog['whatsapp_number']) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-address">Alamat Toko</label>
                                <input type="text" name="address" id="f-address" class="form-control form-control-sm" value="{{ old('address', $catalog['address']) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold" for="f-hours">Jam Operasional</label>
                                <input type="text" name="hours" id="f-hours" class="form-control form-control-sm" value="{{ old('hours', $catalog['hours']) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-ig-url">Instagram URL</label>
                                <input type="url" name="instagram_url" id="f-ig-url" class="form-control form-control-sm" placeholder="https://instagram.com/namatoko" value="{{ old('instagram_url', $catalog['instagram_url'] ?? '') }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-tiktok-url">TikTok URL</label>
                                <input type="url" name="tiktok_url" id="f-tiktok-url" class="form-control form-control-sm" placeholder="https://tiktok.com/@namatoko" value="{{ old('tiktok_url', $catalog['tiktok_url'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold" for="f-fb-url">Facebook URL</label>
                                <input type="url" name="facebook_url" id="f-fb-url" class="form-control form-control-sm" placeholder="https://facebook.com/namatoko" value="{{ old('facebook_url', $catalog['facebook_url'] ?? '') }}">
                            </div>
                        </div>

                        <!-- TAB 2: HERO PROMO -->
                        <div class="tab-pane fade" id="tab-hero" role="tabpanel" aria-labelledby="tab-hero-btn">
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-hero-badge">Badge Promo</label>
                                <input type="text" name="hero_badge" id="f-hero-badge" class="form-control form-control-sm" value="{{ old('hero_badge', $catalog['hero_deal']['badge']) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-hero-title">Judul Produk Hero</label>
                                <input type="text" name="hero_title" id="f-hero-title" class="form-control form-control-sm" value="{{ old('hero_title', $catalog['hero_deal']['title']) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-hero-subtitle">Subjudul Spesifikasi</label>
                                <input type="text" name="hero_subtitle" id="f-hero-subtitle" class="form-control form-control-sm" value="{{ old('hero_subtitle', $catalog['hero_deal']['subtitle']) }}" required>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small fw-semibold" for="f-hero-orig">Harga Coret (Rp)</label>
                                    <input type="number" name="hero_original_price" id="f-hero-orig" class="form-control form-control-sm" value="{{ old('hero_original_price', $catalog['hero_deal']['original_price']) }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-semibold" for="f-hero-promo">Harga Promo (Rp)</label>
                                    <input type="number" name="hero_promo_price" id="f-hero-promo" class="form-control form-control-sm" value="{{ old('hero_promo_price', $catalog['hero_deal']['promo_price']) }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold" for="f-hero-bonus">Info Bonus / Hemat</label>
                                <input type="text" name="hero_bonus" id="f-hero-bonus" class="form-control form-control-sm" value="{{ old('hero_bonus', $catalog['hero_deal']['bonus']) }}" required>
                            </div>

                            <hr class="border-2 border-dark opacity-100">
                            <h3 class="h6 fw-bold mb-2">3 Kotak Poin Hero (Bawah Tagline)</h3>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-hero-badges">Isi Kotak Hero (1 baris per kotak: <code>Judul | Deskripsi | Icon</code>)</label>
                                <textarea name="hero_badges_text" id="f-hero-badges" rows="3" class="form-control form-control-sm font-monospace small" placeholder="Garansi Jelas | Garansi resmi distributor dan tukar baru toko 7 hari. | verified">{{ old('hero_badges_text', $heroBadgesText) }}</textarea>
                                <div class="form-text small">Taruh kursor pada baris yang ingin diubah, lalu klik salah satu ikon di bawah untuk mengganti ikon baris tersebut.</div>
                            </div>
                            <details class="icon-picker-details mb-3" data-picker-for="f-hero-badges">
                                <summary>
                                    <span>Pilih Icon Kotak Hero (48 Pilihan Icon)</span>
                                    <span class="small font-monospace">▼ Klik Buka/Tutup</span>
                                </summary>
                                <div class="icon-picker-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                        <div class="d-flex align-items-center gap-1">
                                            <label class="small fw-bold mb-0" for="line-select-hero">Terapkan ke:</label>
                                            <select id="line-select-hero" class="form-select form-select-sm py-0 px-2 icon-line-select" data-target="f-hero-badges" style="width: auto; font-size: 0.75rem;">
                                                <option value="cursor">Baris Kursor Aktif</option>
                                                <option value="0">Kotak 1 (Baris 1)</option>
                                                <option value="1">Kotak 2 (Baris 2)</option>
                                                <option value="2">Kotak 3 (Baris 3)</option>
                                            </select>
                                        </div>
                                        <input type="search" class="form-control form-control-sm py-0 px-2 icon-search-input" placeholder="Cari icon (mis: garansi, kirim, laptop)..." style="max-width: 210px; font-size: 0.75rem;">
                                    </div>
                                    <div class="icon-feedback small fw-bold text-success mb-2 d-none" role="status"></div>
                                    @foreach ($iconCatalog as $groupName => $groupIcons)
                                        <div class="icon-group mb-2">
                                            <div class="small fw-bold text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em; color: #663e00;">{{ $groupName }}</div>
                                            <div class="icon-picker-grid">
                                                @foreach ($groupIcons as $ic)
                                                    <button type="button" class="icon-pick-btn" data-target="f-hero-badges" data-icon="{{ $ic['code'] }}" data-search="{{ strtolower($ic['label'] . ' ' . $ic['code'] . ' ' . $groupName) }}">
                                                        <span class="material-symbols-outlined" aria-hidden="true">{{ $ic['code'] }}</span>
                                                        <span class="icon-pick-label">{{ $ic['label'] }}</span>
                                                        <span class="icon-pick-code">{{ $ic['code'] }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </details>
                        </div>

                        <!-- TAB 3: TENTANG & FAQ -->
                        <div class="tab-pane fade" id="tab-konten" role="tabpanel" aria-labelledby="tab-konten-btn">
                            <h3 class="h6 fw-bold mb-2">Strip Info / Highlight Hero</h3>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold" for="f-trust-stats">Kolom Info Highlight (1 baris: <code>Angka/Judul | Keterangan</code>)</label>
                                <textarea name="trust_stats_text" id="f-trust-stats" rows="4" class="form-control form-control-sm font-monospace small" placeholder="7 Hari | Garansi Tukar Baru">{{ old('trust_stats_text', $trustStatsText) }}</textarea>
                                <div class="form-text small">Opsional variabel otomatis: <code>{ready_count}</code>, <code>{category_count}</code>, <code>{total_count}</code>. Kosongkan untuk menyembunyikan strip ini.</div>
                            </div>

                            <hr class="border-2 border-dark opacity-100">
                            <h3 class="h6 fw-bold mb-2">Konten #tentang-kami</h3>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-about-title">Judul Section Keunggulan</label>
                                <input type="text" name="about_title" id="f-about-title" class="form-control form-control-sm" value="{{ old('about_title', $catalog['about_title'] ?? '') }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-about-subtitle">Deskripsi Section</label>
                                <textarea name="about_subtitle" id="f-about-subtitle" rows="2" class="form-control form-control-sm">{{ old('about_subtitle', $catalog['about_subtitle'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-about-features">Poin Keunggulan (1 baris per item: <code>Judul | Deskripsi | Icon</code>)</label>
                                <textarea name="about_features_text" id="f-about-features" rows="4" class="form-control form-control-sm font-monospace small">{{ old('about_features_text', $aboutFeaturesText) }}</textarea>
                            </div>
                            <details class="icon-picker-details mb-3" data-picker-for="f-about-features">
                                <summary>
                                    <span>Pilih Icon Keunggulan Toko (48 Pilihan Icon)</span>
                                    <span class="small font-monospace">▼ Klik Buka/Tutup</span>
                                </summary>
                                <div class="icon-picker-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                        <div class="d-flex align-items-center gap-1">
                                            <label class="small fw-bold mb-0" for="line-select-about">Terapkan ke:</label>
                                            <select id="line-select-about" class="form-select form-select-sm py-0 px-2 icon-line-select" data-target="f-about-features" style="width: auto; font-size: 0.75rem;">
                                                <option value="cursor">Baris Kursor Aktif</option>
                                                <option value="0">Kartu 1 (Baris 1)</option>
                                                <option value="1">Kartu 2 (Baris 2)</option>
                                                <option value="2">Kartu 3 (Baris 3)</option>
                                                <option value="3">Kartu 4 (Baris 4)</option>
                                            </select>
                                        </div>
                                        <input type="search" class="form-control form-control-sm py-0 px-2 icon-search-input" placeholder="Cari icon (mis: garansi, kirim, laptop)..." style="max-width: 210px; font-size: 0.75rem;">
                                    </div>
                                    <div class="icon-feedback small fw-bold text-success mb-2 d-none" role="status"></div>
                                    @foreach ($iconCatalog as $groupName => $groupIcons)
                                        <div class="icon-group mb-2">
                                            <div class="small fw-bold text-uppercase mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em; color: #663e00;">{{ $groupName }}</div>
                                            <div class="icon-picker-grid">
                                                @foreach ($groupIcons as $ic)
                                                    <button type="button" class="icon-pick-btn" data-target="f-about-features" data-icon="{{ $ic['code'] }}" data-search="{{ strtolower($ic['label'] . ' ' . $ic['code'] . ' ' . $groupName) }}">
                                                        <span class="material-symbols-outlined" aria-hidden="true">{{ $ic['code'] }}</span>
                                                        <span class="icon-pick-label">{{ $ic['label'] }}</span>
                                                        <span class="icon-pick-code">{{ $ic['code'] }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </details>

                            <hr class="border-2 border-dark opacity-100">
                            <h3 class="h6 fw-bold mb-2">Konten #kontak &amp; FAQ</h3>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-contact-title">Judul Section Kontak</label>
                                <input type="text" name="contact_title" id="f-contact-title" class="form-control form-control-sm" value="{{ old('contact_title', $catalog['contact_title'] ?? '') }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-contact-subtitle">Deskripsi Section Kontak</label>
                                <textarea name="contact_subtitle" id="f-contact-subtitle" rows="2" class="form-control form-control-sm">{{ old('contact_subtitle', $catalog['contact_subtitle'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-map-image">URL Peta / Embed Google Maps</label>
                                <input type="text" name="map_image" id="f-map-image" class="form-control form-control-sm" value="{{ old('map_image', $catalog['map_image'] ?? '') }}" placeholder="https://maps.google.com/maps?... atau URL gambar">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold" for="f-map-link">Link Tautan Google Maps</label>
                                <input type="text" name="map_link" id="f-map-link" class="form-control form-control-sm" value="{{ old('map_link', $catalog['map_link'] ?? 'https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8') }}" placeholder="https://maps.app.goo.gl/...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold" for="f-faq-text">Daftar FAQ (1 baris per pertanyaan: <code>Pertanyaan | Jawaban</code>)</label>
                                <textarea name="faq_text" id="f-faq-text" rows="3" class="form-control form-control-sm font-monospace small">{{ old('faq_text', $faqsText) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-1">Simpan Pengaturan &amp; Konten</button>
                </form>
            </div>

            <div class="brutal-card p-4 mb-4">
                <div class="d-inline-block px-2 py-0.5 mb-2 fw-bold font-monospace small border border-dark" style="background:#E5AC67;">KEAMANAN AKUN</div>
                <h2 class="h5 fw-bold mb-3">Ganti Password Admin</h2>
                <form method="POST" action="/admin/password">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-current-password">Password Saat Ini</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="current_password" id="f-current-password" class="form-control form-control-sm" autocomplete="current-password" required>
                            <button type="button" class="pw-toggle-btn" data-target="f-current-password" aria-label="Tampilkan password saat ini" aria-pressed="false">Lihat</button>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-new-password">Password Baru (Minimal 8 Karakter)</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="new_password" id="f-new-password" class="form-control form-control-sm" minlength="8" autocomplete="new-password" required>
                            <button type="button" class="pw-toggle-btn" data-target="f-new-password" aria-label="Tampilkan password baru" aria-pressed="false">Lihat</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="f-new-password-confirm">Konfirmasi Password Baru</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="new_password_confirmation" id="f-new-password-confirm" class="form-control form-control-sm" minlength="8" autocomplete="new-password" required>
                            <button type="button" class="pw-toggle-btn" data-target="f-new-password-confirm" aria-label="Tampilkan konfirmasi password baru" aria-pressed="false">Lihat</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Perbarui Password Admin</button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="brutal-card p-4 mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                    <h2 class="h5 fw-bold mb-0">2. Posting Massal (Template Excel)</h2>
                    <div class="d-flex flex-wrap gap-1">
                        <button type="button" id="btn-download-xlsx" class="btn btn-warning btn-sm">
                            Download Template (.xlsx)
                        </button>
                        <a href="/admin/products/template" class="btn btn-light btn-sm">
                            Template (.csv)
                        </a>
                    </div>
                </div>
                <p class="text-secondary small mb-2">
                    Cukup isi 6 kolom mudah: <code>name</code>, <code>brand</code>, <code>category</code>, <code>badge</code>, <code>specs_text</code>, dan <code>variants_text</code>. <strong>Tanpa perlu isi ID dan tanpa foto terlebih dahulu!</strong> Setelah selesai import, Anda bisa upload foto produk menyusul lewat tombol <strong>Edit / +Foto</strong> pada tabel di bawah.
                </p>
                <form method="POST" action="/admin/products/import" enctype="multipart/form-data" id="bulk-form">
                    @csrf
                    <input type="hidden" name="csv_payload" id="csv-payload">
                    <label for="bulk-file" class="visually-hidden">Pilih file template Excel atau CSV</label>
                    <div class="input-group input-group-sm">
                        <input type="file" name="file" id="bulk-file" class="form-control" accept=".csv,.xlsx,.xls" required>
                        <button type="submit" class="btn btn-primary px-3">Import Produk Massal</button>
                    </div>
                </form>
            </div>

            <div class="brutal-card p-4 mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h2 class="h5 fw-bold mb-0" id="product-form-heading">3. Tambah / Edit Produk Satuan</h2>
                    <span class="badge border border-dark rounded-0 font-monospace text-dark" id="product-form-mode-badge" style="background:#F3ECE1;">MODE TAMBAH BARU</span>
                </div>

                <div id="edit-mode-banner" class="alert alert-warning rounded-0 border-2 border-dark py-2 px-3 mb-3 d-none d-flex flex-wrap justify-content-between align-items-center gap-2" role="status">
                    <div class="small fw-bold">
                        Sedang mengedit produk: <span id="edit-mode-product-name" class="text-decoration-underline"></span>
                    </div>
                    <button type="button" id="btn-cancel-edit" class="btn btn-light btn-sm py-0 px-2">Batal Edit</button>
                </div>

                <form method="POST" action="/admin/products" enctype="multipart/form-data" id="product-form">
                    @csrf
                    <input type="hidden" name="original_id" id="f-original-id" value="{{ old('original_id') }}">
                    <input type="hidden" name="image" id="f-image" value="{{ old('image') }}">
                    <div class="row g-2 mb-2">
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold" for="f-name">Nama Produk</label>
                            <input type="text" name="name" id="f-name" class="form-control form-control-sm" placeholder="Contoh: Lenovo IdeaPad Slim 3 14" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold" for="f-brand">Merek</label>
                            <input type="text" name="brand" id="f-brand" class="form-control form-control-sm" placeholder="Lenovo / ASUS / Epson" value="{{ old('brand') }}" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold" for="f-id">ID / Slug Produk (Otomatis)</label>
                            <input type="text" name="id" id="f-id" class="form-control form-control-sm font-monospace" placeholder="laptop-lenovo-ideapad" value="{{ old('id') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold" for="f-category">Kategori</label>
                            <select name="category" id="f-category" class="form-select form-select-sm" required>
                                @foreach (['Laptop', 'PC', 'Printer', 'Monitor', 'Aksesoris'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold" for="f-badge">Badge Kartu</label>
                            <input type="text" name="badge" id="f-badge" class="form-control form-control-sm" placeholder="Best Seller / Promo" value="{{ old('badge') }}" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-photos">Upload Foto Produk (Bisa pilih lebih dari 1 foto)</label>
                        <input type="file" name="photos[]" id="f-photos" class="form-control form-control-sm" accept="image/*" multiple>
                        <div class="form-text text-muted text-[11px] mt-1">Foto &gt; 4096 KB (4 MB) otomatis dikompres sebelum upload agar hemat bandwidth dan lancar.</div>
                        <div id="photo-preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-specs">Poin Spesifikasi (1 baris = 1 badge spesifikasi)</label>
                        <textarea name="specs_text" id="f-specs" rows="2" class="form-control form-control-sm" placeholder="Garansi Resmi 2 Tahun&#10;Layar FHD IPS" required>{{ old('specs_text') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="f-variants">Daftar Varian (Format per baris: <code>Label Varian | Harga Promo | Harga Coret</code>)</label>
                        <textarea name="variants_text" id="f-variants" rows="3" class="form-control form-control-sm font-monospace" placeholder="RAM 8GB / SSD 256GB | 5899000 | 6499000&#10;RAM 16GB / SSD 512GB | 6899000 | 7499000" required>{{ old('variants_text') }}</textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_sold_out" value="1" id="f-sold-out" {{ old('is_sold_out') ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold" for="f-sold-out">Tandai Sold Out (Stok Habis)</label>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" id="btn-save-product" class="btn btn-success btn-sm px-4 py-2">Simpan Produk</button>
                        <button type="button" id="btn-reset-product" class="btn btn-light btn-sm px-3 py-2">Reset Form</button>
                    </div>
                </form>
            </div>

            <div class="brutal-card p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h2 class="h5 fw-bold mb-0">4. Daftar Produk Aktif (<span id="admin-product-count">{{ count($catalog['products']) }}</span>)</h2>
                </div>

                <!-- Filter & Search Bar Tabel Admin -->
                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label for="admin-table-search" class="visually-hidden">Cari produk di tabel</label>
                        <input type="search" id="admin-table-search" class="form-control form-control-sm" placeholder="Cari nama, merek, atau ID produk...">
                    </div>
                    <div class="col-6 col-sm-3">
                        <label for="admin-table-cat" class="visually-hidden">Filter kategori produk</label>
                        <select id="admin-table-cat" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach (['Laptop', 'PC', 'Printer', 'Monitor', 'Aksesoris'] as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label for="admin-table-status" class="visually-hidden">Filter status stok</label>
                        <select id="admin-table-status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="ready">Ready Stock</option>
                            <option value="sold">Sold Out</option>
                            <option value="nophoto">Belum Ada Foto</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Varian &amp; Harga</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="admin-product-tbody">
                            @foreach ($catalog['products'] as $p)
                                @php
                                    $vLines = implode("\n", array_map(fn($v) => "{$v['label']} | {$v['promo_price']} | {$v['original_price']}", $p['variants']));
                                    $sLines = implode("\n", $p['specs']);
                                    $pImages = array_values(array_filter($p['images'] ?? [$p['image'] ?? '']));
                                    $imgList = implode('; ', $pImages);
                                    $thumbUrl = $pImages[0] ?? '';
                                    $hasPhoto = count($pImages) > 0;
                                    $minPrice = collect($p['variants'])->min('promo_price') ?? 0;
                                    $isSold = !empty($p['is_sold_out']);
                                @endphp
                                <tr class="admin-product-row"
                                    data-category="{{ $p['category'] }}"
                                    data-status="{{ $isSold ? 'sold' : 'ready' }}"
                                    data-has-photo="{{ $hasPhoto ? '1' : '0' }}"
                                    data-search="{{ strtolower($p['name'] . ' ' . $p['brand'] . ' ' . $p['id'] . ' ' . $p['category']) }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($thumbUrl)
                                                <img src="{{ $thumbUrl }}" alt="{{ $p['name'] }}" width="44" height="44" loading="lazy" style="width:44px;height:44px;object-fit:cover;flex-shrink:0;" class="border border-2 border-dark bg-light">
                                            @else
                                                <div style="width:44px;height:44px;flex-shrink:0;background:#F3ECE1;font-size:9px;line-height:1.1;" class="border border-2 border-dark d-flex align-items-center justify-content-center text-center fw-bold font-monospace text-secondary">
                                                    NO<br>FOTO
                                                </div>
                                            @endif
                                            <div>
                                                <div class="d-flex flex-wrap align-items-center gap-1">
                                                    <span class="fw-semibold">{{ $p['name'] }}</span>
                                                    @if ($isSold)
                                                        <span class="badge bg-danger rounded-0">SOLD OUT</span>
                                                    @endif
                                                    @if (!$hasPhoto)
                                                        <span class="badge text-dark border border-dark rounded-0" style="background:#FDE047;">BELUM ADA FOTO</span>
                                                    @endif
                                                </div>
                                                <small class="text-secondary">{{ $p['brand'] }} • <code>{{ $p['id'] }}</code> ({{ count($pImages) }} foto)</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge text-bg-light border border-dark rounded-0">{{ $p['category'] }}</span></td>
                                    <td>
                                        <div class="small fw-semibold">Mulai Rp {{ number_format($minPrice, 0, ',', '.') }}</div>
                                        <small class="text-secondary">{{ count($p['variants']) }} varian</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex flex-wrap justify-content-end gap-1">
                                            <button type="button" class="btn btn-warning btn-sm story-btn"
                                                    data-id="{{ $p['id'] }}"
                                                    data-name="{{ $p['name'] }}"
                                                    data-brand="{{ $p['brand'] }}"
                                                    data-category="{{ $p['category'] }}"
                                                    data-badge="{{ $p['badge'] }}"
                                                    data-image="{{ $imgList }}"
                                                    data-specs="{{ $sLines }}"
                                                    data-variants="{{ $vLines }}"
                                                    data-sold-out="{{ $isSold ? '1' : '0' }}"
                                                    title="Generate Card Promosi Story (9:16)">
                                                Story
                                            </button>
                                            <form method="POST" action="/admin/products/{{ $p['id'] }}/toggle-sold" class="m-0 d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $isSold ? 'btn-success' : 'btn-dark' }}" title="{{ $isSold ? 'Tandai Ready Stock' : 'Tandai Sold Out' }}">
                                                    {{ $isSold ? 'Set Ready' : 'Sold Out' }}
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary btn-sm edit-btn"
                                                    data-id="{{ $p['id'] }}"
                                                    data-name="{{ $p['name'] }}"
                                                    data-brand="{{ $p['brand'] }}"
                                                    data-category="{{ $p['category'] }}"
                                                    data-badge="{{ $p['badge'] }}"
                                                    data-image="{{ $imgList }}"
                                                    data-specs="{{ $sLines }}"
                                                    data-variants="{{ $vLines }}"
                                                    data-sold-out="{{ $isSold ? '1' : '0' }}">
                                                {{ $hasPhoto ? 'Edit' : 'Edit / +Foto' }}
                                            </button>
                                            <form method="POST" action="/admin/products/{{ $p['id'] }}" class="m-0 d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="admin-table-empty" class="text-center py-4 px-3 border border-2 border-dark mt-2 {{ count($catalog['products']) > 0 ? 'd-none' : '' }}" style="background-color: #F3ECE1;">
                    <div class="fw-bold small text-uppercase font-headline mb-1">Tidak Ada Produk yang Cocok</div>
                    <p class="small text-secondary mb-0">Coba ubah kata kunci pencarian atau pilih filter kategori/status lain.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Story Card Generator (9:16) -->
<div class="modal fade" id="storyModal" tabindex="-1" aria-labelledby="storyModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content brutal-card p-0 overflow-hidden">
            <div class="modal-header border-bottom border-2 border-dark px-4 py-3" style="background-color: #F3ECE1;">
                <div>
                    <span class="badge border border-dark rounded-0 px-2 py-1 mb-1 font-monospace" style="background: #E5AC67; color: #111111;">STORY CARD 9:16</span>
                    <h2 class="modal-title h5 fw-bold mb-0" id="storyModalLabel">Generator Story Card Produk</h2>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup dialog"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #FCF9F3;">
                <div class="row g-4 align-items-start">
                    <!-- Preview Canvas Column -->
                    <div class="col-lg-5 text-center">
                        <div class="p-3 bg-white border border-2 border-dark shadow-sm text-center">
                            <canvas id="story-canvas" width="1080" height="1920" style="width: 100%; max-width: 320px; height: auto; border: 2.5px solid #111111; box-shadow: 4px 4px 0px #111111; display: block; margin: 0 auto; aspect-ratio: 9/16;" aria-label="Pratinjau kartu story produk"></canvas>
                            <div id="story-loading" class="small text-secondary mt-2 d-none">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Memproses gambar kartu...
                            </div>
                            <div id="story-cors-notice" class="alert alert-warning py-1 px-2 small mt-2 d-none rounded-0 border border-dark text-start">
                                Foto produk eksternal dibatasi CORS oleh penyedia aslinya. Kartu tetap dirender rapi dengan ilustrasi fallback agar dapat diunduh tanpa kendala.
                            </div>
                        </div>
                    </div>
                    <!-- Controls & Caption Column -->
                    <div class="col-lg-7">
                        <div class="brutal-card p-3 mb-3 bg-white">
                            <h3 class="h6 fw-bold mb-3">Pengaturan Kartu</h3>
                            <div class="mb-3">
                                <label for="story-theme-select" class="form-label small fw-semibold">Pilih Tema Hari Besar / Promo:</label>
                                <select id="story-theme-select" class="form-select form-select-sm">
                                    <option value="default">Klasik Hardware (Default Toko)</option>
                                    <option value="ramadhan">Bulan Ramadhan (Berkah Ramadhan)</option>
                                    <option value="idul_fitri">Hari Raya Idul Fitri (Spesial Lebaran)</option>
                                    <option value="tahun_baru">Tahun Baru (Upgrade Setup Baru)</option>
                                    <option value="kemerdekaan">Hari Kemerdekaan Indonesia (Promo Merdeka 17-08)</option>
                                    <option value="back_to_school">Tahun Ajaran Baru (Promo Pelajar &amp; Mahasiswa)</option>
                                    <option value="pemilu">Promo Pemilu (Pesta Demokrasi)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="story-variant-select" class="form-label small fw-semibold">Pilih Varian Spesifikasi &amp; Harga:</label>
                                <select id="story-variant-select" class="form-select form-select-sm"></select>
                            </div>
                            <div class="mb-3">
                                <label for="story-photo-select" class="form-label small fw-semibold">Pilih Foto Produk:</label>
                                <select id="story-photo-select" class="form-select form-select-sm"></select>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="story-include-specs" checked>
                                <label class="form-check-label small fw-semibold" for="story-include-specs">Tampilkan poin spesifikasi pada kartu</label>
                            </div>
                        </div>

                        <div class="brutal-card p-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="story-caption-text" class="form-label small fw-semibold mb-0">Caption Siap Posting (WA Status / Instagram Story):</label>
                                <span class="badge border border-dark rounded-0 font-monospace text-dark" style="background:#F3ECE1;">Format Teks</span>
                            </div>
                            <textarea id="story-caption-text" class="form-control form-control-sm font-monospace mb-3" rows="6" readonly></textarea>
                            
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" id="btn-download-story" class="btn btn-primary btn-sm flex-grow-1 py-2">
                                    Unduh Gambar Story (.PNG)
                                </button>
                                <button type="button" id="btn-share-story" class="btn btn-success btn-sm py-2 d-none">
                                    Bagikan ke Aplikasi
                                </button>
                                <button type="button" id="btn-copy-caption" class="btn btn-light btn-sm py-2 px-3">
                                    Salin Caption WA/IG
                                </button>
                            </div>
                            <div id="story-copy-feedback" class="small text-success fw-bold mt-2 d-none" role="status">
                                Caption berhasil disalin ke clipboard!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.partials.video-framer-modal')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
document.getElementById('btn-download-xlsx')?.addEventListener('click', () => {
    const rows = [
        ['name', 'brand', 'category', 'badge', 'specs_text', 'variants_text'],
        [
            'Acer Aspire 5 Slim 14"',
            'Acer',
            'Laptop',
            'Promo Kuliah',
            'Layar 14" IPS FHD; Garansi Resmi 2 Tahun; Windows 11 Original',
            'Core i3 / 8GB / 512GB SSD | 5799000 | 6399000; Core i5 / 16GB / 512GB SSD | 7699000 | 8299000',
        ],
        [
            'Canon PIXMA G2020 Ink Tank',
            'Canon',
            'Printer',
            'Siap Cetak',
            'Print Scan Copy; Tinta Botol Hemat; Garansi Resmi',
            'Paket Standar + Tinta Original | 2150000 | 2450000',
        ],
    ];
    if (window.XLSX) {
        const ws = XLSX.utils.aoa_to_sheet(rows);
        ws['!cols'] = [{ wch: 28 }, { wch: 14 }, { wch: 12 }, { wch: 16 }, { wch: 48 }, { wch: 62 }];
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Template Produk');
        XLSX.writeFile(wb, 'template-produk-java-computer.xlsx');
    } else {
        window.location.href = '/admin/products/template';
    }
});

document.getElementById('bulk-file')?.addEventListener('change', async (e) => {
    const file = e.target.files?.[0];
    const payload = document.getElementById('csv-payload');
    payload.value = '';
    if (file && /\.(xlsx|xls)$/i.test(file.name) && window.XLSX) {
        const wb = XLSX.read(await file.arrayBuffer(), { type: 'array' });
        payload.value = XLSX.utils.sheet_to_csv(wb.Sheets[wb.SheetNames[0]]);
    }
});

// shortcut: browser canvas compression skips animated GIF/RAW formats, upgrade to server worker if non-standard formats needed
async function compressImageIfNeeded(file, maxBytes = 4096 * 1024) {
    if (file.size <= maxBytes || !file.type.startsWith('image/')) {
        return file;
    }
    return new Promise((resolve) => {
        const img = new Image();
        const url = URL.createObjectURL(file);
        img.onload = () => {
            URL.revokeObjectURL(url);
            let { width, height } = img;
            const maxDim = 1920;
            if (width > maxDim || height > maxDim) {
                const ratio = Math.min(maxDim / width, maxDim / height);
                width = Math.round(width * ratio);
                height = Math.round(height * ratio);
            }
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').drawImage(img, 0, 0, width, height);
            canvas.toBlob((blob) => {
                if (!blob) return resolve(file);
                const newName = file.name.replace(/\.[^.]+$/, '.jpg');
                resolve(new File([blob], newName, { type: 'image/jpeg', lastModified: Date.now() }));
            }, 'image/jpeg', 0.82);
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            resolve(file);
        };
        img.src = url;
    });
}

const photoInput = document.getElementById('f-photos');
const saveBtn = document.getElementById('btn-save-product');

photoInput?.addEventListener('change', async (e) => {
    const preview = document.getElementById('photo-preview');
    const rawFiles = Array.from(e.target.files || []);
    if (!rawFiles.length) {
        preview.innerHTML = '';
        return;
    }

    const hasLarge = rawFiles.some(f => f.size > 4096 * 1024);
    if (hasLarge && saveBtn) {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Mengompres Foto (>4MB)...';
    }

    preview.innerHTML = '<span class="text-muted small">Memeriksa ukuran foto...</span>';

    try {
        const dt = new DataTransfer();
        const items = [];
        for (const file of rawFiles) {
            const orig = file.size;
            const processed = await compressImageIfNeeded(file);
            dt.items.add(processed);
            items.push({ file: processed, wasCompressed: orig > 4096 * 1024, origMb: (orig / (1024 * 1024)).toFixed(1) });
        }
        photoInput.files = dt.files;

        preview.innerHTML = '';
        items.forEach(({ file, wasCompressed, origMb }) => {
            const wrap = document.createElement('div');
            wrap.className = 'border p-1 bg-white text-center';
            wrap.style.width = '70px';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.cssText = 'width:60px;height:60px;object-fit:cover;display:block;margin:0 auto;';

            const cap = document.createElement('div');
            cap.className = 'font-monospace text-[10px] text-muted mt-1';
            const curMb = (file.size / (1024 * 1024)).toFixed(1) + 'M';
            cap.textContent = wasCompressed ? `${origMb}M->${curMb}` : curMb;
            if (wasCompressed) cap.className += ' text-success fw-bold';

            wrap.appendChild(img);
            wrap.appendChild(cap);
            preview.appendChild(wrap);
        });
    } catch (err) {
        console.error(err);
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.textContent = document.getElementById('f-original-id')?.value ? 'Perbarui Produk' : 'Simpan Produk';
        }
    }
});

// Toggle Lihat / Tutup Password
document.querySelectorAll('.pw-toggle-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        if (!input) return;
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.textContent = isHidden ? 'Tutup' : 'Lihat';
        btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
    });
});

// Buka tab secara otomatis jika ada input invalid di tab tersembunyi
document.querySelectorAll('#settings-form input, #settings-form textarea').forEach((field) => {
    field.addEventListener('invalid', () => {
        const pane = field.closest('.tab-pane');
        if (pane && !pane.classList.contains('active')) {
            const tabBtn = document.querySelector(`[data-bs-target="#${pane.id}"]`);
            if (tabBtn && window.bootstrap) {
                bootstrap.Tab.getOrCreateInstance(tabBtn).show();
            }
        }
    });
});

// Auto-Slug Produk & Manajemen Mode Edit / Tambah Baru
const fOriginalId = document.getElementById('f-original-id');
const fId = document.getElementById('f-id');
const fName = document.getElementById('f-name');
const fCategory = document.getElementById('f-category');
const editModeBanner = document.getElementById('edit-mode-banner');
const editModeProductName = document.getElementById('edit-mode-product-name');
const productFormModeBadge = document.getElementById('product-form-mode-badge');
const photoPreview = document.getElementById('photo-preview');
let isSlugManuallyEdited = false;

function toSlug(str) {
    return String(str || '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '')
        .substring(0, 80);
}

function updateAutoSlug() {
    if (fOriginalId?.value || isSlugManuallyEdited) return;
    const catPrefix = toSlug(fCategory?.value || '');
    const nameSlug = toSlug(fName?.value || '');
    if (!nameSlug) {
        fId.value = '';
        return;
    }
    fId.value = nameSlug.startsWith(catPrefix) ? nameSlug : toSlug(`${catPrefix}-${nameSlug}`);
}

fName?.addEventListener('input', updateAutoSlug);
fCategory?.addEventListener('change', updateAutoSlug);
fId?.addEventListener('input', () => {
    isSlugManuallyEdited = fId.value.trim() !== '';
    fId.value = toSlug(fId.value);
});

function renderExistingPhotoThumbnails(rawImageStr) {
    if (!photoPreview) return;
    photoPreview.innerHTML = '';
    const urls = String(rawImageStr || '').split(';').map(s => s.trim()).filter(Boolean);
    if (!urls.length) {
        photoPreview.innerHTML = '<span class="badge text-dark border border-dark rounded-0 py-1 px-2" style="background:#FDE047;">Produk ini belum memiliki foto. Silakan pilih file foto di atas lalu klik Perbarui Produk.</span>';
        return;
    }
    urls.forEach((url, idx) => {
        const wrap = document.createElement('div');
        wrap.className = 'border border-dark p-1 bg-white text-center';
        wrap.style.width = '70px';

        const img = document.createElement('img');
        img.src = url;
        img.alt = `Foto ${idx + 1}`;
        img.style.cssText = 'width:60px;height:60px;object-fit:cover;display:block;margin:0 auto;';

        const cap = document.createElement('div');
        cap.className = 'font-monospace text-[10px] text-secondary mt-1';
        cap.textContent = `Foto #${idx + 1}`;

        wrap.appendChild(img);
        wrap.appendChild(cap);
        photoPreview.appendChild(wrap);
    });
}

function resetProductForm() {
    const form = document.getElementById('product-form');
    form?.reset();
    if (fOriginalId) fOriginalId.value = '';
    if (fId) fId.value = '';
    if (fName) fName.value = '';
    document.getElementById('f-brand').value = '';
    document.getElementById('f-badge').value = '';
    document.getElementById('f-image').value = '';
    document.getElementById('f-specs').value = '';
    document.getElementById('f-variants').value = '';
    document.getElementById('f-sold-out').checked = false;
    isSlugManuallyEdited = false;
    if (photoPreview) photoPreview.innerHTML = '';
    editModeBanner?.classList.add('d-none');
    if (productFormModeBadge) {
        productFormModeBadge.textContent = 'MODE TAMBAH BARU';
        productFormModeBadge.style.background = '#F3ECE1';
    }
    if (saveBtn) {
        saveBtn.textContent = 'Simpan Produk';
    }
}

document.getElementById('btn-reset-product')?.addEventListener('click', resetProductForm);
document.getElementById('btn-cancel-edit')?.addEventListener('click', resetProductForm);

document.querySelectorAll('.edit-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
        isSlugManuallyEdited = true;
        document.getElementById('f-original-id').value = btn.dataset.id;
        document.getElementById('f-id').value = btn.dataset.id;
        document.getElementById('f-name').value = btn.dataset.name;
        document.getElementById('f-brand').value = btn.dataset.brand;
        document.getElementById('f-category').value = btn.dataset.category;
        document.getElementById('f-badge').value = btn.dataset.badge;
        document.getElementById('f-image').value = btn.dataset.image;
        document.getElementById('f-specs').value = btn.dataset.specs;
        document.getElementById('f-variants').value = btn.dataset.variants;
        document.getElementById('f-sold-out').checked = btn.dataset.soldOut === '1';

        if (editModeProductName) editModeProductName.textContent = `${btn.dataset.name} (${btn.dataset.id})`;
        editModeBanner?.classList.remove('d-none');
        if (productFormModeBadge) {
            productFormModeBadge.textContent = 'MODE EDIT PRODUK';
            productFormModeBadge.style.background = '#E5AC67';
        }
        if (saveBtn) {
            saveBtn.textContent = 'Perbarui Produk';
        }
        renderExistingPhotoThumbnails(btn.dataset.image);
        document.getElementById('product-form').scrollIntoView({ behavior: 'smooth' });
    });
});

// Pencarian & Filter Instan Tabel Produk Admin
const adminTableSearch = document.getElementById('admin-table-search');
const adminTableCat = document.getElementById('admin-table-cat');
const adminTableStatus = document.getElementById('admin-table-status');
const adminProductRows = document.querySelectorAll('.admin-product-row');
const adminTableEmpty = document.getElementById('admin-table-empty');
const adminProductCount = document.getElementById('admin-product-count');

function filterAdminProductTable() {
    const q = (adminTableSearch?.value || '').toLowerCase().trim();
    const cat = adminTableCat?.value || '';
    const status = adminTableStatus?.value || '';
    let visible = 0;

    adminProductRows.forEach((row) => {
        const matchQ = !q || (row.dataset.search || '').includes(q);
        const matchCat = !cat || row.dataset.category === cat;
        const matchStatus = !status
            || (status === 'nophoto' ? row.dataset.hasPhoto === '0' : row.dataset.status === status);
        const show = matchQ && matchCat && matchStatus;
        row.classList.toggle('d-none', !show);
        if (show) visible++;
    });

    if (adminTableEmpty) {
        adminTableEmpty.classList.toggle('d-none', visible > 0);
    }
    if (adminProductCount) {
        adminProductCount.textContent = `${visible} / ${adminProductRows.length}`;
    }
}

adminTableSearch?.addEventListener('input', filterAdminProductTable);
adminTableCat?.addEventListener('change', filterAdminProductTable);
adminTableStatus?.addEventListener('change', filterAdminProductTable);

// Story Card Generator (9:16)
const STORE_NAME = @json($catalog['store_name'] ?? 'Java Computer Seller');
const STORE_LOGO = @json(!empty($catalog['logo']) ? $catalog['logo'] : null);
const STORE_WA = @json($catalog['whatsapp_number'] ?? '6281234567890');
const STORE_ADDRESS = @json($catalog['address'] ?? 'Jl. Raya Utama, Indonesia');
const BASE_ORIGIN = window.location.origin;

const STORY_DEFAULT_LAYOUT = {
    logo: { x: 80, y: 157, w: 96, h: 96 },
    headerTitle: { x: 196, y: 198, maxW: 684 },
    headerSub: { x: 196, y: 236, maxW: 684 },
    stripLeft: { x: 84, y: 321, maxW: 540 },
    stripRight: { x: 996, y: 321, maxW: 350 },
    photo: { x: 68, y: 378, w: 944, h: 584 },
    soldOut: { x: 60, y: 382, w: 330, h: 58 },
    brandY: 1022,
    nameY: 1080,
    priceBox: { x: 60, y: 1235, w: 960, h: 300, variantH: 56 },
    footer: { x: 60, y: 1560, w: 960, h: 200 },
};

const storyImageCache = new Map();

function isCrossOriginUrl(url) {
    if (!url || url.startsWith('/') || url.startsWith('data:')) return false;
    try {
        return new URL(url, window.location.href).origin !== window.location.origin;
    } catch (e) {
        return false;
    }
}

function loadCanvasImage(url) {
    if (!url) return Promise.resolve(null);
    const crossOrigin = isCrossOriginUrl(url);
    const cached = storyImageCache.get(url);
    if (cached && cached.complete && cached.naturalWidth > 0) {
        return Promise.resolve(cached);
    }
    return new Promise((resolve) => {
        const img = new Image();
        if (crossOrigin) {
            img.crossOrigin = 'anonymous';
        }
        img.onload = () => {
            if (!crossOrigin) {
                storyImageCache.set(url, img);
            }
            resolve(img);
        };
        img.onerror = () => resolve(null);
        img.src = url;
    });
}

function fitFontSize(ctx, text, weightFamily, maxWidth, startPx, minPx) {
    let size = startPx;
    while (size > minPx) {
        ctx.font = `${weightFamily}`.replace('{size}', String(size));
        if (ctx.measureText(text).width <= maxWidth) break;
        size -= 2;
    }
    ctx.font = `${weightFamily}`.replace('{size}', String(size));
    return size;
}

if (STORE_LOGO) {
    loadCanvasImage(STORE_LOGO);
}

function formatRupiahStory(num) {
    return 'Rp ' + Math.round(Number(num) || 0).toLocaleString('id-ID');
}

let currentStoryProduct = null;
let currentStoryRenderId = 0;

const storyModalEl = document.getElementById('storyModal');
const storyCanvas = document.getElementById('story-canvas');
const storyThemeSelect = document.getElementById('story-theme-select');
const storyVariantSelect = document.getElementById('story-variant-select');
const storyPhotoSelect = document.getElementById('story-photo-select');
const storyIncludeSpecs = document.getElementById('story-include-specs');
const storyCaptionText = document.getElementById('story-caption-text');
const storyLoading = document.getElementById('story-loading');
const storyCorsNotice = document.getElementById('story-cors-notice');
const btnDownloadStory = document.getElementById('btn-download-story');
const btnShareStory = document.getElementById('btn-share-story');
const btnCopyCaption = document.getElementById('btn-copy-caption');
const storyCopyFeedback = document.getElementById('story-copy-feedback');

const STORY_THEMES = {
    default: {
        bgAsset: '/images/story-themes/default/bg.png',
        overlayAsset: '/images/story-themes/default/overlay.png',
        canvasBg: '#FCF9F3',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#F3ECE1',
        headerText: '#1A1A1A',
        headerSubText: '#57534E',
        headerSub: 'PUSAT KOMPUTER, LAPTOP & HARDWARE RESMI',
        stripBg: '#E5AC67',
        stripText: '#1A1A1A',
        rightStripTag: 'GARANSI RESMI TOKO',
        brandColor: '#825514',
        titleColor: '#1A1A1A',
        variantBarBg: '#E5AC67',
        variantBarText: '#1A1A1A',
        hematBg: '#DC2626',
        hematText: '#FFFFFF',
        promoBg: '#22C55E',
        promoText: '#1A1A1A',
        promoHeading: 'HARGA PROMO SPESIAL:',
        footerBg: '#F3ECE1',
        waColor: '#15803D',
        footerNote: 'Pesan cepat tanpa ribet via link di bio / status WhatsApp!',
        captionHook: 'Spill setup wajib buat nugas, kerja, atau mabar tanpa drama ngelag!',
        captionClosing: 'Unit 100% ori, bergaransi resmi toko, tinggal gas pake. Stok promo terbatas, jangan sampe kehabisan!',
    },
    ramadhan: {
        bgAsset: '/images/story-themes/ramadhan/bg.png',
        overlayAsset: '/images/story-themes/ramadhan/overlay.png',
        canvasBg: '#FAF6EC',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#F3ECE1',
        headerText: '#1A1A1A',
        headerSubText: '#065F46',
        headerSub: 'SPESIAL BERKAH BULAN SUCI RAMADHAN',
        stripBg: '#FCD34D',
        stripText: '#1A1A1A',
        rightStripTag: 'PROMO BERKAH RAMADHAN',
        brandColor: '#065F46',
        titleColor: '#1A1A1A',
        variantBarBg: '#FCD34D',
        variantBarText: '#1A1A1A',
        hematBg: '#B45309',
        hematText: '#FFFFFF',
        promoBg: '#065F46',
        promoText: '#FFFFFF',
        promoHeading: 'HARGA BERKAH RAMADHAN:',
        footerBg: '#F3ECE1',
        waColor: '#065F46',
        footerNote: 'Promo berkah Ramadhan: gratis instalasi & siap pakai untuk ibadah/kerja!',
        captionHook: 'Edisi Berkah Ramadhan! Ngabuburit makin produktif bareng gear baru yang sat-set:',
        captionClosing: 'Udah free instalasi & garansi resmi toko. Stok Ramadhan terbatas, amankan unitmu sebelum sold out!',
    },
    idul_fitri: {
        bgAsset: '/images/story-themes/idul_fitri/bg.png',
        overlayAsset: '/images/story-themes/idul_fitri/overlay.png',
        canvasBg: '#F7FAF5',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#ECFDF5',
        headerText: '#1A1A1A',
        headerSubText: '#166534',
        headerSub: 'PROMO SPESIAL HARI RAYA IDUL FITRI',
        stripBg: '#FDE047',
        stripText: '#1A1A1A',
        rightStripTag: 'SPESIAL LEBARAN IDUL FITRI',
        brandColor: '#166534',
        titleColor: '#1A1A1A',
        variantBarBg: '#FDE047',
        variantBarText: '#1A1A1A',
        hematBg: '#B45309',
        hematText: '#FFFFFF',
        promoBg: '#15803D',
        promoText: '#FFFFFF',
        promoHeading: 'HARGA SPESIAL IDUL FITRI:',
        footerBg: '#ECFDF5',
        waColor: '#15803D',
        footerNote: 'Spesial Hari Raya Idul Fitri: tukar THR dengan perangkat bergaransi resmi!',
        captionHook: 'THR cair saatnya self-reward! Upgrade laptop atau PC impian di Promo Spesial Lebaran:',
        captionClosing: 'Biar THR nggak numpang lewat doang, mending jadiin gear awet bergaransi resmi toko!',
    },
    tahun_baru: {
        bgAsset: '/images/story-themes/tahun_baru/bg.png',
        overlayAsset: '/images/story-themes/tahun_baru/overlay.png',
        canvasBg: '#0F172A',
        frameBorder: '#38BDF8',
        shadowHex: '#38BDF8',
        headerBg: '#F8FAFC',
        headerText: '#0F172A',
        headerSubText: '#1E3A8A',
        headerSub: 'PROMO TAHUN BARU - UPGRADE SETUP BARU',
        stripBg: '#FACC15',
        stripText: '#0F172A',
        rightStripTag: 'TAHUN BARU SETUP BARU',
        brandColor: '#FACC15',
        titleColor: '#F8FAFC',
        variantBarBg: '#38BDF8',
        variantBarText: '#0F172A',
        hematBg: '#E11D48',
        hematText: '#FFFFFF',
        promoBg: '#FACC15',
        promoText: '#0F172A',
        promoHeading: 'HARGA PROMO TAHUN BARU:',
        footerBg: '#F8FAFC',
        waColor: '#0369A1',
        footerNote: 'Sambut tahun baru dengan laptop & PC rakitan baru siap kerja cepat!',
        captionHook: 'Tahun baru, setup baru! Bye-bye device lemot, saatnya pindah ke yang ngebut:',
        captionClosing: 'Awali tahun baru dengan performa maksimal, 100% ori & langsung siap tempur!',
    },
    kemerdekaan: {
        bgAsset: '/images/story-themes/kemerdekaan/bg.png',
        overlayAsset: '/images/story-themes/kemerdekaan/overlay.png',
        canvasBg: '#FFF8F6',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#FFFFFF',
        headerText: '#1A1A1A',
        headerSubText: '#B91C1C',
        headerSub: 'SEMARAK KEMERDEKAAN REPUBLIK INDONESIA',
        stripBg: '#DC2626',
        stripText: '#FFFFFF',
        rightStripTag: 'DIRGAHAYU RI 17 AGUSTUS',
        brandColor: '#B91C1C',
        titleColor: '#1A1A1A',
        variantBarBg: '#FDE047',
        variantBarText: '#1A1A1A',
        hematBg: '#1A1A1A',
        hematText: '#FFFFFF',
        promoBg: '#B91C1C',
        promoText: '#FFFFFF',
        promoHeading: 'HARGA PROMO MERDEKA:',
        footerBg: '#FFFFFF',
        waColor: '#B91C1C',
        footerNote: 'Promo Semarak Kemerdekaan RI: diskon merdeka untuk semua produk pilihan!',
        captionHook: 'Promo Merdeka 17-an! Saatnya merdeka dari laptop kentang & PC lemot:',
        captionClosing: 'Harga merdeka paling worth it minggu ini, jaminan ori & garansi resmi toko!',
    },
    back_to_school: {
        bgAsset: '/images/story-themes/back_to_school/bg.png',
        overlayAsset: '/images/story-themes/back_to_school/overlay.png',
        canvasBg: '#F1F5F9',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#FFFFFF',
        headerText: '#0F172A',
        headerSubText: '#1D4ED8',
        headerSub: 'SPESIAL TAHUN AJARAN BARU PELAJAR & MAHASISWA',
        stripBg: '#FDE047',
        stripText: '#0F172A',
        rightStripTag: 'PROMO PELAJAR & MAHASISWA',
        brandColor: '#1D4ED8',
        titleColor: '#0F172A',
        variantBarBg: '#DBEAFE',
        variantBarText: '#0F172A',
        hematBg: '#E11D48',
        hematText: '#FFFFFF',
        promoBg: '#1D4ED8',
        promoText: '#FFFFFF',
        promoHeading: 'HARGA PROMO PELAJAR:',
        footerBg: '#FFFFFF',
        waColor: '#1D4ED8',
        footerNote: 'Gratis instalasi Windows, Office & aplikasi kuliah/sekolah siap pakai!',
        captionHook: 'Back to School & Campus! Senjata wajib buat pejuang tugas, coding, sampe skripsian:',
        captionClosing: 'Udah free instalasi Windows, Office & aplikasi kuliah. Tinggal buka, langsung siap nugas!',
    },
    pemilu: {
        bgAsset: '/images/story-themes/pemilu/bg.png',
        overlayAsset: '/images/story-themes/pemilu/overlay.png',
        canvasBg: '#FAF7FC',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#F3E8FF',
        headerText: '#1A1A1A',
        headerSubText: '#5B21B6',
        headerSub: 'PROMO PESTA DEMOKRASI - DISKON SPESIAL PEMILU',
        stripBg: '#DDD6FE',
        stripText: '#1A1A1A',
        rightStripTag: 'PROMO PESTA DEMOKRASI',
        brandColor: '#5B21B6',
        titleColor: '#1A1A1A',
        variantBarBg: '#FCE7F3',
        variantBarText: '#1A1A1A',
        hematBg: '#E11D48',
        hematText: '#FFFFFF',
        promoBg: '#5B21B6',
        promoText: '#FFFFFF',
        promoHeading: 'HARGA SPESIAL PEMILU:',
        footerBg: '#F3E8FF',
        waColor: '#5B21B6',
        footerNote: 'Semarak Pesta Demokrasi: tunjukkan jari tinta ungu & klaim harga promo ini!',
        captionHook: 'Spesial Pesta Demokrasi! Habis nyoblos jangan lupa klaim diskon jari tinta ungu:',
        captionClosing: 'Cukup tunjukin jari tinta ungu kamu buat dapetin harga spesial ini di toko atau via chat!',
    }
};

window.ADMIN_VIDEO_FRAMER_CONFIG = {
    storeName: STORE_NAME,
    storeLogo: STORE_LOGO,
    storeWa: STORE_WA,
    storeAddress: STORE_ADDRESS,
    themes: STORY_THEMES,
};

function getActiveStoryTheme() {
    const key = storyThemeSelect?.value || 'default';
    return STORY_THEMES[key] || STORY_THEMES.default;
}

if (navigator.share) {
    btnShareStory?.classList.remove('d-none');
}

function updateStoryCaption() {
    if (!currentStoryProduct) return;
    const theme = getActiveStoryTheme();
    const vIdx = parseInt(storyVariantSelect.value, 10) || 0;
    const v = currentStoryProduct.variants[vIdx] || currentStoryProduct.variants[0];
    const saveAmt = Math.max(0, v.original_price - v.promo_price);
    const productUrl = `${BASE_ORIGIN}/#produk-${currentStoryProduct.id}`;
    const priceLine = saveAmt > 0
        ? `Harga Promo: ${formatRupiahStory(v.promo_price)} (Harga normal ${formatRupiahStory(v.original_price)}, auto hemat ${formatRupiahStory(saveAmt)}!)`
        : `Harga Spesial: ${formatRupiahStory(v.promo_price)}`;

    const lines = [
        theme.captionHook,
        `${currentStoryProduct.name} (${currentStoryProduct.brand}) - Varian ${v.label}`,
        ``,
        priceLine,
        ``,
        `Spek andalan:`,
        ...currentStoryProduct.specs.slice(0, 4).map(s => `- ${s}`),
        ``,
        theme.captionClosing,
        ``,
        `Chat & Order WhatsApp: ${STORE_WA}`,
        `Cek katalog lengkap: ${productUrl}`,
    ];

    storyCaptionText.value = lines.join('\n');
}

async function renderStoryCanvas() {
    if (!currentStoryProduct || !storyCanvas) return;
    const ctx = storyCanvas.getContext('2d');
    const renderId = ++currentStoryRenderId;
    const theme = getActiveStoryTheme();
    const layout = theme.layout || STORY_DEFAULT_LAYOUT;
    const boxShadow = theme.shadowHex || '#111111';

    const vIdx = parseInt(storyVariantSelect.value, 10) || 0;
    const variant = currentStoryProduct.variants[vIdx] || currentStoryProduct.variants[0];
    const photoUrl = storyPhotoSelect && storyPhotoSelect.options.length > 0
        ? storyPhotoSelect.value
        : (currentStoryProduct.images[0] || '');
    const showSpecs = storyIncludeSpecs.checked;

    storyLoading?.classList.remove('d-none');
    storyCorsNotice?.classList.add('d-none');

    try {
        if (document.fonts && document.fonts.ready) {
            await Promise.race([
                document.fonts.ready,
                new Promise((resolve) => setTimeout(resolve, 1500)),
            ]);
        }
        if (renderId !== currentStoryRenderId) return;

        const [bgImg, overlayImg, logoImg, photoImg] = await Promise.all([
            loadCanvasImage(theme.bgAsset),
            loadCanvasImage(theme.overlayAsset),
            STORE_LOGO ? loadCanvasImage(STORE_LOGO) : Promise.resolve(null),
            photoUrl ? loadCanvasImage(photoUrl) : Promise.resolve(null),
        ]);
        if (renderId !== currentStoryRenderId) return;

        if (photoUrl && !photoImg) {
            storyCorsNotice?.classList.remove('d-none');
        }

        function drawFallbackZones() {
            ctx.lineWidth = 10;
            ctx.strokeStyle = theme.frameBorder;
            ctx.strokeRect(24, 24, 1032, 1872);

            const drawZoneBox = (x, y, w, h, fill, off) => {
                ctx.fillStyle = boxShadow;
                ctx.fillRect(x + off, y + off, w, h);
                ctx.fillStyle = fill;
                ctx.fillRect(x, y, w, h);
                ctx.lineWidth = 4;
                ctx.strokeStyle = '#111111';
                ctx.strokeRect(x, y, w, h);
            };
            drawZoneBox(60, 140, 960, 130, theme.headerBg, 8);
            drawZoneBox(60, 290, 960, 60, theme.stripBg, 6);
            drawZoneBox(60, 370, 960, 600, '#FFFFFF', 10);
            drawZoneBox(60, layout.priceBox.y, layout.priceBox.w, layout.priceBox.h, '#FFFFFF', 10);
            ctx.fillStyle = theme.variantBarBg;
            ctx.fillRect(60, layout.priceBox.y, layout.priceBox.w, layout.priceBox.variantH);
            ctx.strokeRect(60, layout.priceBox.y, layout.priceBox.w, layout.priceBox.variantH);
            drawZoneBox(60, layout.footer.y, layout.footer.w, layout.footer.h, theme.footerBg, 8);
        }

        function drawPhotoPlaceholder() {
            const px = 84;
            const py = 396;
            const pw = 912;
            const ph = 548;

            ctx.fillStyle = '#F3ECE1';
            ctx.fillRect(px, py, pw, ph);

            ctx.save();
            ctx.setLineDash([12, 8]);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#B87834';
            ctx.strokeRect(px + 20, py + 20, pw - 40, ph - 40);
            ctx.restore();

            ctx.fillStyle = '#1A1A1A';
            ctx.fillRect(360, py + 178, 360, 44);
            ctx.fillStyle = '#E5AC67';
            ctx.font = "bold 20px 'JetBrains Mono', monospace";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('[ FOTO PRODUK MENYUSUL ]', 540, py + 201);

            ctx.fillStyle = '#825514';
            fitFontSize(ctx, currentStoryProduct.name, "bold {size}px 'Space Grotesk', sans-serif", 800, 34, 22);
            ctx.fillText(currentStoryProduct.name, 540, py + 286, 800);

            ctx.fillStyle = '#57534E';
            ctx.font = "bold 22px 'JetBrains Mono', monospace";
            ctx.fillText(`${currentStoryProduct.brand} • ${currentStoryProduct.category}`, 540, py + 334, 800);
            ctx.textBaseline = 'alphabetic';
        }

        // LAYER 1: Theme background asset (or brutalist fallback boxes if offline)
        ctx.fillStyle = theme.canvasBg;
        ctx.fillRect(0, 0, 1080, 1920);
        if (bgImg) {
            ctx.drawImage(bgImg, 0, 0, 1080, 1920);
        } else {
            drawFallbackZones();
        }

        // LAYER 2: Product photo (contained) or placeholder + SOLD OUT ribbon
        const pRect = layout.photo;
        if (photoImg) {
            try {
                const imgW = photoImg.naturalWidth || photoImg.width;
                const imgH = photoImg.naturalHeight || photoImg.height;
                const scale = Math.min(pRect.w / imgW, pRect.h / imgH);
                const dw = imgW * scale;
                const dh = imgH * scale;
                const dx = pRect.x + (pRect.w - dw) / 2;
                const dy = pRect.y + (pRect.h - dh) / 2;
                ctx.drawImage(photoImg, dx, dy, dw, dh);
            } catch (e) {
                storyCorsNotice?.classList.remove('d-none');
                drawPhotoPlaceholder();
            }
        } else {
            drawPhotoPlaceholder();
        }

        if (currentStoryProduct.isSoldOut) {
            const so = layout.soldOut;
            ctx.fillStyle = '#111111';
            ctx.fillRect(so.x + 5, so.y + 5, so.w, so.h);
            ctx.fillStyle = '#DC2626';
            ctx.fillRect(so.x, so.y, so.w, so.h);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(so.x, so.y, so.w, so.h);
            ctx.fillStyle = '#FFFFFF';
            ctx.font = "bold 30px 'Space Grotesk', sans-serif";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('SOLD OUT', so.x + so.w / 2, so.y + so.h / 2 + 1);
            ctx.textBaseline = 'alphabetic';
        }

        // LAYER 3: Dynamic logo & typography inside safe 6-zone coordinates
        const lBox = layout.logo;
        if (logoImg && logoImg.naturalWidth > 0) {
            ctx.fillStyle = '#FFFFFF';
            ctx.fillRect(lBox.x, lBox.y, lBox.w, lBox.h);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(lBox.x, lBox.y, lBox.w, lBox.h);

            const maxLogoW = lBox.w - 12;
            const maxLogoH = lBox.h - 12;
            const lScale = Math.min(maxLogoW / logoImg.naturalWidth, maxLogoH / logoImg.naturalHeight);
            const lDrawW = logoImg.naturalWidth * lScale;
            const lDrawH = logoImg.naturalHeight * lScale;
            const lDrawX = lBox.x + (lBox.w - lDrawW) / 2;
            const lDrawY = lBox.y + (lBox.h - lDrawH) / 2;
            ctx.drawImage(logoImg, lDrawX, lDrawY, lDrawW, lDrawH);
        } else {
            ctx.fillStyle = '#B87834';
            ctx.fillRect(lBox.x, lBox.y, lBox.w, lBox.h);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(lBox.x, lBox.y, lBox.w, lBox.h);
            ctx.fillStyle = '#FFFFFF';
            ctx.font = "bold 40px 'Space Grotesk', sans-serif";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('JC', lBox.x + lBox.w / 2, lBox.y + lBox.h / 2 + 2);
            ctx.textBaseline = 'alphabetic';
        }

        // Zona 1: Store name & subtitle
        ctx.textAlign = 'left';
        ctx.textBaseline = 'alphabetic';
        ctx.fillStyle = theme.headerText;
        fitFontSize(ctx, STORE_NAME.toUpperCase(), "bold {size}px 'Space Grotesk', sans-serif", layout.headerTitle.maxW, 38, 22);
        ctx.fillText(STORE_NAME.toUpperCase(), layout.headerTitle.x, layout.headerTitle.y, layout.headerTitle.maxW);

        ctx.fillStyle = theme.headerSubText;
        ctx.font = "bold 19px 'JetBrains Mono', monospace";
        ctx.fillText(theme.headerSub, layout.headerSub.x, layout.headerSub.y, layout.headerSub.maxW);

        // Zona 2: Category & badge strip
        ctx.fillStyle = theme.stripText;
        ctx.font = "bold 22px 'JetBrains Mono', monospace";
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'left';
        const badgePart = currentStoryProduct.badge ? `  |  ${currentStoryProduct.badge.toUpperCase()}` : '';
        ctx.fillText(`● ${currentStoryProduct.category.toUpperCase()}${badgePart}`, layout.stripLeft.x, layout.stripLeft.y, layout.stripLeft.maxW);
        ctx.textAlign = 'right';
        ctx.fillText(theme.rightStripTag, layout.stripRight.x, layout.stripRight.y, layout.stripRight.maxW);
        ctx.textBaseline = 'alphabetic';

        // Zona 4: Brand, product title & optional spec chips
        ctx.textAlign = 'left';
        ctx.fillStyle = theme.brandColor;
        ctx.font = "bold 24px 'JetBrains Mono', monospace";
        ctx.fillText(`${currentStoryProduct.brand.toUpperCase()} ORIGINAL`, 64, layout.brandY, 952);

        ctx.fillStyle = theme.titleColor;
        ctx.font = "bold 46px 'Space Grotesk', sans-serif";
        const words = (currentStoryProduct.name || '').split(/\s+/).filter(Boolean);
        const titleLines = [];
        let curLine = '';
        for (const word of words) {
            const candidate = curLine ? `${curLine} ${word}` : word;
            if (ctx.measureText(candidate).width > 952 && curLine) {
                titleLines.push(curLine);
                curLine = word;
                if (titleLines.length === 2) break;
            } else {
                curLine = candidate;
            }
        }
        if (titleLines.length < 2 && curLine) {
            titleLines.push(curLine);
        } else if (titleLines.length === 2 && curLine) {
            let second = titleLines[1];
            while (second.length > 3 && ctx.measureText(`${second}...`).width > 952) {
                second = second.slice(0, -1).trim();
            }
            titleLines[1] = `${second}...`;
        }
        titleLines.forEach((ln, idx) => ctx.fillText(ln, 64, layout.nameY + idx * 56, 952));

        if (showSpecs && currentStoryProduct.specs.length > 0) {
            let specX = 64;
            const lastBaseline = layout.nameY + Math.max(0, titleLines.length - 1) * 56;
            const specY = lastBaseline + (titleLines.length > 1 ? 26 : 36);
            ctx.font = "bold 20px 'JetBrains Mono', monospace";
            currentStoryProduct.specs.slice(0, 3).forEach((rawSp) => {
                const sp = rawSp.length > 32 ? `${rawSp.slice(0, 29)}...` : rawSp;
                const spWidth = ctx.measureText(sp).width + 34;
                if (specX + spWidth <= 1020) {
                    ctx.fillStyle = boxShadow;
                    ctx.fillRect(specX + 4, specY + 4, spWidth, 42);
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(specX, specY, spWidth, 42);
                    ctx.lineWidth = 2.5;
                    ctx.strokeStyle = '#111111';
                    ctx.strokeRect(specX, specY, spWidth, 42);
                    ctx.fillStyle = '#1A1A1A';
                    ctx.textAlign = 'left';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(sp, specX + 17, specY + 22);
                    ctx.textBaseline = 'alphabetic';
                    specX += spWidth + 14;
                }
            });
        }

        // Zona 5: Variant bar, normal/hemat row & promo price banner
        const pb = layout.priceBox;
        ctx.fillStyle = theme.variantBarText;
        ctx.font = "bold 23px 'JetBrains Mono', monospace";
        ctx.textAlign = 'left';
        ctx.textBaseline = 'middle';
        ctx.fillText(`VARIAN: ${variant.label}`.substring(0, 54), 80, pb.y + pb.variantH / 2 + 1, 920);
        ctx.textBaseline = 'alphabetic';

        const saveAmount = Math.max(0, variant.original_price - variant.promo_price);
        if (saveAmount > 0) {
            ctx.fillStyle = '#57534E';
            ctx.font = "bold 26px 'JetBrains Mono', monospace";
            const origText = 'Normal: ' + formatRupiahStory(variant.original_price);
            ctx.fillText(origText, 80, pb.y + 109, 580);
            const origWidth = Math.min(580, ctx.measureText(origText).width);
            ctx.strokeStyle = '#57534E';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(76, pb.y + 100);
            ctx.lineTo(84 + origWidth, pb.y + 100);
            ctx.stroke();

            ctx.fillStyle = '#111111';
            ctx.fillRect(688, pb.y + 77, 312, 46);
            ctx.fillStyle = theme.hematBg;
            ctx.fillRect(684, pb.y + 73, 312, 46);
            ctx.lineWidth = 2.5;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(684, pb.y + 73, 312, 46);
            ctx.fillStyle = theme.hematText;
            ctx.font = "bold 21px 'JetBrains Mono', monospace";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('HEMAT ' + formatRupiahStory(saveAmount), 840, pb.y + 97, 292);
            ctx.textBaseline = 'alphabetic';
        } else {
            ctx.fillStyle = '#57534E';
            ctx.font = "bold 24px 'JetBrains Mono', monospace";
            ctx.textAlign = 'left';
            ctx.fillText('PENAWARAN HARGA RESMI TOKO', 80, pb.y + 109, 900);
        }

        // Promo banner card inside Zona 5
        ctx.fillStyle = '#111111';
        ctx.fillRect(86, pb.y + 149, 920, 134);
        ctx.fillStyle = theme.promoBg;
        ctx.fillRect(80, pb.y + 143, 920, 134);
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(80, pb.y + 143, 920, 134);

        ctx.fillStyle = theme.promoText;
        ctx.textAlign = 'left';
        ctx.font = "bold 24px 'Space Grotesk', sans-serif";
        ctx.fillText(theme.promoHeading, 106, pb.y + 183, 650);

        const promoPriceText = formatRupiahStory(variant.promo_price);
        fitFontSize(ctx, promoPriceText, "bold {size}px 'Space Grotesk', sans-serif", 650, 64, 36);
        ctx.fillText(promoPriceText, 106, pb.y + 251, 650);

        ctx.textAlign = 'right';
        ctx.font = "bold 24px 'JetBrains Mono', monospace";
        ctx.fillText(currentStoryProduct.isSoldOut ? 'STOK HABIS' : 'READY TOKO', 974, pb.y + 221);

        // Zona 6: Footer CTA WhatsApp
        const ft = layout.footer;
        ctx.fillStyle = '#1A1A1A';
        ctx.textAlign = 'left';
        ctx.font = "bold 22px 'JetBrains Mono', monospace";
        ctx.fillText('CARA ORDER & KONSULTASI VIA WHATSAPP:', 86, ft.y + 38, 900);

        ctx.fillStyle = theme.waColor;
        const waText = `+ ${STORE_WA}`;
        fitFontSize(ctx, waText, "bold {size}px 'Space Grotesk', sans-serif", 900, 50, 32);
        ctx.fillText(waText, 86, ft.y + 96, 900);

        ctx.fillStyle = '#1A1A1A';
        ctx.font = "bold 21px 'Work Sans', sans-serif";
        ctx.fillText(STORE_ADDRESS, 86, ft.y + 140, 900);

        ctx.fillStyle = '#57534E';
        ctx.font = "bold 19px 'JetBrains Mono', monospace";
        ctx.fillText(theme.footerNote, 86, ft.y + 176, 900);

        // LAYER 4: Transparent theme overlay (stickers & stamps above frame)
        if (overlayImg) {
            ctx.drawImage(overlayImg, 0, 0, 1080, 1920);
        }
    } finally {
        if (renderId === currentStoryRenderId) {
            storyLoading?.classList.add('d-none');
        }
    }
}

document.querySelectorAll('.story-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const brand = btn.dataset.brand;
        const category = btn.dataset.category;
        const badge = btn.dataset.badge;
        const rawImages = (btn.dataset.image || '').split(';').map(s => s.trim()).filter(Boolean);
        const specs = (btn.dataset.specs || '').split('\n').map(s => s.trim()).filter(Boolean);
        const rawVariants = (btn.dataset.variants || '').split('\n').map(s => s.trim()).filter(Boolean);
        const isSoldOut = btn.dataset.soldOut === '1';

        const variants = rawVariants.map((line) => {
            const parts = line.split('|').map(p => p.trim());
            return {
                label: parts[0] || 'Standar',
                promo_price: parseInt((parts[1] || '').replace(/[^0-9]/g, ''), 10) || 0,
                original_price: parseInt((parts[2] || '').replace(/[^0-9]/g, ''), 10) || 0,
            };
        }).filter(v => v.promo_price > 0);

        currentStoryProduct = {
            id,
            name,
            brand,
            category,
            badge,
            images: rawImages,
            specs,
            variants: variants.length ? variants : [{ label: 'Unit Lengkap', promo_price: 1000000, original_price: 1200000 }],
            isSoldOut
        };

        storyVariantSelect.innerHTML = '';
        currentStoryProduct.variants.forEach((v, idx) => {
            const opt = document.createElement('option');
            opt.value = idx;
            opt.textContent = `${v.label} - ${formatRupiahStory(v.promo_price)}`;
            storyVariantSelect.appendChild(opt);
        });

        storyPhotoSelect.innerHTML = '';
        if (currentStoryProduct.images.length > 0) {
            currentStoryProduct.images.forEach((imgUrl, idx) => {
                const opt = document.createElement('option');
                opt.value = imgUrl;
                opt.textContent = `Foto ${idx + 1} (${imgUrl.startsWith('/uploads/') ? 'Upload Lokal' : 'Web/URL'})`;
                storyPhotoSelect.appendChild(opt);
            });
        } else {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'Belum Ada Foto (Gunakan Placeholder)';
            storyPhotoSelect.appendChild(opt);
        }

        storyCorsNotice?.classList.add('d-none');
        storyCopyFeedback?.classList.add('d-none');

        updateStoryCaption();
        renderStoryCanvas();

        const bsModal = window.bootstrap ? bootstrap.Modal.getOrCreateInstance(storyModalEl) : null;
        if (bsModal) {
            bsModal.show();
        } else {
            storyModalEl.classList.add('show');
            storyModalEl.style.display = 'block';
        }
    });
});

storyThemeSelect?.addEventListener('change', () => {
    updateStoryCaption();
    renderStoryCanvas();
});

storyVariantSelect?.addEventListener('change', () => {
    updateStoryCaption();
    renderStoryCanvas();
});

storyPhotoSelect?.addEventListener('change', () => {
    renderStoryCanvas();
});

storyIncludeSpecs?.addEventListener('change', () => {
    renderStoryCanvas();
});

btnDownloadStory?.addEventListener('click', () => {
    if (!currentStoryProduct || !storyCanvas) return;
    try {
        const themeKey = storyThemeSelect?.value || 'default';
        const dataUrl = storyCanvas.toDataURL('image/png');
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = `story-${currentStoryProduct.id}-${themeKey}.png`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } catch (e) {
        alert('Gagal mengunduh gambar karena pembatasan CORS pada foto eksternal. Silakan gunakan foto yang diunggah ke server lokal.');
    }
});

btnShareStory?.addEventListener('click', () => {
    if (!currentStoryProduct || !storyCanvas || !navigator.share) return;
    const themeKey = storyThemeSelect?.value || 'default';
    storyCanvas.toBlob(async (blob) => {
        if (!blob) return;
        try {
            const file = new File([blob], `story-${currentStoryProduct.id}-${themeKey}.png`, { type: 'image/png' });
            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                await navigator.share({
                    title: `Promo ${currentStoryProduct.name} - ${STORE_NAME}`,
                    text: storyCaptionText.value,
                    files: [file],
                });
            } else {
                await navigator.share({
                    title: `Promo ${currentStoryProduct.name} - ${STORE_NAME}`,
                    text: storyCaptionText.value,
                    url: `${BASE_ORIGIN}/#produk-${currentStoryProduct.id}`,
                });
            }
        } catch (err) {
            if (err.name !== 'AbortError') {
                console.error(err);
            }
        }
    }, 'image/png');
});

btnCopyCaption?.addEventListener('click', async () => {
    if (!storyCaptionText.value) return;
    try {
        await navigator.clipboard.writeText(storyCaptionText.value);
        storyCopyFeedback?.classList.remove('d-none');
        btnCopyCaption.textContent = '✓ Berhasil Disalin';
        setTimeout(() => {
            storyCopyFeedback?.classList.add('d-none');
            btnCopyCaption.textContent = 'Salin Caption WA/IG';
        }, 3000);
    } catch (e) {
        storyCaptionText.select();
        document.execCommand('copy');
    }
});

// Interactive Visual Icon Picker for Hero Badges & About Features
const lastActiveLineByTarget = { 'f-hero-badges': 0, 'f-about-features': 0 };

['f-hero-badges', 'f-about-features'].forEach((targetId) => {
    const textarea = document.getElementById(targetId);
    if (!textarea) return;
    const recordCursorLine = () => {
        const pos = textarea.selectionStart || 0;
        const lineIdx = textarea.value.slice(0, pos).split(/\r\n|\r|\n/).length - 1;
        lastActiveLineByTarget[targetId] = Math.max(0, lineIdx);
    };
    textarea.addEventListener('click', recordCursorLine);
    textarea.addEventListener('keyup', recordCursorLine);
});

document.querySelectorAll('.icon-search-input').forEach((input) => {
    input.addEventListener('input', () => {
        const q = input.value.trim().toLowerCase();
        const container = input.closest('.icon-picker-body');
        if (!container) return;
        container.querySelectorAll('.icon-group').forEach((group) => {
            let visibleInGroup = 0;
            group.querySelectorAll('.icon-pick-btn').forEach((btn) => {
                const hay = btn.getAttribute('data-search') || '';
                const match = q === '' || hay.includes(q);
                btn.classList.toggle('d-none', !match);
                if (match) visibleInGroup++;
            });
            group.classList.toggle('d-none', visibleInGroup === 0);
        });
    });
});

document.querySelectorAll('.icon-pick-btn').forEach((btn) => {
    btn.addEventListener('click', async () => {
        const targetId = btn.getAttribute('data-target');
        const iconCode = btn.getAttribute('data-icon');
        const textarea = targetId ? document.getElementById(targetId) : null;
        if (!textarea || !iconCode) return;

        const container = btn.closest('.icon-picker-body');
        const lineSelect = container?.querySelector('.icon-line-select');
        const rawLines = textarea.value.split(/\r\n|\r|\n/);
        while (rawLines.length > 1 && rawLines[rawLines.length - 1].trim() === '') {
            rawLines.pop();
        }
        if (rawLines.length === 0 || (rawLines.length === 1 && rawLines[0].trim() === '')) {
            rawLines[0] = `Judul Poin | Deskripsi singkat | ${iconCode}`;
        }

        let targetLineIdx = lastActiveLineByTarget[targetId] ?? 0;
        if (lineSelect && lineSelect.value !== 'cursor') {
            targetLineIdx = parseInt(lineSelect.value, 10) || 0;
        }
        if (targetLineIdx >= rawLines.length) {
            targetLineIdx = Math.max(0, rawLines.length - 1);
        }

        const parts = rawLines[targetLineIdx].split('|').map((s) => s.trim());
        const title = parts[0] || `Poin ${targetLineIdx + 1}`;
        const desc = parts[1] || 'Deskripsi singkat keunggulan';
        rawLines[targetLineIdx] = `${title} | ${desc} | ${iconCode}`;
        textarea.value = rawLines.join('\n');

        try {
            await navigator.clipboard.writeText(iconCode);
        } catch (e) {}

        const feedback = container?.querySelector('.icon-feedback');
        if (feedback) {
            feedback.textContent = `✓ Icon "${iconCode}" diterapkan ke Baris ${targetLineIdx + 1} (${title})! Jangan lupa klik Simpan Pengaturan.`;
            feedback.classList.remove('d-none');
        }
    });
});
</script>
<script src="/js/admin-video-framer.js"></script>
</body>
</html>
