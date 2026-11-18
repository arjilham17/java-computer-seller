<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — {{ $catalog['store_name'] }}</title>
    <link rel="icon" type="image/x-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.ico' }}">
    <link rel="icon" type="image/svg+xml" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.svg' }}">
    <link rel="apple-touch-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/apple-touch-icon.png' }}">
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@600;700&amp;family=Space+Grotesk:wght@600;700&amp;family=Work+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
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
    </style>
</head>
<body>
<nav class="navbar brutal-nav py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="fw-bold font-headline fs-5">Dashboard Admin — {{ $catalog['store_name'] }}</div>
        <div class="d-flex gap-2">
            <a href="/admin/backup" class="btn btn-light btn-sm" title="Download backup data katalog JSON">Backup JSON</a>
            <a href="/" target="_blank" class="btn btn-primary btn-sm">Lihat Landing Page</a>
            <form method="POST" action="/admin/logout" class="m-0">
                @csrf
                <button type="submit" class="btn btn-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container pb-5">
    @if (session('status'))
        <div class="alert alert-success rounded-0 border-2 border-dark fw-semibold">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger rounded-0 border-2 border-dark">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="brutal-card p-4 mb-4">
                <h2 class="h5 fw-bold mb-3">1. Profil Toko & Hero Flash Deal</h2>
                <form method="POST" action="/admin/settings" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-logo">Logo Toko (PNG/JPG/WEBP, maks 2MB)</label>
                        <div class="d-flex align-items-center gap-2">
                            @if (!empty($catalog['logo']))
                                <img src="{{ $catalog['logo'] }}" alt="Logo saat ini" style="height: 40px; width: auto;" class="border border-2 border-dark p-1 bg-white">
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
                        <label class="form-label small fw-semibold">Nama Toko</label>
                        <input type="text" name="store_name" class="form-control form-control-sm" value="{{ $catalog['store_name'] }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Tagline</label>
                        <input type="text" name="tagline" class="form-control form-control-sm" value="{{ $catalog['tagline'] }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Nomor WhatsApp (Format 628...)</label>
                        <input type="text" name="whatsapp_number" class="form-control form-control-sm" value="{{ $catalog['whatsapp_number'] }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Alamat Toko</label>
                        <input type="text" name="address" class="form-control form-control-sm" value="{{ $catalog['address'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jam Operasional</label>
                        <input type="text" name="hours" class="form-control form-control-sm" value="{{ $catalog['hours'] }}" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control form-control-sm" placeholder="https://instagram.com/namatoko" value="{{ $catalog['instagram_url'] ?? '' }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">TikTok URL</label>
                        <input type="url" name="tiktok_url" class="form-control form-control-sm" placeholder="https://tiktok.com/@namatoko" value="{{ $catalog['tiktok_url'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control form-control-sm" placeholder="https://facebook.com/namatoko" value="{{ $catalog['facebook_url'] ?? '' }}">
                    </div>

                    <hr class="border-2 border-dark opacity-100">
                    <h3 class="h6 fw-bold mb-2">Kartu Hero Flash Deal</h3>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Badge Promo</label>
                        <input type="text" name="hero_badge" class="form-control form-control-sm" value="{{ $catalog['hero_deal']['badge'] }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Produk Hero</label>
                        <input type="text" name="hero_title" class="form-control form-control-sm" value="{{ $catalog['hero_deal']['title'] }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Subjudul Spesifikasi</label>
                        <input type="text" name="hero_subtitle" class="form-control form-control-sm" value="{{ $catalog['hero_deal']['subtitle'] }}" required>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Harga Coret (Rp)</label>
                            <input type="number" name="hero_original_price" class="form-control form-control-sm" value="{{ $catalog['hero_deal']['original_price'] }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Harga Promo (Rp)</label>
                            <input type="number" name="hero_promo_price" class="form-control form-control-sm" value="{{ $catalog['hero_deal']['promo_price'] }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Info Bonus / Hemat</label>
                        <input type="text" name="hero_bonus" class="form-control form-control-sm" value="{{ $catalog['hero_deal']['bonus'] }}" required>
                    </div>

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
                    @endphp

                    <hr class="border-2 border-dark opacity-100">
                    <h3 class="h6 fw-bold mb-2">Konten #tentang-kami</h3>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Section Keunggulan</label>
                        <input type="text" name="about_title" class="form-control form-control-sm" value="{{ $catalog['about_title'] ?? '' }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Deskripsi Section</label>
                        <textarea name="about_subtitle" rows="2" class="form-control form-control-sm">{{ $catalog['about_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Poin Keunggulan (1 baris per item: <code>Judul | Deskripsi | Icon</code>)</label>
                        <textarea name="about_features_text" rows="4" class="form-control form-control-sm font-monospace small">{{ $aboutFeaturesText }}</textarea>
                    </div>

                    <hr class="border-2 border-dark opacity-100">
                    <h3 class="h6 fw-bold mb-2">Konten #kontak &amp; FAQ</h3>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul Section Kontak</label>
                        <input type="text" name="contact_title" class="form-control form-control-sm" value="{{ $catalog['contact_title'] ?? '' }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Deskripsi Section Kontak</label>
                        <textarea name="contact_subtitle" rows="2" class="form-control form-control-sm">{{ $catalog['contact_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">URL Peta / Embed Google Maps</label>
                        <input type="text" name="map_image" class="form-control form-control-sm" value="{{ $catalog['map_image'] ?? '' }}" placeholder="https://maps.google.com/maps?... atau URL gambar">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Link Tautan Google Maps</label>
                        <input type="text" name="map_link" class="form-control form-control-sm" value="{{ $catalog['map_link'] ?? 'https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8' }}" placeholder="https://maps.app.goo.gl/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Daftar FAQ (1 baris per pertanyaan: <code>Pertanyaan | Jawaban</code>)</label>
                        <textarea name="faq_text" rows="4" class="form-control form-control-sm font-monospace small">{{ $faqsText }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Simpan Pengaturan &amp; Konten</button>
                </form>
            </div>

            <div class="brutal-card p-4 mb-4">
                <div class="d-inline-block px-2 py-0.5 mb-2 fw-bold font-monospace small border border-dark" style="background:#E5AC67;">KEAMANAN AKUN</div>
                <h2 class="h5 fw-bold mb-3">Ganti Password Admin</h2>
                <form method="POST" action="/admin/password">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-current-password">Password Saat Ini</label>
                        <input type="password" name="current_password" id="f-current-password" class="form-control form-control-sm" autocomplete="current-password" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold" for="f-new-password">Password Baru (Minimal 8 Karakter)</label>
                        <input type="password" name="new_password" id="f-new-password" class="form-control form-control-sm" minlength="8" autocomplete="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="f-new-password-confirm">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" id="f-new-password-confirm" class="form-control form-control-sm" minlength="8" autocomplete="new-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Perbarui Password Admin</button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="brutal-card p-4 mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                    <h2 class="h5 fw-bold mb-0">2. Posting Massal (Template Excel)</h2>
                    <a href="/admin/products/template" class="btn btn-light btn-sm">
                        Download Template Excel (.csv)
                    </a>
                </div>
                <p class="text-secondary small mb-3">
                    Unduh template, isi banyak produk sekaligus di Microsoft Excel (simpan sebagai <code>.xlsx</code> atau <code>.csv</code>), lalu unggah di sini. Pisahkan beberapa spesifikasi/varian dengan titik koma (<code>;</code>).
                </p>
                <form method="POST" action="/admin/products/import" enctype="multipart/form-data" id="bulk-form">
                    @csrf
                    <input type="hidden" name="csv_payload" id="csv-payload">
                    <div class="input-group input-group-sm">
                        <input type="file" name="file" id="bulk-file" class="form-control" accept=".csv,.xlsx,.xls" required>
                        <button type="submit" class="btn btn-primary px-3">Import Produk Massal</button>
                    </div>
                </form>
            </div>

            <div class="brutal-card p-4 mb-4">
                <h2 class="h5 fw-bold mb-3">3. Tambah / Edit Produk Satuan</h2>
                <form method="POST" action="/admin/products" enctype="multipart/form-data" id="product-form">
                    @csrf
                    <input type="hidden" name="original_id" id="f-original-id">
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">ID / Slug Produk</label>
                            <input type="text" name="id" id="f-id" class="form-control form-control-sm" placeholder="laptop-acer-aspire" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Kategori</label>
                            <select name="category" id="f-category" class="form-select form-select-sm" required>
                                @foreach (['Laptop', 'PC', 'Printer', 'Monitor', 'Aksesoris'] as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Merek</label>
                            <input type="text" name="brand" id="f-brand" class="form-control form-control-sm" placeholder="ASUS / Epson" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Nama Produk</label>
                            <input type="text" name="name" id="f-name" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Badge Kartu</label>
                            <input type="text" name="badge" id="f-badge" class="form-control form-control-sm" placeholder="Best Seller" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Upload Foto Produk (Bisa pilih lebih dari 1 foto)</label>
                        <input type="file" name="photos[]" id="f-photos" class="form-control form-control-sm" accept="image/*" multiple>
                        <div class="form-text text-muted text-[11px] mt-1">Foto &gt; 4096 KB (4 MB) otomatis dikompres sebelum upload agar hemat bandwidth dan lancar.</div>
                        <div id="photo-preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-secondary">Atau URL/Path Foto (Opsional jika sudah upload file; pisahkan dengan <code>;</code> untuk multi-foto)</label>
                        <input type="text" name="image" id="f-image" class="form-control form-control-sm" placeholder="https://images.unsplash.com/...">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Poin Spesifikasi (1 baris = 1 badge spesifikasi)</label>
                        <textarea name="specs_text" id="f-specs" rows="2" class="form-control form-control-sm" placeholder="Garansi Resmi 2 Tahun&#10;Layar FHD IPS" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Daftar Varian (Format per baris: <code>Label Varian | Harga Promo | Harga Coret</code>)</label>
                        <textarea name="variants_text" id="f-variants" rows="3" class="form-control form-control-sm font-monospace" placeholder="RAM 8GB / SSD 256GB | 5899000 | 6499000&#10;RAM 16GB / SSD 512GB | 6899000 | 7499000" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_sold_out" value="1" id="f-sold-out">
                        <label class="form-check-label small fw-semibold" for="f-sold-out">Tandai Sold Out (Stok Habis)</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" id="btn-save-product" class="btn btn-success btn-sm px-4 py-2">Simpan Produk</button>
                        <button type="reset" class="btn btn-light btn-sm">Reset Form</button>
                    </div>
                </form>
            </div>

            <div class="brutal-card p-4">
                <h2 class="h5 fw-bold mb-3">4. Daftar Produk Aktif ({{ count($catalog['products']) }})</h2>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Varian</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalog['products'] as $p)
                                @php
                                    $vLines = implode("\n", array_map(fn($v) => "{$v['label']} | {$v['promo_price']} | {$v['original_price']}", $p['variants']));
                                    $sLines = implode("\n", $p['specs']);
                                    $imgList = implode('; ', $p['images'] ?? [$p['image']]);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="fw-semibold">{{ $p['name'] }}</div>
                                            @if (!empty($p['is_sold_out']))
                                                <span class="badge bg-danger rounded-0">SOLD OUT</span>
                                            @endif
                                        </div>
                                        <small class="text-secondary">{{ $p['brand'] }} • <code>{{ $p['id'] }}</code> ({{ count($p['images'] ?? [$p['image']]) }} foto)</small>
                                    </td>
                                    <td><span class="badge text-bg-light border border-dark rounded-0">{{ $p['category'] }}</span></td>
                                    <td><small>{{ count($p['variants']) }} varian</small></td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <button type="button" class="btn btn-warning btn-sm story-btn"
                                                    data-id="{{ $p['id'] }}"
                                                    data-name="{{ $p['name'] }}"
                                                    data-brand="{{ $p['brand'] }}"
                                                    data-category="{{ $p['category'] }}"
                                                    data-badge="{{ $p['badge'] }}"
                                                    data-image="{{ $imgList }}"
                                                    data-specs="{{ $sLines }}"
                                                    data-variants="{{ $vLines }}"
                                                    data-sold-out="{{ !empty($p['is_sold_out']) ? '1' : '0' }}"
                                                    title="Generate Card Promosi Story (9:16)">
                                                Story
                                            </button>
                                            <form method="POST" action="/admin/products/{{ $p['id'] }}/toggle-sold" class="m-0 d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ !empty($p['is_sold_out']) ? 'btn-success' : 'btn-dark' }}" title="{{ !empty($p['is_sold_out']) ? 'Tandai Ready Stock' : 'Tandai Sold Out' }}">
                                                    {{ !empty($p['is_sold_out']) ? 'Set Ready' : 'Sold Out' }}
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
                                                    data-sold-out="{{ !empty($p['is_sold_out']) ? '1' : '0' }}">
                                                Edit
                                            </button>
                                            <form method="POST" action="/admin/products/{{ $p['id'] }}" onsubmit="return confirm('Hapus produk ini?')">
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
            </div>
        </div>
    </div>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
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
            saveBtn.textContent = 'Simpan Produk';
        }
    }
});

document.querySelectorAll('.edit-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
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
        document.getElementById('product-form').scrollIntoView({ behavior: 'smooth' });
    });
});

// Story Card Generator (9:16)
const STORE_NAME = @json($catalog['store_name'] ?? 'Java Computer Seller');
const STORE_LOGO = @json(!empty($catalog['logo']) ? $catalog['logo'] : null);
const STORE_WA = @json($catalog['whatsapp_number'] ?? '6281234567890');
const STORE_ADDRESS = @json($catalog['address'] ?? 'Jl. Raya Utama, Indonesia');
const BASE_ORIGIN = window.location.origin;

let storeLogoImg = null;
if (STORE_LOGO) {
    storeLogoImg = new Image();
    storeLogoImg.onload = () => {
        if (currentStoryProduct) {
            renderStoryCanvas();
        }
    };
    storeLogoImg.src = STORE_LOGO;
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
        canvasBg: '#FCF9F3',
        frameBorder: '#111111',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#E5AC67';
            ctx.fillRect(888, 80, 100, 100);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.fillStyle = '#1A1A1A';
            ctx.fillRect(913, 105, 50, 50);
            for (let i = 0; i < 3; i++) {
                const offset = 112 + i * 16;
                ctx.fillRect(900, offset, 10, 5);
                ctx.fillRect(966, offset, 10, 5);
                ctx.fillRect(808 + offset, 92, 5, 10);
                ctx.fillRect(808 + offset, 158, 5, 10);
            }
        }
    },
    ramadhan: {
        canvasBg: '#FAF6EC',
        frameBorder: '#111111',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#065F46';
            ctx.fillRect(888, 80, 100, 100);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.save();
            ctx.beginPath();
            ctx.arc(936, 130, 30, 0, Math.PI * 2);
            ctx.fillStyle = '#FCD34D';
            ctx.fill();
            ctx.lineWidth = 2.5;
            ctx.stroke();
            ctx.beginPath();
            ctx.arc(948, 122, 24, 0, Math.PI * 2);
            ctx.fillStyle = '#065F46';
            ctx.fill();
            ctx.fillStyle = '#FCD34D';
            ctx.fillRect(954, 104, 10, 10);
            ctx.restore();
        }
    },
    idul_fitri: {
        canvasBg: '#F7FAF5',
        frameBorder: '#111111',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#FDE047';
            ctx.fillRect(888, 80, 100, 100);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.save();
            ctx.translate(938, 124);
            ctx.rotate(Math.PI / 4);
            ctx.fillStyle = '#15803D';
            ctx.fillRect(-22, -22, 44, 44);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(-22, -22, 44, 44);
            ctx.strokeStyle = '#FDE047';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(-22, -7); ctx.lineTo(22, -7);
            ctx.moveTo(-22, 7); ctx.lineTo(22, 7);
            ctx.moveTo(-7, -22); ctx.lineTo(-7, 22);
            ctx.moveTo(7, -22); ctx.lineTo(7, 22);
            ctx.stroke();
            ctx.restore();
            ctx.fillStyle = '#15803D';
            ctx.fillRect(931, 156, 6, 16);
            ctx.fillRect(940, 156, 6, 16);
        }
    },
    tahun_baru: {
        canvasBg: '#0F172A',
        frameBorder: '#38BDF8',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#0F172A';
            ctx.fillRect(888, 80, 100, 100);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.save();
            ctx.translate(938, 130);
            ctx.strokeStyle = '#FACC15';
            ctx.lineWidth = 4;
            for (let i = 0; i < 8; i++) {
                ctx.beginPath();
                ctx.moveTo(0, -10);
                ctx.lineTo(0, -32);
                ctx.stroke();
                ctx.rotate(Math.PI / 4);
            }
            ctx.fillStyle = '#38BDF8';
            ctx.beginPath();
            ctx.arc(0, 0, 10, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }
    },
    kemerdekaan: {
        canvasBg: '#FFF8F6',
        frameBorder: '#111111',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#DC2626';
            ctx.fillRect(888, 80, 100, 50);
            ctx.fillStyle = '#FFFFFF';
            ctx.fillRect(888, 130, 100, 50);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.beginPath();
            ctx.moveTo(888, 130);
            ctx.lineTo(988, 130);
            ctx.stroke();
            ctx.fillStyle = '#FDE047';
            ctx.fillRect(904, 114, 68, 32);
            ctx.strokeRect(904, 114, 68, 32);
            ctx.fillStyle = '#111111';
            ctx.font = "bold 18px 'JetBrains Mono', monospace";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('17-08', 938, 131);
        }
    },
    back_to_school: {
        canvasBg: '#F1F5F9',
        frameBorder: '#111111',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#FDE047';
            ctx.fillRect(888, 80, 100, 100);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.fillStyle = '#1D4ED8';
            ctx.beginPath();
            ctx.moveTo(938, 98);
            ctx.lineTo(976, 118);
            ctx.lineTo(938, 138);
            ctx.lineTo(900, 118);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();
            ctx.fillRect(916, 136, 44, 18);
            ctx.strokeRect(916, 136, 44, 18);
            ctx.strokeStyle = '#111111';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(970, 120);
            ctx.lineTo(970, 156);
            ctx.stroke();
        }
    },
    pemilu: {
        canvasBg: '#FAF7FC',
        frameBorder: '#111111',
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
        drawOrnament(ctx) {
            ctx.fillStyle = '#DDD6FE';
            ctx.fillRect(888, 80, 100, 100);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(888, 80, 100, 100);
            ctx.fillStyle = '#FFFFFF';
            ctx.fillRect(906, 96, 64, 68);
            ctx.strokeRect(906, 96, 64, 68);
            ctx.strokeStyle = '#5B21B6';
            ctx.lineWidth = 6;
            ctx.beginPath();
            ctx.moveTo(920, 130);
            ctx.lineTo(934, 144);
            ctx.lineTo(958, 114);
            ctx.stroke();
        }
    }
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

    const lines = [
        theme.captionHook,
        `${currentStoryProduct.name} (${currentStoryProduct.brand}) - Varian ${v.label}`,
        ``,
        `Harga Promo: ${formatRupiahStory(v.promo_price)} (Harga normal ${formatRupiahStory(v.original_price)}, auto hemat ${formatRupiahStory(saveAmt)}!)`,
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

function renderStoryCanvas() {
    if (!currentStoryProduct || !storyCanvas) return;
    const ctx = storyCanvas.getContext('2d');
    const renderId = ++currentStoryRenderId;
    const theme = getActiveStoryTheme();

    const vIdx = parseInt(storyVariantSelect.value, 10) || 0;
    const variant = currentStoryProduct.variants[vIdx] || currentStoryProduct.variants[0];
    const photoUrl = storyPhotoSelect.value || currentStoryProduct.images[0];
    const showSpecs = storyIncludeSpecs.checked;

    storyLoading?.classList.remove('d-none');
    storyCorsNotice?.classList.add('d-none');

    // 1. Base Background
    ctx.fillStyle = theme.canvasBg;
    ctx.fillRect(0, 0, 1080, 1920);

    // 2. Outer Frame
    ctx.lineWidth = 14;
    ctx.strokeStyle = theme.frameBorder;
    ctx.strokeRect(36, 36, 1008, 1848);

    // 3. Top Header Bar
    ctx.fillStyle = '#111111';
    ctx.fillRect(66, 66, 948, 140);
    ctx.fillStyle = theme.headerBg;
    ctx.fillRect(60, 60, 948, 140);
    ctx.lineWidth = 4;
    ctx.strokeStyle = '#111111';
    ctx.strokeRect(60, 60, 948, 140);

    // Logo Toko (Foto Upload atau Fallback Badge JC)
    if (STORE_LOGO && (!storeLogoImg || !storeLogoImg.complete)) {
        if (!storeLogoImg) {
            storeLogoImg = new Image();
            storeLogoImg.onload = () => {
                if (currentStoryProduct) renderStoryCanvas();
            };
            storeLogoImg.src = STORE_LOGO;
        }
    }

    if (storeLogoImg && storeLogoImg.complete && storeLogoImg.naturalWidth > 0) {
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(80, 80, 100, 100);
        ctx.lineWidth = 3;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(80, 80, 100, 100);

        const maxLogoW = 90;
        const maxLogoH = 90;
        const lw = storeLogoImg.naturalWidth;
        const lh = storeLogoImg.naturalHeight;
        const lScale = Math.min(maxLogoW / lw, maxLogoH / lh);
        const lDrawW = lw * lScale;
        const lDrawH = lh * lScale;
        const lDrawX = 80 + (100 - lDrawW) / 2;
        const lDrawY = 80 + (100 - lDrawH) / 2;
        ctx.drawImage(storeLogoImg, lDrawX, lDrawY, lDrawW, lDrawH);
    } else {
        ctx.fillStyle = '#B87834';
        ctx.fillRect(80, 80, 100, 100);
        ctx.lineWidth = 3;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(80, 80, 100, 100);
        ctx.fillStyle = '#FFFFFF';
        ctx.font = "bold 44px 'Space Grotesk', sans-serif";
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('JC', 130, 132);
    }

    // Store Name & Theme Subtitle
    ctx.textAlign = 'left';
    ctx.textBaseline = 'alphabetic';
    ctx.fillStyle = theme.headerText;
    ctx.font = "bold 38px 'Space Grotesk', sans-serif";
    ctx.fillText(STORE_NAME.toUpperCase(), 200, 122, 660);
    ctx.fillStyle = theme.headerSubText;
    ctx.font = "bold 20px 'JetBrains Mono', monospace";
    ctx.fillText(theme.headerSub, 200, 158, 660);

    // Draw Theme Vector Ornament in Header Right
    if (typeof theme.drawOrnament === 'function') {
        theme.drawOrnament(ctx);
    }

    // 4. Category & Badge Strip
    ctx.fillStyle = '#111111';
    ctx.fillRect(66, 226, 948, 64);
    ctx.fillStyle = theme.stripBg;
    ctx.fillRect(60, 220, 948, 64);
    ctx.lineWidth = 4;
    ctx.strokeStyle = '#111111';
    ctx.strokeRect(60, 220, 948, 64);

    ctx.fillStyle = theme.stripText;
    ctx.font = "bold 24px 'JetBrains Mono', monospace";
    ctx.textAlign = 'left';
    ctx.textBaseline = 'alphabetic';
    ctx.fillText(('● ' + currentStoryProduct.category.toUpperCase() + '  |  ' + currentStoryProduct.badge.toUpperCase()), 84, 260, 540);
    ctx.textAlign = 'right';
    ctx.fillText(theme.rightStripTag, 984, 260, 360);

    function drawPhotoBox(imgObj) {
        if (renderId !== currentStoryRenderId) return;

        // Shadow box
        ctx.fillStyle = '#111111';
        ctx.fillRect(68, 308, 948, 640);
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(60, 300, 948, 640);
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(60, 300, 948, 640);

        if (imgObj) {
            try {
                const targetX = 68;
                const targetY = 308;
                const targetW = 932;
                const targetH = 624;

                const imgW = imgObj.naturalWidth || imgObj.width;
                const imgH = imgObj.naturalHeight || imgObj.height;
                const scale = Math.min(targetW / imgW, targetH / imgH);
                const dw = imgW * scale;
                const dh = imgH * scale;
                const dx = targetX + (targetW - dw) / 2;
                const dy = targetY + (targetH - dh) / 2;

                ctx.drawImage(imgObj, dx, dy, dw, dh);
            } catch (e) {
                drawFallbackGraphic();
            }
        } else {
            drawFallbackGraphic();
        }

        if (currentStoryProduct.isSoldOut) {
            ctx.fillStyle = '#DC2626';
            ctx.fillRect(60, 310, 340, 60);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(60, 310, 340, 60);
            ctx.fillStyle = '#FFFFFF';
            ctx.font = "bold 32px 'Space Grotesk', sans-serif";
            ctx.textAlign = 'center';
            ctx.fillText('SOLD OUT', 230, 352);
        }

        drawProductInfo();
        storyLoading?.classList.add('d-none');
    }

    function drawFallbackGraphic() {
        ctx.fillStyle = '#F3ECE1';
        ctx.fillRect(68, 308, 932, 624);
        ctx.fillStyle = '#825514';
        ctx.font = "bold 34px 'Space Grotesk', sans-serif";
        ctx.textAlign = 'center';
        ctx.fillText(currentStoryProduct.name, 534, 600);
        ctx.fillStyle = '#57534E';
        ctx.font = "bold 24px 'JetBrains Mono', monospace";
        ctx.fillText(currentStoryProduct.brand + ' • ' + currentStoryProduct.category, 534, 645);
    }

    function drawProductInfo() {
        // Brand
        ctx.textAlign = 'left';
        ctx.fillStyle = theme.brandColor;
        ctx.font = "bold 26px 'JetBrains Mono', monospace";
        ctx.fillText(currentStoryProduct.brand.toUpperCase() + ' ORIGINAL', 64, 985);

        // Name with wrapping (max 2 lines)
        ctx.fillStyle = theme.titleColor;
        ctx.font = "bold 48px 'Space Grotesk', sans-serif";
        const words = currentStoryProduct.name.split(' ');
        let line = '';
        let y = 1045;
        let lineCount = 0;
        for (let i = 0; i < words.length; i++) {
            const testLine = line + words[i] + ' ';
            const metrics = ctx.measureText(testLine);
            if (metrics.width > 940 && i > 0) {
                ctx.fillText(line.trim(), 64, y);
                line = words[i] + ' ';
                y += 58;
                lineCount++;
                if (lineCount >= 1) break;
            } else {
                line = testLine;
            }
        }
        if (line.trim()) {
            ctx.fillText(line.trim(), 64, y);
        }

        // Specs Chips
        if (showSpecs && currentStoryProduct.specs.length > 0) {
            let specX = 64;
            let specY = y + 42;
            ctx.font = "bold 22px 'JetBrains Mono', monospace";
            currentStoryProduct.specs.slice(0, 3).forEach((sp) => {
                const spWidth = ctx.measureText(sp).width + 36;
                if (specX + spWidth < 1000) {
                    ctx.fillStyle = '#111111';
                    ctx.fillRect(specX + 4, specY + 4, spWidth, 44);
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(specX, specY, spWidth, 44);
                    ctx.lineWidth = 2.5;
                    ctx.strokeStyle = '#111111';
                    ctx.strokeRect(specX, specY, spWidth, 44);
                    ctx.fillStyle = '#1A1A1A';
                    ctx.textAlign = 'left';
                    ctx.fillText(sp, specX + 18, specY + 30);
                    specX += spWidth + 14;
                }
            });
        }

        // Price Box
        const priceBoxY = 1250;
        ctx.fillStyle = '#111111';
        ctx.fillRect(68, priceBoxY + 8, 948, 310);
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(60, priceBoxY, 948, 310);
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(60, priceBoxY, 948, 310);

        // Header variant bar
        ctx.fillStyle = theme.variantBarBg;
        ctx.fillRect(60, priceBoxY, 948, 56);
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(60, priceBoxY, 948, 56);
        ctx.fillStyle = theme.variantBarText;
        ctx.font = "bold 24px 'JetBrains Mono', monospace";
        ctx.textAlign = 'left';
        ctx.fillText(('VARIAN: ' + variant.label).substring(0, 52), 80, priceBoxY + 37);

        // Original price & hemat badge
        ctx.fillStyle = '#57534E';
        ctx.font = "bold 28px 'JetBrains Mono', monospace";
        const origText = 'Normal: ' + formatRupiahStory(variant.original_price);
        ctx.fillText(origText, 80, priceBoxY + 115);
        const origWidth = ctx.measureText(origText).width;
        ctx.strokeStyle = '#57534E';
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(76, priceBoxY + 105);
        ctx.lineTo(84 + origWidth, priceBoxY + 105);
        ctx.stroke();

        // Hemat badge
        const saveAmount = Math.max(0, variant.original_price - variant.promo_price);
        if (saveAmount > 0) {
            ctx.fillStyle = '#111111';
            ctx.fillRect(688, priceBoxY + 80, 296, 46);
            ctx.fillStyle = theme.hematBg;
            ctx.fillRect(684, priceBoxY + 76, 296, 46);
            ctx.lineWidth = 2.5;
            ctx.strokeStyle = '#111111';
            ctx.strokeRect(684, priceBoxY + 76, 296, 46);
            ctx.fillStyle = theme.hematText;
            ctx.font = "bold 22px 'JetBrains Mono', monospace";
            ctx.textAlign = 'center';
            ctx.fillText('HEMAT ' + formatRupiahStory(saveAmount), 832, priceBoxY + 107);
        }

        // Promo Price Banner
        ctx.fillStyle = '#111111';
        ctx.fillRect(82, priceBoxY + 154, 908, 130);
        ctx.fillStyle = theme.promoBg;
        ctx.fillRect(76, priceBoxY + 148, 908, 130);
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(76, priceBoxY + 148, 908, 130);

        ctx.fillStyle = theme.promoText;
        ctx.textAlign = 'left';
        ctx.font = "bold 26px 'Space Grotesk', sans-serif";
        ctx.fillText(theme.promoHeading, 102, priceBoxY + 192);
        ctx.font = "bold 64px 'Space Grotesk', sans-serif";
        ctx.fillText(formatRupiahStory(variant.promo_price), 102, priceBoxY + 256);
        ctx.textAlign = 'right';
        ctx.font = "bold 24px 'JetBrains Mono', monospace";
        ctx.fillText(currentStoryProduct.isSoldOut ? 'STOK HABIS' : 'READY TOKO', 952, priceBoxY + 226);

        // Footer CTA
        const footerY = 1600;
        ctx.fillStyle = '#111111';
        ctx.fillRect(68, footerY + 8, 948, 240);
        ctx.fillStyle = theme.footerBg;
        ctx.fillRect(60, footerY, 948, 240);
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#111111';
        ctx.strokeRect(60, footerY, 948, 240);

        ctx.fillStyle = '#1A1A1A';
        ctx.textAlign = 'left';
        ctx.font = "bold 26px 'JetBrains Mono', monospace";
        ctx.fillText('CARA ORDER & KONSULTASI VIA WHATSAPP:', 86, footerY + 52);

        ctx.fillStyle = theme.waColor;
        ctx.font = "bold 56px 'Space Grotesk', sans-serif";
        ctx.fillText('+ ' + STORE_WA, 86, footerY + 118);

        ctx.fillStyle = '#1A1A1A';
        ctx.font = "bold 22px 'Work Sans', sans-serif";
        ctx.fillText(STORE_ADDRESS, 86, footerY + 168, 900);

        ctx.fillStyle = '#57534E';
        ctx.font = "bold 20px 'JetBrains Mono', monospace";
        ctx.fillText(theme.footerNote, 86, footerY + 210, 900);
    }

    if (photoUrl && photoUrl !== '/images/placeholder.jpg') {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
            drawPhotoBox(img);
        };
        img.onerror = () => {
            storyCorsNotice?.classList.remove('d-none');
            drawPhotoBox(null);
        };
        img.src = photoUrl;
    } else {
        drawPhotoBox(null);
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
            images: rawImages.length ? rawImages : ['/images/placeholder.jpg'],
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
        currentStoryProduct.images.forEach((imgUrl, idx) => {
            const opt = document.createElement('option');
            opt.value = imgUrl;
            opt.textContent = `Foto ${idx + 1} (${imgUrl.startsWith('/uploads/') ? 'Upload Lokal' : 'Web/URL'})`;
            storyPhotoSelect.appendChild(opt);
        });

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
</script>
</body>
</html>
