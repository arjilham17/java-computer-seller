<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $catalog['store_name'] }} — Promo Laptop, PC, Printer, Monitor & Aksesoris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; color: #0f172a; }
        .hero-section { background: linear-gradient(180deg, #eff6ff 0%, #f8fafc 100%); }
        .product-img { height: 200px; object-fit: cover; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
            @if (!empty($catalog['logo']))
                <img src="{{ $catalog['logo'] }}" alt="Logo {{ $catalog['store_name'] }}" style="height: 40px; width: auto;">
            @else
                <span class="badge text-bg-primary p-2">JC</span>
            @endif
            <div>
                <div class="lh-1">{{ $catalog['store_name'] }}</div>
                <small class="text-secondary fw-normal" style="font-size: 0.75rem;">Laptop • PC • Printer • Monitor • Aksesoris</small>
            </div>
        </a>
        <div class="d-flex align-items-center gap-2">
            <a class="btn btn-success fw-semibold btn-sm px-3 py-2"
               href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya ingin konsultasi perangkat komputer.') }}"
               target="_blank" rel="noopener">
                Chat Admin WhatsApp
            </a>
        </div>
    </div>
</nav>

<section class="hero-section py-5 border-bottom">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge rounded-pill text-bg-primary mb-3 px-3 py-2">PROMO TERBATAS MINGGU INI</span>
                <h1 class="display-6 fw-bold mb-3">Perangkat Komputer Bergaransi, Spesifikasi Jelas, Siap Pakai.</h1>
                <p class="text-secondary fs-5 mb-4">
                    Pilih Laptop, PC Rakitan, Printer, Monitor, dan Aksesoris sesuai kebutuhan kerja, kuliah, atau bisnis Anda. Pilih spesifikasi, tentukan jumlah, dan pesan langsung lewat WhatsApp.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#katalog" class="btn btn-primary btn-lg px-4 fw-semibold">Lihat Katalog Promo</a>
                    <a id="hero-wa-cta"
                       href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya tertarik dengan Flash Deal ' . $catalog['hero_deal']['title']) }}"
                       target="_blank" rel="noopener"
                       class="btn btn-outline-dark btn-lg px-4 fw-semibold">
                        Ambil Promo Unggulan via WA
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-primary border-2 shadow-sm rounded-4 p-4">
                    <span class="badge text-bg-danger align-self-start mb-2">{{ $catalog['hero_deal']['badge'] }}</span>
                    <h2 class="h4 fw-bold mb-1">{{ $catalog['hero_deal']['title'] }}</h2>
                    <p class="text-secondary small mb-3">{{ $catalog['hero_deal']['subtitle'] }}</p>
                    <div class="bg-light border rounded-3 p-3 mb-3">
                        <div class="text-secondary text-decoration-line-through small">
                            Rp {{ number_format($catalog['hero_deal']['original_price'], 0, ',', '.') }}
                        </div>
                        <div class="fs-3 fw-bold text-primary">
                            Rp {{ number_format($catalog['hero_deal']['promo_price'], 0, ',', '.') }}
                        </div>
                        <div class="text-success small fw-semibold">{{ $catalog['hero_deal']['bonus'] }}</div>
                    </div>
                    <a href="#katalog" class="btn btn-dark w-100 fw-semibold py-2">Pilih Varian & Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="katalog" class="py-5">
    <div class="container">
        <div class="row align-items-end justify-content-between g-3 mb-4">
            <div class="col-md-7">
                <h2 class="h3 fw-bold mb-1">Katalog Promo & Varian Spesifikasi</h2>
                <p class="text-secondary mb-0">Pilih varian spesifikasi (RAM/SSD/Tipe) untuk melihat harga promo terbaru.</p>
            </div>
            <div class="col-md-5">
                <input type="search" id="search-input" class="form-control" placeholder="Cari merek atau spesifikasi (ASUS, Epson, i5, SSD)...">
            </div>
        </div>

        <ul class="nav nav-pills gap-2 mb-4" id="category-tabs">
            @foreach ($catalog['categories'] as $idx => $cat)
                <li class="nav-item">
                    <button type="button"
                            class="nav-link {{ $idx === 0 ? 'active' : 'bg-white border text-dark' }} fw-semibold"
                            data-category="{{ $cat }}">
                        {{ $cat }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="row g-4" id="product-grid">
            @foreach ($catalog['products'] as $product)
                @php
                    $firstVariant = $product['variants'][0];
                    $initialSave = $firstVariant['original_price'] - $firstVariant['promo_price'];
                    $initialText = implode("\n", [
                        "Halo {$catalog['store_name']}, saya ingin memesan:",
                        "- Produk: {$product['name']} ({$product['brand']})",
                        "- Varian/Spesifikasi: {$firstVariant['label']}",
                        "- Harga Promo: Rp " . number_format($firstVariant['promo_price'], 0, ',', '.') . " / unit",
                        "- Jumlah: 1 unit",
                        "- Total Estimasi: Rp " . number_format($firstVariant['promo_price'], 0, ',', '.'),
                        "Apakah stok promo ini masih tersedia?",
                    ]);
                @endphp
                <div class="col-md-6 col-lg-4 product-col"
                     data-category="{{ $product['category'] }}"
                     data-search="{{ strtolower($product['name'] . ' ' . $product['brand'] . ' ' . implode(' ', array_column($product['variants'], 'label'))) }}">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden product-card"
                         data-name="{{ $product['name'] }}"
                         data-brand="{{ $product['brand'] }}"
                         data-variants='@json($product['variants'])'>
                        @php
                            $images = $product['images'] ?? [$product['image']];
                            $carouselId = 'carousel-' . $product['id'];
                        @endphp
                        <div class="position-relative bg-light">
                            <span class="badge text-bg-dark position-absolute top-0 start-0 m-3 z-2">{{ $product['badge'] }}</span>
                            @if (count($images) > 1)
                                <div id="{{ $carouselId }}" class="carousel slide">
                                    <div class="carousel-inner">
                                        @foreach ($images as $imgIdx => $imgUrl)
                                            <div class="carousel-item {{ $imgIdx === 0 ? 'active' : '' }}">
                                                <img src="{{ $imgUrl }}" class="d-block w-100 product-img" alt="{{ $product['name'] }} ({{ $imgIdx + 1 }})" loading="lazy">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2 bg-opacity-50" aria-hidden="true"></span>
                                        <span class="visually-hidden">Sebelumnya</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2 bg-opacity-50" aria-hidden="true"></span>
                                        <span class="visually-hidden">Berikutnya</span>
                                    </button>
                                </div>
                            @else
                                <img src="{{ $images[0] }}" class="card-img-top product-img" alt="{{ $product['name'] }}" loading="lazy">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="text-secondary small mb-1">{{ $product['category'] }} • <strong>{{ $product['brand'] }}</strong></div>
                            <h3 class="h5 fw-bold mb-2">{{ $product['name'] }}</h3>
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @foreach ($product['specs'] as $spec)
                                    <span class="badge text-bg-light border text-secondary fw-normal">{{ $spec }}</span>
                                @endforeach
                            </div>

                            <label class="form-label small fw-semibold text-secondary mb-1">Pilih Varian Spesifikasi</label>
                            <select class="form-select form-select-sm mb-3 variant-select">
                                @foreach ($product['variants'] as $vIdx => $variant)
                                    <option value="{{ $vIdx }}">{{ $variant['label'] }}</option>
                                @endforeach
                            </select>

                            <div class="d-flex align-items-center justify-content-between mb-3 mt-auto">
                                <div>
                                    <div class="text-secondary text-decoration-line-through small" data-role="original">
                                        Rp {{ number_format($firstVariant['original_price'], 0, ',', '.') }}
                                    </div>
                                    <div class="fs-5 fw-bold text-primary" data-role="promo">
                                        Rp {{ number_format($firstVariant['promo_price'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-semibold" data-role="save">
                                    Hemat Rp {{ number_format($initialSave, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <div class="input-group input-group-sm" style="width: 105px;">
                                    <span class="input-group-text">Qty</span>
                                    <input type="number" class="form-control text-center fw-bold qty-input" min="1" max="50" value="1">
                                </div>
                                <a href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode($initialText) }}"
                                   target="_blank" rel="noopener"
                                   class="btn btn-success fw-semibold flex-grow-1 btn-sm d-flex align-items-center justify-content-center"
                                   data-role="wa-link">
                                    Pesan via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<footer class="bg-white border-top py-4 mt-4">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3 text-secondary small">
        <div>
            <strong class="text-dark">{{ $catalog['store_name'] }}</strong> — {{ $catalog['tagline'] }}
        </div>
        <div class="d-flex align-items-center gap-3">
            <span>{{ $catalog['address'] }} • {{ $catalog['hours'] }}</span>
            <a href="/admin" class="text-secondary text-decoration-none">Admin</a>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const storeName = @json($catalog['store_name']);
    const waPhone = @json($catalog['whatsapp_number']);
    const formatRp = (n) => 'Rp ' + Math.round(Number(n) || 0).toLocaleString('id-ID');

    document.querySelectorAll('.product-card').forEach((card) => {
        const variants = JSON.parse(card.dataset.variants || '[]');
        const selectEl = card.querySelector('.variant-select');
        const qtyEl = card.querySelector('.qty-input');
        const origEl = card.querySelector('[data-role="original"]');
        const promoEl = card.querySelector('[data-role="promo"]');
        const saveEl = card.querySelector('[data-role="save"]');
        const waLink = card.querySelector('[data-role="wa-link"]');

        const syncCard = () => {
            const variant = variants[Number(selectEl.value) || 0];
            const qty = Math.max(1, parseInt(qtyEl.value, 10) || 1);
            origEl.textContent = formatRp(variant.original_price);
            promoEl.textContent = formatRp(variant.promo_price);
            saveEl.textContent = 'Hemat ' + formatRp(variant.original_price - variant.promo_price);

            const text = [
                `Halo ${storeName}, saya ingin memesan:`,
                `- Produk: ${card.dataset.name} (${card.dataset.brand})`,
                `- Varian/Spesifikasi: ${variant.label}`,
                `- Harga Promo: ${formatRp(variant.promo_price)} / unit`,
                `- Jumlah: ${qty} unit`,
                `- Total Estimasi: ${formatRp(variant.promo_price * qty)}`,
                `Apakah stok promo ini masih tersedia?`
            ].join('\n');
            waLink.href = `https://wa.me/${waPhone}?text=${encodeURIComponent(text)}`;
        };

        selectEl.addEventListener('change', syncCard);
        qtyEl.addEventListener('input', syncCard);
    });

    let activeCat = 'Semua';
    const searchInput = document.getElementById('search-input');
    const cols = document.querySelectorAll('.product-col');
    const applyFilter = () => {
        const q = (searchInput.value || '').trim().toLowerCase();
        cols.forEach((col) => {
            const matchCat = activeCat === 'Semua' || col.dataset.category === activeCat;
            const matchQ = !q || col.dataset.search.includes(q);
            col.classList.toggle('d-none', !(matchCat && matchQ));
        });
    };

    document.querySelectorAll('#category-tabs button').forEach((btn) => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('#category-tabs button').forEach((b) => {
                b.className = 'nav-link bg-white border text-dark fw-semibold';
            });
            btn.className = 'nav-link active fw-semibold';
            activeCat = btn.dataset.category;
            applyFilter();
        });
    });

    searchInput.addEventListener('input', applyFilter);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
