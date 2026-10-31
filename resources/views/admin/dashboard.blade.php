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
    </style>
</head>
<body>
<nav class="navbar brutal-nav py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="fw-bold font-headline fs-5">Dashboard Admin — {{ $catalog['store_name'] }}</div>
        <div class="d-flex gap-2">
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
                        <button type="submit" class="btn btn-success btn-sm px-4 py-2">Simpan Produk</button>
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

document.getElementById('f-photos')?.addEventListener('change', (e) => {
    const preview = document.getElementById('photo-preview');
    preview.innerHTML = '';
    Array.from(e.target.files || []).forEach((file) => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.cssText = 'width:56px;height:56px;object-fit:cover;border:2px solid #111111;';
        preview.appendChild(img);
    });
});

document.querySelectorAll('.edit-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
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
</script>
</body>
</html>
