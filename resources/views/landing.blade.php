@php
    $hero = $catalog['hero_deal'];
    $heroSave = max(0, (int) ($hero['original_price'] ?? 0) - (int) ($hero['promo_price'] ?? 0));
    $heroSpecs = array_filter(array_map('trim', explode('•', (string) ($hero['subtitle'] ?? ''))));
    $products = $catalog['products'] ?? [];
    $heroTitleLower = mb_strtolower((string) ($hero['title'] ?? ''));

    $resolveProductImages = static function (array $product): array {
        return array_values(array_filter($product['images'] ?? [$product['image'] ?? '']));
    };

    $heroImage = null;
    foreach ($products as $candidate) {
        $imgs = $resolveProductImages($candidate);
        if (empty($imgs)) {
            continue;
        }
        $candName = mb_strtolower((string) ($candidate['name'] ?? ''));
        $candPrefix = implode(' ', array_slice(preg_split('/\s+/', trim($candName)) ?: [], 0, 2));
        if ($heroTitleLower !== '' && $candName !== '' && (str_contains($heroTitleLower, $candName) || str_contains($candName, $heroTitleLower) || ($candPrefix !== '' && str_contains($heroTitleLower, $candPrefix)))) {
            $heroImage = $imgs[0];
            break;
        }
    }
    if (!$heroImage) {
        foreach ($products as $candidate) {
            if (!empty($candidate['is_sold_out'])) {
                continue;
            }
            $imgs = $resolveProductImages($candidate);
            if (!empty($imgs)) {
                $heroImage = $imgs[0];
                break;
            }
        }
    }
    if (!$heroImage) {
        foreach ($products as $candidate) {
            $imgs = $resolveProductImages($candidate);
            if (!empty($imgs)) {
                $heroImage = $imgs[0];
                break;
            }
        }
    }

    $heroWaText = "Halo {$catalog['store_name']}, saya ingin mengklaim Flash Deal {$hero['title']} ({$hero['subtitle']}) seharga Rp " . number_format((int) $hero['promo_price'], 0, ',', '.') . ". Apakah stok masih tersedia?";
    $totalProducts = count($products);
    $readyCount = count(array_filter($products, static fn(array $p): bool => empty($p['is_sold_out'])));
    $categoryCounts = [];
    foreach ($products as $p) {
        $catName = $p['category'] ?? '';
        if ($catName !== '') {
            $categoryCounts[$catName] = ($categoryCounts[$catName] ?? 0) + 1;
        }
    }
    $activeCategoriesCount = max(0, count(array_filter($catalog['categories'] ?? [], static fn($c) => $c !== 'Semua')));
    $trustStats = $catalog['trust_stats'] ?? [
        ['value' => '{ready_count} Unit', 'label' => 'Ready Stock Katalog'],
        ['value' => '{category_count} Kategori', 'label' => 'Pilihan Hardware'],
        ['value' => '7 Hari', 'label' => 'Garansi Tukar Baru'],
        ['value' => 'Gratis OS', 'label' => 'Setup Siap Pakai'],
    ];
    $heroBadges = $catalog['hero_badges'] ?? [
        ['title' => 'Garansi Jelas', 'desc' => 'Garansi resmi distributor dan tukar baru toko 30 hari.', 'icon' => 'verified'],
        ['title' => 'Konsultasi 1-on-1', 'desc' => 'Konsultasi spek dan budget langsung dengan teknisi.', 'icon' => 'support_agent'],
        ['title' => 'Kirim atau Ambil', 'desc' => 'Cek unit di workshop atau kirim packing kayu aman.', 'icon' => 'local_shipping'],
    ];
    $statVars = [
        '{ready_count}' => (string) $readyCount,
        '{total_count}' => (string) $totalProducts,
        '{category_count}' => (string) $activeCategoriesCount,
    ];
    $hasSocialLinks = !empty($catalog['instagram_url']) || !empty($catalog['tiktok_url']) || !empty($catalog['facebook_url']);

    $rawMetaImage = !empty($catalog['logo']) ? $catalog['logo'] : ($heroImage ?: '/apple-touch-icon.png');
    $metaImageUrl = str_starts_with($rawMetaImage, 'http') ? $rawMetaImage : url($rawMetaImage);
    $metaDescription = "{$catalog['store_name']}: {$catalog['tagline']}. Pilih varian spek, cek stok ready, dan pesan langsung via WhatsApp tanpa daftar akun.";
    $mapLink = $catalog['map_link'] ?? 'https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_standard" name="shell-type" />
    <title>{{ $catalog['store_name'] }} | {{ $catalog['tagline'] }}</title>
    <meta name="description" content="{{ $metaDescription }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $catalog['store_name'] }} | {{ $catalog['tagline'] }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:image" content="{{ $metaImageUrl }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="icon" type="image/x-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.ico' }}" />
    <link rel="icon" type="image/svg+xml" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.svg' }}" />
    <link rel="apple-touch-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/apple-touch-icon.png' }}" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@600;700&amp;family=Space+Grotesk:wght@600;700&amp;family=Work+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Bootstrap 5.3.3 for Carousel & base utilities -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "wood-ochre-dark": "#B87834",
                        "on-primary-fixed-variant": "#663e00",
                        "on-error-container": "#93000a",
                        "background": "#fcf9f3",
                        "error": "#ba1a1a",
                        "secondary-container": "#e5e2e1",
                        "on-secondary": "#ffffff",
                        "outline-variant": "#d5c4b4",
                        "surface-tint": "#825514",
                        "on-primary": "#ffffff",
                        "outline": "#837567",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#6bff8f",
                        "surface-container": "#f0eee8",
                        "surface": "#fcf9f3",
                        "surface-variant": "#e5e2dc",
                        "strike-muted": "#5C554F",
                        "inverse-surface": "#31312d",
                        "tertiary-fixed-dim": "#4ae176",
                        "on-surface": "#1c1c18",
                        "wood-ochre-light": "#E5AC67",
                        "inverse-on-surface": "#f3f0ea",
                        "primary-container": "#d49b55",
                        "tertiary": "#006e2f",
                        "on-tertiary-container": "#00461b",
                        "on-secondary-fixed-variant": "#474646",
                        "primary-fixed": "#ffddb9",
                        "on-secondary-container": "#656464",
                        "secondary": "#5f5e5e",
                        "whatsapp-green": "#22C55E",
                        "on-tertiary": "#ffffff",
                        "inverse-primary": "#f8bb72",
                        "surface-container-low": "#f6f3ed",
                        "surface-bright": "#fcf9f3",
                        "slate-charcoal": "#1A1A1A",
                        "primary": "#825514",
                        "on-surface-variant": "#504539",
                        "whatsapp-green-dark": "#16A34A",
                        "surface-container-high": "#ebe8e2",
                        "on-primary-fixed": "#2b1700",
                        "error-container": "#ffdad6",
                        "surface-container-highest": "#e5e2dc",
                        "canvas-border": "#111111",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed-variant": "#005321",
                        "primary-fixed-dim": "#f8bb72",
                        "tertiary-container": "#14bf59",
                        "canvas-cream": "#F3ECE1",
                        "on-primary-container": "#563400",
                        "on-secondary-fixed": "#1c1b1b",
                        "secondary-fixed": "#e5e2e1",
                        "on-tertiary-fixed": "#002109",
                        "surface-dim": "#dcdad4",
                        "danger-coral": "#EF4444",
                        "secondary-fixed-dim": "#c8c6c5",
                        "on-background": "#1c1c18"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "space-xl": "2.5rem",
                        "space-lg": "1.5rem",
                        "space-xs": "0.25rem",
                        "gutter": "1.5rem",
                        "space-md": "1rem",
                        "margin-mobile": "1rem",
                        "margin": "2rem",
                        "gutter-mobile": "0.875rem",
                        "space-sm": "0.5rem"
                    },
                    fontFamily: {
                        "label-code": ["JetBrains Mono", "monospace"],
                        "headline-md": ["Space Grotesk", "sans-serif"],
                        "headline-lg-mobile": ["Space Grotesk", "sans-serif"],
                        "price-hero": ["Space Grotesk", "sans-serif"],
                        "headline-sm": ["Space Grotesk", "sans-serif"],
                        "display-mobile": ["Space Grotesk", "sans-serif"],
                        "display": ["Space Grotesk", "sans-serif"],
                        "price-catalog": ["Space Grotesk", "sans-serif"],
                        "label-spec": ["JetBrains Mono", "monospace"],
                        "body-md": ["Work Sans", "sans-serif"],
                        "body-sm": ["Work Sans", "sans-serif"],
                        "body-lg": ["Work Sans", "sans-serif"],
                        "headline-lg": ["Space Grotesk", "sans-serif"]
                    },
                    fontSize: {
                        "label-code": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "30px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-lg-mobile": ["26px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "price-hero": ["28px", { "lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-sm": ["20px", { "lineHeight": "26px", "fontWeight": "600" }],
                        "display-mobile": ["34px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "display": ["48px", { "lineHeight": "54px", "letterSpacing": "-0.03em", "fontWeight": "700" }],
                        "price-catalog": ["22px", { "lineHeight": "26px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "label-spec": ["11px", { "lineHeight": "14px", "letterSpacing": "0.06em", "fontWeight": "700" }],
                        "body-md": ["15px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "body-sm": ["13px", { "lineHeight": "20px", "fontWeight": "500" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }]
                    }
                }
            }
        };
    </script>
    <style>
        @layer base {

            html,
            body {
                margin: 0;
                padding: 0;
                scroll-behavior: smooth;
            }

            body {
                overscroll-behavior: none;
                background-color: #fcf9f3;
                color: #1c1c18;
            }

            a {
                text-decoration: none;
            }

            a[href],
            button:not(:disabled),
            select:not(:disabled),
            input[type="checkbox"]:not(:disabled),
            summary,
            label[for] {
                cursor: pointer;
            }

            button:disabled,
            select:disabled {
                cursor: not-allowed;
            }

            a:focus-visible,
            button:focus-visible,
            input:focus-visible,
            select:focus-visible {
                outline: 3px solid #111111;
                outline-offset: 2px;
            }

            main> :first-child {
                margin-top: 0 !important;
            }

            main> :last-child {
                margin-bottom: 0 !important;
            }
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            scrollbar-width: none;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .brutal-marquee {
            display: flex;
            width: max-content;
            will-change: transform;
            animation: marquee 28s linear infinite;
        }
    </style>
</head>

<body
    class="bg-surface font-body-md text-on-surface antialiased selection:bg-primary-container selection:text-on-primary-container">

    <a href="#katalog"
        class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[60] focus:px-4 focus:py-2.5 focus:bg-wood-ochre-light focus:text-slate-charcoal focus:border-2 focus:border-canvas-border focus:shadow-[3px_3px_0px_#111111] font-headline-sm font-bold uppercase text-body-sm">
        Lewati ke Katalog Produk
    </a>

    <!-- STICKY HEADER / NAVBAR (Brutal Hardware Ochre) -->
    <header
        class="fixed top-0 left-0 right-0 z-50 bg-canvas-cream border-b-[3px] border-canvas-border shadow-[0_4px_0px_#111111]">
        <div
            class="min-h-[68px] lg:min-h-[80px] py-2 max-w-[1320px] mx-auto px-margin-mobile lg:px-margin flex items-center justify-between gap-2 sm:gap-space-md">
            <div class="flex items-center gap-space-sm sm:gap-space-md min-w-0">
                @if (!empty($catalog['logo']))
                    <img src="{{ $catalog['logo'] }}" alt="Logo {{ $catalog['store_name'] }}" width="40" height="40"
                        class="h-10 w-10 shrink-0 object-contain border-2 border-canvas-border shadow-[2px_2px_0px_#111111] bg-surface-container-lowest p-0.5" />
                @else
                    <span
                        class="badge bg-primary text-on-primary font-headline-sm font-bold border-2 border-canvas-border shadow-[2px_2px_0px_#111111] rounded-none px-2.5 py-2 shrink-0">JC</span>
                @endif
                <div class="flex flex-col min-w-0">
                    <a class="font-headline-md text-[18px] sm:text-headline-md tracking-tight font-bold text-slate-charcoal hover:text-primary transition-colors uppercase truncate"
                        href="/">{{ $catalog['store_name'] }}</a>
                    <span
                        class="hidden md:inline-block font-label-spec text-label-spec text-on-surface-variant font-bold uppercase tracking-wider">Laptop
                        • PC • Printer • Monitor • Aksesoris</span>
                </div>
            </div>
            <nav class="hidden lg:flex items-center gap-space-md" aria-label="Navigasi utama">
                <a class="px-3 py-2 min-h-[44px] inline-flex items-center bg-wood-ochre-light text-on-surface border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold transition-all uppercase"
                    href="#promo">PROMO</a>
                <a class="px-3 py-2 min-h-[44px] inline-flex items-center text-on-surface-variant hover:text-on-surface hover:bg-surface-variant font-headline-sm text-body-sm font-semibold transition-all uppercase"
                    href="#katalog">KATALOG</a>
                <a class="px-3 py-2 min-h-[44px] inline-flex items-center text-on-surface-variant hover:text-on-surface hover:bg-surface-variant font-headline-sm text-body-sm font-semibold transition-all uppercase"
                    href="#tentang-kami">TENTANG KAMI</a>
                <a class="px-3 py-2 min-h-[44px] inline-flex items-center text-on-surface-variant hover:text-on-surface hover:bg-surface-variant font-headline-sm text-body-sm font-semibold transition-all uppercase"
                    href="#kontak">KONTAK</a>
            </nav>
            <div class="flex items-center gap-2 shrink-0">
                @if(!empty($catalog['instagram_url']))
                    <a href="{{ $catalog['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="Instagram"
                        aria-label="Instagram {{ $catalog['store_name'] }}"
                        class="w-11 h-11 hidden lg:flex items-center justify-center bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                        <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.161-2.759 6.161-6.163c0-3.403-2.758-6.162-6.161-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                @endif
                @if(!empty($catalog['tiktok_url']))
                    <a href="{{ $catalog['tiktok_url'] }}" target="_blank" rel="noopener noreferrer" title="TikTok"
                        aria-label="TikTok {{ $catalog['store_name'] }}"
                        class="w-11 h-11 hidden lg:flex items-center justify-center bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                        <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.27 6.27 0 0 0 1.94-4.52V8.9a8.18 8.18 0 0 0 4.77 1.52V6.97a4.85 4.85 0 0 1-.94-.28z" />
                        </svg>
                    </a>
                @endif
                @if(!empty($catalog['facebook_url']))
                    <a href="{{ $catalog['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="Facebook"
                        aria-label="Facebook {{ $catalog['store_name'] }}"
                        class="w-11 h-11 hidden lg:flex items-center justify-center bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                        <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                @endif
                <button type="button" id="mobile-menu-btn" aria-expanded="false" aria-controls="mobile-nav-drawer"
                    aria-label="Buka menu navigasi"
                    class="lg:hidden inline-flex items-center justify-center gap-1 min-h-[44px] min-w-[44px] px-3 bg-surface-container-lowest text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold uppercase hover:bg-wood-ochre-light">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">menu</span>
                    <span>Menu</span>
                </button>
                <a class="inline-flex items-center justify-center min-h-[44px] px-3 sm:px-4 py-2 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[4px_4px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all tracking-wider"
                    href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya ingin konsultasi perangkat komputer.') }}"
                    rel="noopener noreferrer" target="_blank">
                    <span class="material-symbols-outlined text-[20px] sm:mr-1.5" aria-hidden="true">chat</span><span
                        class="hidden sm:inline">Chat Admin WA</span><span class="sm:hidden ml-1">WA</span>
                </a>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-nav-drawer"
            class="hidden lg:hidden bg-canvas-cream border-t-2 border-canvas-border px-margin-mobile py-4" role="region"
            aria-label="Menu navigasi mobile">
            <nav class="flex flex-col gap-2" aria-label="Tautan cepat mobile">
                <a class="mobile-nav-link min-h-[44px] px-3 py-2 bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold uppercase flex items-center justify-between"
                    href="#promo">
                    <span>Promo Flash Deal</span>
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                </a>
                <a class="mobile-nav-link min-h-[44px] px-3 py-2 bg-surface-container-lowest text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold uppercase flex items-center justify-between"
                    href="#katalog">
                    <span>Katalog Produk ({{ $totalProducts }})</span>
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                </a>
                <a class="mobile-nav-link min-h-[44px] px-3 py-2 bg-surface-container-lowest text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold uppercase flex items-center justify-between"
                    href="#tentang-kami">
                    <span>Keunggulan Toko</span>
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                </a>
                <a class="mobile-nav-link min-h-[44px] px-3 py-2 bg-surface-container-lowest text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold uppercase flex items-center justify-between"
                    href="#kontak">
                    <span>Lokasi Workshop &amp; FAQ</span>
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                </a>
            </nav>
            @if ($hasSocialLinks)
                <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-canvas-border">
                    @if(!empty($catalog['instagram_url']))
                        <a href="{{ $catalog['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                            class="min-h-[44px] px-3 py-2 bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-label-code text-label-code font-bold uppercase inline-flex items-center">Instagram</a>
                    @endif
                    @if(!empty($catalog['tiktok_url']))
                        <a href="{{ $catalog['tiktok_url'] }}" target="_blank" rel="noopener noreferrer"
                            class="min-h-[44px] px-3 py-2 bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-label-code text-label-code font-bold uppercase inline-flex items-center">TikTok</a>
                    @endif
                    @if(!empty($catalog['facebook_url']))
                        <a href="{{ $catalog['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                            class="min-h-[44px] px-3 py-2 bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-label-code text-label-code font-bold uppercase inline-flex items-center">Facebook</a>
                    @endif
                </div>
            @endif
        </div>
    </header>

    <main class="w-full pt-[72px] lg:pt-20 bg-surface min-h-[calc(100vh-80px)]">
        <div class="flex flex-col w-full">
            <!-- Ticker Tape / Announcement Marquee -->
            <div
                class="w-full bg-wood-ochre-light text-slate-charcoal overflow-hidden py-2.5 border-b-[2.5px] border-canvas-border shadow-[0_3px_0px_#111111] select-none">
                <div
                    class="brutal-marquee whitespace-nowrap font-label-code text-label-code uppercase font-bold tracking-wider">
                    <span class="pr-8 shrink-0">UNIT TERUJI &amp; GARANSI RESMI TOKO • GRATIS INSTALASI OS &amp; OFFICE
                        • KONSULTASI SPEK 1-ON-1 VIA WHATSAPP • READY STOCK LAPTOP &amp; PC RAKITAN • SIAP AMBIL DI TOKO
                        ATAU PACKING KAYU AMAN</span>
                    <span class="pr-8 shrink-0" aria-hidden="true">UNIT TERUJI &amp; GARANSI RESMI TOKO • GRATIS
                        INSTALASI OS &amp; OFFICE • KONSULTASI SPEK 1-ON-1 VIA WHATSAPP • READY STOCK LAPTOP &amp; PC
                        RAKITAN • SIAP AMBIL DI TOKO ATAU PACKING KAYU AMAN</span>
                </div>
            </div>

            <div class="max-w-[1320px] mx-auto px-margin-mobile lg:px-margin w-full">
                <!-- HERO SECTION (PRD 4.2) -->
                <section class="pt-8 pb-12 lg:pt-14 lg:pb-16" id="promo">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg lg:gap-gutter items-center">
                        <!-- Left Column: Value Prop & Messaging -->
                        <div class="lg:col-span-7 flex flex-col gap-5">
                            @if (!empty($hero['badge']))
                                <div
                                    class="inline-flex items-center gap-2 self-start px-3 py-1 bg-wood-ochre-light text-slate-charcoal border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111]">
                                    <span class="material-symbols-outlined text-[18px]"
                                        aria-hidden="true">local_fire_department</span>
                                    <span
                                        class="font-label-code text-label-code font-bold uppercase tracking-wider">{{ $hero['badge'] }}</span>
                                </div>
                            @endif
                            <h1
                                class="font-display text-display-mobile lg:text-display text-slate-charcoal font-bold leading-tight uppercase tracking-tight">
                                Upgrade Komputer &amp; Laptop <span
                                    class="bg-primary text-on-primary px-2 py-0.5 inline-block">Tanpa Ribet</span>,
                                Bergaransi Resmi.
                            </h1>
                            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                                {{ $catalog['tagline'] }}. Solusi hardware bagi Pelajar, Kantor, dan Gamer. Unit dicek
                                fisik sebelum serah terima, gratis instalasi sistem dasar, dan pemesanan langsung ke
                                admin via WhatsApp.
                            </p>
                            <!-- Brutalist Badges Checklist -->
                            @if (!empty($heroBadges))
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                                    @foreach ($heroBadges as $badgeItem)
                                        <div
                                            class="p-3 bg-canvas-cream border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111] flex flex-col gap-1">
                                            <div
                                                class="flex items-center gap-1.5 text-primary font-bold font-headline-sm text-body-sm uppercase">
                                                <span class="material-symbols-outlined text-[20px]"
                                                    aria-hidden="true">{{ $badgeItem['icon'] ?? 'verified' }}</span>
                                                <span>{{ $badgeItem['title'] }}</span>
                                            </div>
                                            @if (!empty($badgeItem['desc']))
                                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">
                                                    {{ $badgeItem['desc'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <!-- CTAs -->
                            <div class="flex flex-wrap items-center gap-4 pt-3">
                                <a class="inline-flex items-center justify-center min-h-[44px] px-6 py-3 bg-primary-container hover:bg-wood-ochre-light text-slate-charcoal font-headline-sm text-body-md font-bold uppercase border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all"
                                    href="#katalog">
                                    <span class="material-symbols-outlined mr-2"
                                        aria-hidden="true">inventory_2</span>Lihat Katalog Lengkap
                                </a>
                                <a class="inline-flex items-center justify-center min-h-[44px] px-6 py-3 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-md font-bold uppercase border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all"
                                    href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya ingin konsultasi spesifikasi komputer/laptop sesuai budget saya') }}"
                                    rel="noopener noreferrer" target="_blank">
                                    <span class="material-symbols-outlined mr-2" aria-hidden="true">chat</span>Tanya
                                    Admin WA
                                </a>
                            </div>
                        </div>

                        <!-- Right Column: Hero Spotlight Flash Deal Card -->
                        <div class="lg:col-span-5">
                            <div
                                class="bg-wood-ochre-dark p-2 border-[3px] border-canvas-border shadow-[6px_6px_0px_#111111]">
                                <div
                                    class="bg-surface-container-lowest p-5 border-[2px] border-canvas-border flex flex-col gap-4">
                                    <!-- Top Alert Bar -->
                                    <div
                                        class="flex items-center justify-between gap-2 border-b-[2px] border-canvas-border pb-3">
                                        <span
                                            class="px-2.5 py-1 bg-error text-on-error font-label-code text-label-code font-bold uppercase border border-canvas-border">
                                            STOK TERBATAS
                                        </span>
                                        @if ($heroSave > 0)
                                            <span
                                                class="px-2.5 py-1 bg-wood-ochre-light text-slate-charcoal font-label-code text-label-code font-bold uppercase border border-canvas-border">
                                                HEMAT RP {{ number_format($heroSave, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Product Visual Preview -->
                                    <div
                                        class="relative bg-canvas-cream border-[2px] border-canvas-border overflow-hidden p-3 flex flex-col items-center justify-center">
                                        <div
                                            class="w-full aspect-[4/3] bg-white border border-canvas-border relative overflow-hidden flex items-center justify-center">
                                            <div
                                                class="absolute top-2 left-2 z-10 px-2 py-0.5 bg-slate-charcoal text-surface text-[10px] font-label-code uppercase tracking-wider font-bold">
                                                FLASH DEAL
                                            </div>
                                            @if ($heroImage)
                                                <img class="w-full h-full object-contain p-2" alt="{{ $hero['title'] }}"
                                                    src="{{ $heroImage }}" width="800" height="600" fetchpriority="high" />
                                                <button type="button"
                                                    class="lightbox-trigger absolute bottom-2 right-2 z-10 min-h-[44px] min-w-[44px] px-2.5 py-1 bg-canvas-cream/95 hover:bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-label-spec text-label-spec font-bold uppercase inline-flex items-center gap-1"
                                                    data-lightbox-title="{{ $hero['title'] }}"
                                                    data-lightbox-images='@json([$heroImage])'
                                                    aria-label="Perbesar foto {{ $hero['title'] }}">
                                                    <span class="material-symbols-outlined text-[16px]"
                                                        aria-hidden="true">zoom_in</span>
                                                    <span>Zoom</span>
                                                </button>
                                            @else
                                                <div
                                                    class="w-full h-full bg-surface-container-low flex flex-col items-center justify-center text-center p-4">
                                                    <span class="material-symbols-outlined text-4xl text-primary mb-1"
                                                        aria-hidden="true">devices</span>
                                                    <span
                                                        class="font-label-spec text-label-spec uppercase text-on-surface-variant">[FOTO
                                                        MENYUSUL]</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div
                                            class="w-full flex items-center justify-between mt-2 pt-2 border-t border-canvas-border font-label-spec text-label-spec uppercase text-on-surface-variant font-bold">
                                            <span>PROMO MINGGU INI</span>
                                            <span>100% Baru + Segel Toko</span>
                                        </div>
                                    </div>
                                    <!-- Title & Specs -->
                                    <div class="flex flex-col gap-1.5">
                                        <h2
                                            class="font-headline-sm text-headline-sm font-bold text-slate-charcoal uppercase leading-snug mb-0">
                                            {{ $hero['title'] }}
                                        </h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">
                                            {{ $hero['subtitle'] }}</p>
                                        <div class="flex flex-wrap gap-1.5 pt-1">
                                            @foreach ($heroSpecs as $hSpec)
                                                <span
                                                    class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec text-slate-charcoal uppercase">{{ $hSpec }}</span>
                                            @endforeach
                                            @if (!empty($hero['bonus']))
                                                <span
                                                    class="px-2 py-0.5 bg-wood-ochre-light border border-canvas-border font-label-spec text-label-spec text-slate-charcoal uppercase">{{ $hero['bonus'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Price Box -->
                                    <div
                                        class="p-3 bg-surface-container-low border-[2px] border-canvas-border flex flex-col gap-0.5">
                                        @if ($heroSave > 0)
                                            <span
                                                class="font-label-code text-label-code text-strike-muted line-through font-semibold">
                                                Harga Normal: Rp {{ number_format($hero['original_price'], 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span
                                                class="font-label-code text-label-code text-on-surface-variant font-semibold">
                                                Harga Penawaran Resmi Toko
                                            </span>
                                        @endif
                                        <div class="flex items-baseline justify-between gap-2 flex-wrap">
                                            <span class="font-price-hero text-price-hero font-bold text-primary">
                                                Rp {{ number_format($hero['promo_price'], 0, ',', '.') }}
                                            </span>
                                            <span
                                                class="font-label-spec text-label-spec uppercase bg-whatsapp-green text-slate-charcoal font-bold px-1.5 py-0.5 border border-canvas-border">PROMO
                                                FLASH DEAL</span>
                                        </div>
                                    </div>
                                    <!-- Claim Button -->
                                    <a id="hero-wa-cta"
                                        class="w-full min-h-[44px] inline-flex items-center justify-center p-3 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-md font-bold uppercase border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all tracking-wider text-center"
                                        href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode($heroWaText) }}"
                                        rel="noopener noreferrer" target="_blank">
                                        <span class="material-symbols-outlined mr-2"
                                            aria-hidden="true">shopping_bag</span>Klaim Promo Flash Deal via WA
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- REAL CATALOG & SERVICE FACTS STRIP -->
                @if (!empty($trustStats))
                    @php
                        $statCount = count($trustStats);
                        $statColsClass = match (true) {
                            $statCount === 1 => 'grid-cols-1',
                            $statCount === 2 => 'grid-cols-2',
                            $statCount === 3 => 'grid-cols-2 md:grid-cols-3',
                            default => 'grid-cols-2 md:grid-cols-4',
                        };
                    @endphp
                    <div
                        class="grid {{ $statColsClass }} gap-3 py-6 my-2 border-y-[2.5px] border-canvas-border bg-canvas-cream">
                        @foreach ($trustStats as $sIdx => $stat)
                            @php
                                $valText = strtr((string) ($stat['value'] ?? ''), $statVars);
                                $labelText = strtr((string) ($stat['label'] ?? ''), $statVars);
                                $borderClasses = trim(
                                    ($sIdx % 2 === 1 ? 'border-l-2' : ($sIdx > 0 ? 'md:border-l-2' : '')) .
                                    ($sIdx >= 2 ? ' border-t-2 md:border-t-0' : '')
                                );
                            @endphp
                            <div
                                class="flex flex-col items-center justify-center text-center p-2 border-canvas-border {{ $borderClasses }}">
                                <span class="font-headline-lg text-headline-lg font-bold text-primary">{{ $valText }}</span>
                                @if ($labelText !== '')
                                    <span
                                        class="font-label-code text-label-code uppercase text-on-surface font-bold">{{ $labelText }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- KATALOG PRODUK & INTERACTIVE SPEC VARIANT SELECTOR (PRD 4.3 & 4.4) -->
                <section class="py-12 lg:py-16 flex flex-col gap-6" id="katalog">
                    <!-- Section Header & Controls -->
                    <div class="flex flex-col gap-4 border-b-[3px] border-canvas-border pb-6">
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                            <div class="flex flex-col gap-2">
                                <div
                                    class="inline-flex items-center gap-1.5 self-start px-2 py-0.5 bg-wood-ochre-light text-slate-charcoal border border-canvas-border font-label-spec text-label-spec font-bold uppercase">
                                    <span>KATALOG HARDWARE AKTIF</span>
                                </div>
                                <h2
                                    class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                    PILIHAN PERANGKAT &amp; VARIAN SPEK
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mb-0">
                                    Pilih spesifikasi yang sesuai kebutuhan Anda. Harga dan draf pesan WhatsApp otomatis
                                    diperbarui saat memilih varian RAM, SSD, atau jumlah unit.
                                </p>
                            </div>
                            <p id="catalog-result-count"
                                class="font-label-code text-label-code font-bold uppercase text-on-surface-variant mb-0 shrink-0"
                                aria-live="polite">
                                Menampilkan {{ $totalProducts }} dari {{ $totalProducts }} produk
                            </p>
                        </div>

                        <!-- Search, Sort & Stock Toggle Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-stretch pt-2">
                            <div class="lg:col-span-6 relative flex items-center">
                                <label for="catalog-search" class="sr-only">Cari produk, merek, atau spesifikasi</label>
                                <span
                                    class="material-symbols-outlined absolute left-3 text-on-surface-variant pointer-events-none"
                                    aria-hidden="true">search</span>
                                <input
                                    class="w-full min-h-[44px] pl-10 pr-11 py-2 bg-surface-container-lowest border-[2px] border-canvas-border font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:shadow-[3px_3px_0px_#111111]"
                                    id="catalog-search" placeholder="Cari tipe, merek, atau spek..." type="search" />
                                <button type="button" id="catalog-search-clear" aria-label="Hapus kata kunci pencarian"
                                    class="hidden absolute right-0 min-h-[44px] min-w-[44px] text-slate-charcoal hover:text-primary">
                                    <span class="w-full h-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[20px]"
                                            aria-hidden="true">close</span>
                                    </span>
                                </button>
                            </div>
                            <div class="lg:col-span-3">
                                <label for="catalog-sort" class="sr-only">Urutkan produk</label>
                                <select id="catalog-sort"
                                    class="w-full min-h-[44px] px-3 py-2 bg-surface-container-lowest border-[2px] border-canvas-border font-body-sm text-body-sm font-semibold text-slate-charcoal focus:outline-none focus:shadow-[3px_3px_0px_#111111]">
                                    <option value="default">Urutan: Rekomendasi Toko</option>
                                    <option value="price-asc">Urutan: Harga Termurah</option>
                                    <option value="price-desc">Urutan: Harga Termahal</option>
                                </select>
                            </div>
                            <div class="lg:col-span-3">
                                <label for="catalog-ready-only"
                                    class="w-full min-h-[44px] px-3 py-2 bg-canvas-cream border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111] flex items-center gap-2 font-body-sm text-body-sm font-bold text-slate-charcoal uppercase select-none">
                                    <input type="checkbox" id="catalog-ready-only" class="w-4 h-4 accent-[#825514]" />
                                    <span>Hanya Ready Stock</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter Pills (PRD 4.3) -->
                    <div class="flex flex-wrap items-center gap-2 pb-1" id="category-filter-bar" role="group"
                        aria-label="Filter kategori produk">
                        @foreach ($catalog['categories'] as $idx => $cat)
                            @php
                                $catCount = $idx === 0 ? $totalProducts : ($categoryCounts[$cat] ?? 0);
                            @endphp
                            <button type="button" aria-pressed="{{ $idx === 0 ? 'true' : 'false' }}"
                                class="category-btn min-h-[44px] px-4 py-2 {{ $idx === 0 ? 'bg-wood-ochre-light shadow-[3px_3px_0px_#111111]' : 'bg-canvas-cream shadow-[2px_2px_0px_#111111] hover:bg-wood-ochre-light' }} font-headline-sm text-body-sm font-bold text-slate-charcoal uppercase border-[2px] border-canvas-border transition-all"
                                data-cat="{{ $cat }}">
                                @if ($idx === 0)
                                    SEMUA KATALOG ({{ $catCount }})
                                @else
                                    {{ $cat }} ({{ $catCount }})
                                @endif
                            </button>
                        @endforeach
                    </div>

                    <!-- PRODUCT CARDS GRID (PRD 4.3 & 4.4) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="product-grid">
                        @foreach ($catalog['products'] as $pIdx => $product)
                            @php
                                $firstVariant = $product['variants'][0];
                                $initialSave = max(0, (int) $firstVariant['original_price'] - (int) $firstVariant['promo_price']);
                                $minVariantPrice = min(array_map(static fn($v) => (int) ($v['promo_price'] ?? 0), $product['variants']));
                                $images = $resolveProductImages($product);
                                $carouselId = 'carousel-' . $product['id'];
                                $initialText = implode("\n", [
                                    "Halo {$catalog['store_name']}, saya ingin memesan:",
                                    "- Produk: {$product['name']} ({$product['brand']})",
                                    "- Varian/Spesifikasi: {$firstVariant['label']}",
                                    "- Harga Promo: Rp " . number_format($firstVariant['promo_price'], 0, ',', '.') . " / unit",
                                    "- Jumlah: 1 unit",
                                    "- Total Estimasi: Rp " . number_format($firstVariant['promo_price'], 0, ',', '.'),
                                    "",
                                    "Apakah stok promo ini masih tersedia?",
                                ]);
                            @endphp
                            <div id="produk-{{ $product['id'] }}"
                                class="product-card flex flex-col bg-surface-container-lowest border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] scroll-mt-24 transition-shadow {{ !empty($product['is_sold_out']) ? 'opacity-90' : '' }}"
                                data-brand="{{ $product['brand'] }}" data-category="{{ $product['category'] }}"
                                data-title="{{ $product['name'] }}" data-min-price="{{ $minVariantPrice }}"
                                data-order="{{ $pIdx }}" data-sold-out="{{ !empty($product['is_sold_out']) ? '1' : '0' }}">
                                <div class="relative bg-canvas-cream border-b-[2px] border-canvas-border p-3">
                                    @if (!empty($product['badge']))
                                        <span
                                            class="absolute top-5 left-5 z-20 max-w-[calc(100%-125px)] truncate pointer-events-none px-2 py-0.5 bg-primary text-on-primary font-label-code text-label-code font-bold uppercase border border-canvas-border">
                                            {{ $product['badge'] }}
                                        </span>
                                    @endif
                                    @if (!empty($product['is_sold_out']))
                                        <span
                                            class="absolute top-5 right-5 z-20 pointer-events-none px-2 py-0.5 bg-error text-on-error font-label-code text-label-code font-bold uppercase border border-canvas-border shadow-[2px_2px_0px_#111111]">
                                            SOLD OUT
                                        </span>
                                    @endif
                                    @if (count($images) > 1)
                                        <div
                                            class="relative w-full aspect-[4/3] bg-white border border-canvas-border overflow-hidden">
                                            <div id="{{ $carouselId }}" class="carousel slide w-full h-full"
                                                data-carousel-total="{{ count($images) }}">
                                                <div class="carousel-inner w-full h-full">
                                                    @foreach ($images as $imgIdx => $imgUrl)
                                                        <div
                                                            class="carousel-item w-full h-full {{ $imgIdx === 0 ? 'active' : '' }}">
                                                            <img src="{{ $imgUrl }}"
                                                                class="d-block w-full h-full object-contain p-2 bg-white"
                                                                width="640" height="480"
                                                                alt="{{ $product['name'] }} ({{ $imgIdx + 1 }})" loading="lazy"
                                                                decoding="async" />
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#{{ $carouselId }}" data-bs-slide="prev"
                                                    aria-label="Foto sebelumnya untuk {{ $product['name'] }}">
                                                    <span
                                                        class="carousel-control-prev-icon bg-slate-charcoal p-2 border border-canvas-border"
                                                        aria-hidden="true"></span>
                                                    <span class="visually-hidden">Sebelumnya</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#{{ $carouselId }}" data-bs-slide="next"
                                                    aria-label="Foto berikutnya untuk {{ $product['name'] }}">
                                                    <span
                                                        class="carousel-control-next-icon bg-slate-charcoal p-2 border border-canvas-border"
                                                        aria-hidden="true"></span>
                                                    <span class="visually-hidden">Berikutnya</span>
                                                </button>
                                            </div>
                                            <span
                                                class="carousel-counter absolute bottom-2 left-2 z-20 pointer-events-none px-2 py-0.5 bg-slate-charcoal text-surface font-label-spec text-label-spec font-bold border border-canvas-border"
                                                aria-live="off">1/{{ count($images) }}</span>
                                            <button type="button"
                                                class="lightbox-trigger absolute bottom-2 right-2 z-20 min-h-[44px] min-w-[44px] px-2.5 py-1 bg-canvas-cream/95 hover:bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-label-spec text-label-spec font-bold uppercase inline-flex items-center gap-1"
                                                data-lightbox-title="{{ $product['name'] }}"
                                                data-lightbox-images='@json($images)' data-carousel-ref="{{ $carouselId }}"
                                                aria-label="Perbesar foto {{ $product['name'] }}">
                                                <span class="material-symbols-outlined text-[16px]"
                                                    aria-hidden="true">zoom_in</span>
                                                <span>Zoom</span>
                                            </button>
                                        </div>
                                    @elseif (count($images) === 1)
                                        <div
                                            class="relative w-full aspect-[4/3] bg-white border border-canvas-border overflow-hidden">
                                            <img class="w-full h-full object-contain p-2" alt="{{ $product['name'] }}"
                                                src="{{ $images[0] }}" width="640" height="480" loading="lazy"
                                                decoding="async" />
                                            <button type="button"
                                                class="lightbox-trigger absolute bottom-2 right-2 z-20 min-h-[44px] min-w-[44px] px-2.5 py-1 bg-canvas-cream/95 hover:bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-label-spec text-label-spec font-bold uppercase inline-flex items-center gap-1"
                                                data-lightbox-title="{{ $product['name'] }}"
                                                data-lightbox-images='@json($images)'
                                                aria-label="Perbesar foto {{ $product['name'] }}">
                                                <span class="material-symbols-outlined text-[16px]"
                                                    aria-hidden="true">zoom_in</span>
                                                <span>Zoom</span>
                                            </button>
                                        </div>
                                    @else
                                        <div
                                            class="w-full aspect-[4/3] border border-canvas-border bg-surface-container-low flex flex-col items-center justify-center text-center p-4">
                                            <span class="material-symbols-outlined text-4xl text-primary mb-1"
                                                aria-hidden="true">devices</span>
                                            <span
                                                class="font-label-code text-label-code font-bold uppercase text-slate-charcoal">{{ $product['brand'] }}
                                                • {{ $product['category'] }}</span>
                                            <span
                                                class="font-label-spec text-label-spec uppercase text-on-surface-variant mt-0.5">[FOTO
                                                MENYUSUL]</span>
                                        </div>
                                    @endif
                                    <div
                                        class="flex items-center justify-between gap-2 mt-2 pt-2 border-t border-canvas-border font-label-spec text-label-spec font-bold uppercase">
                                        <span class="text-on-surface-variant truncate">{{ $product['category'] }} •
                                            {{ $product['brand'] }}</span>
                                        <div class="flex items-center gap-2 shrink-0">
                                            @if (!empty($product['is_sold_out']))
                                                <span
                                                    class="bg-error-container text-on-error-container px-1.5 py-0.5 border border-error font-bold">SOLD
                                                    OUT</span>
                                            @else
                                                <span class="text-tertiary font-bold">UNIT READY STOCK</span>
                                            @endif
                                            <button type="button"
                                                class="copy-link-btn px-2.5 py-1 min-h-[44px] bg-surface-container-lowest hover:bg-wood-ochre-light text-slate-charcoal border border-canvas-border font-label-spec text-label-spec uppercase"
                                                data-product-id="{{ $product['id'] }}"
                                                aria-label="Salin tautan produk {{ $product['name'] }}">
                                                Salin Link
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 flex flex-col flex-grow gap-3">
                                    <h3
                                        class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal mb-0">
                                        {{ $product['name'] }} ({{ $product['brand'] }})
                                    </h3>
                                    <!-- Monospace spec chips -->
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($product['specs'] as $spec)
                                            <span
                                                class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec">{{ $spec }}</span>
                                        @endforeach
                                    </div>
                                    <!-- Variant Selector -->
                                    <div class="flex flex-col gap-1 pt-1">
                                        <label for="variant-{{ $product['id'] }}"
                                            class="font-label-code text-label-code font-bold text-slate-charcoal uppercase">PILIH
                                            VARIAN SPESIFIKASI:</label>
                                        <select id="variant-{{ $product['id'] }}"
                                            class="variant-select min-h-[44px] w-full p-2 bg-canvas-cream border-[2px] border-canvas-border font-body-sm text-body-sm font-semibold text-slate-charcoal focus:outline-none focus:shadow-[3px_3px_0px_#111111]">
                                            @foreach ($product['variants'] as $vIdx => $variant)
                                                @php
                                                    $vSave = max(0, (int) $variant['original_price'] - (int) $variant['promo_price']);
                                                @endphp
                                                <option value="v{{ $vIdx }}" data-label="{{ $variant['label'] }}"
                                                    data-price="{{ $variant['promo_price'] }}"
                                                    data-original="{{ $variant['original_price'] }}" data-save="{{ $vSave }}" {{ $vIdx === 0 ? 'selected' : '' }}>
                                                    {{ $variant['label'] }} (Rp
                                                    {{ number_format($variant['promo_price'], 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Dynamic Pricing Bar -->
                                    <div
                                        class="p-3 bg-surface-container-low border-[2px] border-canvas-border flex flex-col gap-1 mt-auto">
                                        <div class="flex items-center justify-between gap-2">
                                            <span
                                                class="original-price font-label-code text-label-code text-strike-muted line-through font-semibold {{ $initialSave > 0 ? '' : 'hidden' }}"
                                                data-role="original">
                                                @if ($initialSave > 0) Rp
                                                {{ number_format($firstVariant['original_price'], 0, ',', '.') }} @endif
                                            </span>
                                            <span
                                                class="save-badge font-label-spec text-label-spec bg-wood-ochre-light text-slate-charcoal px-1.5 py-0.5 border border-canvas-border uppercase font-bold {{ $initialSave > 0 ? '' : 'hidden' }}"
                                                data-role="save">
                                                @if ($initialSave > 0) Hemat Rp
                                                {{ number_format($initialSave, 0, ',', '.') }} @endif
                                            </span>
                                        </div>
                                        <div class="flex items-baseline justify-between">
                                            <span
                                                class="promo-price font-price-catalog text-price-catalog font-bold text-slate-charcoal"
                                                data-role="promo">
                                                Rp {{ number_format($firstVariant['promo_price'], 0, ',', '.') }}
                                            </span>
                                            <span
                                                class="font-label-code text-label-code font-bold uppercase text-on-surface-variant">/
                                                unit</span>
                                        </div>
                                        <div class="total-estimate font-label-code text-label-code font-bold uppercase text-primary hidden"
                                            data-role="total-estimate"></div>
                                    </div>
                                    <!-- Quantity & WA CTA -->
                                    <div class="flex items-center gap-2 pt-1">
                                        @if (!empty($product['is_sold_out']))
                                            <a class="wa-btn flex-1 min-h-[44px] inline-flex items-center justify-center p-2.5 bg-surface-container-high hover:bg-surface-container-highest text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111] transition-all text-center"
                                                data-role="wa-link"
                                                href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', apakah produk ini bisa di-pre-order / restock: ' . $product['name'] . ' (' . $product['brand'] . ')') }}"
                                                rel="noopener noreferrer" target="_blank">
                                                <span class="material-symbols-outlined text-[18px] mr-1"
                                                    aria-hidden="true">history_toggle_off</span>Sold Out (Tanya Restock)
                                            </a>
                                        @else
                                            <div class="w-20">
                                                <label for="qty-{{ $product['id'] }}" class="sr-only">Jumlah unit
                                                    {{ $product['name'] }}</label>
                                                <input id="qty-{{ $product['id'] }}"
                                                    class="qty-input min-h-[44px] w-full p-2 text-center bg-canvas-cream border-[2px] border-canvas-border font-label-code text-body-md font-bold focus:outline-none focus:shadow-[3px_3px_0px_#111111]"
                                                    min="1" max="50" type="number" value="1" />
                                            </div>
                                            <a class="wa-btn flex-1 min-h-[44px] inline-flex items-center justify-center p-2.5 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111] hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[4px_4px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all text-center"
                                                data-role="wa-link"
                                                href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode($initialText) }}"
                                                rel="noopener noreferrer" target="_blank">
                                                <span class="material-symbols-outlined text-[18px] mr-1"
                                                    aria-hidden="true">chat</span>Pesan via WhatsApp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Empty Search State -->
                    <div id="catalog-empty-state"
                        class="hidden text-center py-12 px-4 bg-surface-container-lowest border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] my-4">
                        <span class="material-symbols-outlined text-4xl text-primary mb-2"
                            aria-hidden="true">search_off</span>
                        <h3 class="font-headline-sm text-body-lg font-bold uppercase text-slate-charcoal mb-1">Produk
                            Tidak Ditemukan</h3>
                        <p class="font-body-sm text-on-surface-variant max-w-md mx-auto">Tidak ada produk yang cocok
                            dengan kata kunci atau filter yang dipilih.</p>
                        <button type="button" id="catalog-reset-btn"
                            class="mt-4 min-h-[44px] px-5 py-2.5 bg-wood-ochre-light hover:bg-white text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-2 border-canvas-border shadow-[3px_3px_0px_#111111] transition-colors">
                            Reset Pencarian &amp; Filter
                        </button>
                    </div>

                    <!-- Custom Build / Budget Consultation CTA Banner -->
                    <div
                        class="p-5 bg-slate-charcoal text-inverse-on-surface border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] mt-2 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start sm:items-center gap-3">
                            <div
                                class="w-11 h-11 bg-whatsapp-green text-slate-charcoal flex items-center justify-center font-bold border border-surface shrink-0">
                                <span class="material-symbols-outlined text-[24px]" aria-hidden="true">tune</span>
                            </div>
                            <div>
                                <h3
                                    class="font-headline-sm text-body-md font-bold uppercase text-wood-ochre-light mb-0.5">
                                    Butuh Rakit PC Custom atau Saran Sesuai Budget?
                                </h3>
                                <p class="font-body-sm text-body-sm text-inverse-on-surface mb-0">
                                    Kirimkan kebutuhan aplikasi atau target budget Anda. Teknisi kami bantu pilihkan
                                    komponen dan cek stok langsung via WhatsApp tanpa daftar akun.
                                </p>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya butuh rekomendasi perangkat / rakit PC custom sesuai budget. Kebutuhan utama saya:') }}"
                            target="_blank" rel="noopener noreferrer"
                            class="min-h-[44px] px-5 py-2.5 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-2 border-surface shadow-[3px_3px_0px_#E5AC67] inline-flex items-center justify-center shrink-0 transition-all">
                            <span class="material-symbols-outlined text-[18px] mr-1.5"
                                aria-hidden="true">chat</span>Konsultasi Budget WA
                        </a>
                    </div>
                </section>

                <!-- KEUNGGULAN TOKO (WHY US) -->
                @if (!empty($catalog['about_features']) || !empty($catalog['about_title']))
                    <section class="py-12 border-t-[3px] border-canvas-border" id="tentang-kami">
                        <div class="flex flex-col gap-2 mb-8">
                            <span
                                class="font-label-spec text-label-spec text-primary font-bold uppercase tracking-wider">MENGAPA
                                BELANJA DI SINI?</span>
                            <h2 class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                {{ $catalog['about_title'] ?? ('KEUNGGULAN ' . strtoupper($catalog['store_name'])) }}
                            </h2>
                            @if (!empty($catalog['about_subtitle']))
                                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mb-0">
                                    {{ $catalog['about_subtitle'] }}
                                </p>
                            @endif
                        </div>
                        @if (!empty($catalog['about_features']))
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                                @foreach ($catalog['about_features'] as $feat)
                                    <div
                                        class="bg-surface-container-lowest p-5 border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col gap-3">
                                        <div
                                            class="w-12 h-12 bg-wood-ochre-light border-[2px] border-canvas-border flex items-center justify-center text-slate-charcoal">
                                            <span class="material-symbols-outlined text-[28px]"
                                                aria-hidden="true">{{ $feat['icon'] ?? 'verified_user' }}</span>
                                        </div>
                                        <h3 class="font-headline-sm text-body-md font-bold uppercase text-slate-charcoal mb-0">
                                            {{ $feat['title'] }}
                                        </h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">
                                            {{ $feat['desc'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endif

                <!-- ALUR ORDER & VERIFIKASI ULASAN ASLI GOOGLE MAPS -->
                <section class="py-12 border-t-[3px] border-canvas-border">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                        <div class="lg:col-span-7 flex flex-col gap-5">
                            <div class="flex flex-col gap-1.5">
                                <span
                                    class="font-label-spec text-label-spec text-primary font-bold uppercase tracking-wider">CARA
                                    PEMESANAN MUDAH</span>
                                <h2
                                    class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                    ALUR ORDER 3 LANGKAH TANPA AKUN
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                    Proses belanja langsung terhubung dengan admin {{ $catalog['store_name'] }} agar
                                    pengecekan stok fisik dan garansi lebih transparan.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div
                                    class="bg-surface-container-lowest p-4 border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] flex flex-col gap-2">
                                    <span
                                        class="self-start px-2 py-0.5 bg-wood-ochre-light border border-canvas-border font-label-code text-label-code font-bold text-slate-charcoal">LANGKAH
                                        01</span>
                                    <h3
                                        class="font-headline-sm text-body-md font-bold uppercase text-slate-charcoal mb-0">
                                        Pilih Unit &amp; Varian</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Tentukan RAM, SSD,
                                        atau paket sesuai kebutuhan beserta jumlah unit.</p>
                                </div>
                                <div
                                    class="bg-surface-container-lowest p-4 border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] flex flex-col gap-2">
                                    <span
                                        class="self-start px-2 py-0.5 bg-wood-ochre-light border border-canvas-border font-label-code text-label-code font-bold text-slate-charcoal">LANGKAH
                                        02</span>
                                    <h3
                                        class="font-headline-sm text-body-md font-bold uppercase text-slate-charcoal mb-0">
                                        Kirim Draf WhatsApp</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Tekan tombol Pesan
                                        via WhatsApp agar format produk dan harga otomatis tersusun.</p>
                                </div>
                                <div
                                    class="bg-surface-container-lowest p-4 border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] flex flex-col gap-2">
                                    <span
                                        class="self-start px-2 py-0.5 bg-wood-ochre-light border border-canvas-border font-label-code text-label-code font-bold text-slate-charcoal">LANGKAH
                                        03</span>
                                    <h3
                                        class="font-headline-sm text-body-md font-bold uppercase text-slate-charcoal mb-0">
                                        Cek Fisik &amp; Serah Terima</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Admin konfirmasi
                                        stok siap pakai, lalu ambil di workshop atau kirim packing kayu.</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="lg:col-span-5 bg-canvas-cream p-6 border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col justify-between gap-4">
                            <div class="flex flex-col gap-2">
                                <span
                                    class="font-label-spec text-label-spec text-primary font-bold uppercase tracking-wider">TRANSPARANSI
                                    PELANGGAN</span>
                                <h3
                                    class="font-headline-md text-headline-md font-bold uppercase text-slate-charcoal mb-0">
                                    CEK ULASAN ASLI DI GOOGLE MAPS
                                </h3>
                                <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                    Kami tidak menaruh testimoni karangan di halaman web. Lihat ulasan langsung dari
                                    pembeli fisik maupun pengiriman pada profil Google Maps resmi
                                    {{ $catalog['store_name'] }}.
                                </p>
                            </div>
                            <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer"
                                class="w-full min-h-[44px] inline-flex items-center justify-center px-5 py-3 bg-wood-ochre-light hover:bg-white text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] transition-all">
                                <span class="material-symbols-outlined mr-2" aria-hidden="true">reviews</span>Lihat
                                Ulasan Asli di Google Maps
                            </a>
                        </div>
                    </div>
                </section>

                <!-- LOKASI TOKO, JAM BUKA & FAQ (PRD SECTION 4.1 & SECTION 6) -->
                <section class="py-12 border-t-[3px] border-canvas-border" id="kontak">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                        <!-- Store Location Details & Map Preview -->
                        <div class="lg:col-span-6 flex flex-col gap-5">
                            <div class="flex flex-col gap-1.5">
                                <span
                                    class="font-label-spec text-label-spec text-primary font-bold uppercase tracking-wider">LOKASI
                                    WORKSHOP KAMI</span>
                                <h2
                                    class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                    {{ $catalog['contact_title'] ?? 'KUNJUNGI TOKO FISIK' }}
                                </h2>
                                @if (!empty($catalog['contact_subtitle']))
                                    <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                        {{ $catalog['contact_subtitle'] }}
                                    </p>
                                @endif
                            </div>
                            <!-- Location Information Box -->
                            <div
                                class="p-4 bg-canvas-cream border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col gap-3">
                                <div class="flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-primary mt-0.5"
                                        aria-hidden="true">location_on</span>
                                    <div>
                                        <div
                                            class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">
                                            Alamat Workshop Utama:</div>
                                        <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                            {{ $catalog['address'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 border-t border-canvas-border pt-2.5">
                                    <span class="material-symbols-outlined text-primary mt-0.5"
                                        aria-hidden="true">schedule</span>
                                    <div>
                                        <div
                                            class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">
                                            Jam Buka Toko Fisik &amp; CS:</div>
                                        <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                            {{ $catalog['hours'] }} (Tetap Melayani Chat WA)
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 border-t border-canvas-border pt-2.5">
                                    <span class="material-symbols-outlined text-primary mt-0.5"
                                        aria-hidden="true">phone_iphone</span>
                                    <div>
                                        <div
                                            class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">
                                            Kontak WhatsApp Langsung:</div>
                                        <p class="font-body-md text-body-md text-on-surface-variant font-bold mb-0">
                                            +{{ $catalog['whatsapp_number'] }} (Admin {{ $catalog['store_name'] }})
                                        </p>
                                    </div>
                                </div>
                                @if ($hasSocialLinks)
                                    <div class="flex items-start gap-2.5 border-t border-canvas-border pt-2.5">
                                        <span class="material-symbols-outlined text-primary mt-2"
                                            aria-hidden="true">share</span>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span
                                                class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal mr-1">Media
                                                Sosial:</span>
                                            @if(!empty($catalog['instagram_url']))
                                                <a href="{{ $catalog['instagram_url'] }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="min-h-[44px] px-3 py-2 bg-surface-container-high hover:bg-wood-ochre-light text-slate-charcoal border border-canvas-border shadow-[1.5px_1.5px_0px_#111111] font-label-code text-[11px] font-bold uppercase inline-flex items-center transition-all">
                                                    Instagram
                                                </a>
                                            @endif
                                            @if(!empty($catalog['tiktok_url']))
                                                <a href="{{ $catalog['tiktok_url'] }}" target="_blank" rel="noopener noreferrer"
                                                    class="min-h-[44px] px-3 py-2 bg-surface-container-high hover:bg-wood-ochre-light text-slate-charcoal border border-canvas-border shadow-[1.5px_1.5px_0px_#111111] font-label-code text-[11px] font-bold uppercase inline-flex items-center transition-all">
                                                    TikTok
                                                </a>
                                            @endif
                                            @if(!empty($catalog['facebook_url']))
                                                <a href="{{ $catalog['facebook_url'] }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="min-h-[44px] px-3 py-2 bg-surface-container-high hover:bg-wood-ochre-light text-slate-charcoal border border-canvas-border shadow-[1.5px_1.5px_0px_#111111] font-label-code text-[11px] font-bold uppercase inline-flex items-center transition-all">
                                                    Facebook
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- Map Component -->
                            @php
                                $mapSrc = $catalog['map_image'] ?? '';
                                $isIframe = $mapSrc !== '' && (str_contains($mapSrc, 'maps.google.com') || str_contains($mapSrc, 'output=embed'));
                            @endphp
                            @if ($mapSrc !== '')
                                <div
                                    class="relative w-full h-60 border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] overflow-hidden bg-canvas-cream">
                                    @if ($isIframe)
                                        <iframe src="{{ $mapSrc }}" class="w-full h-full border-0" loading="lazy"
                                            allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                                            title="Peta lokasi toko {{ $catalog['store_name'] }}"></iframe>
                                    @else
                                        <img src="{{ $mapSrc }}" alt="Peta lokasi {{ $catalog['store_name'] }}" width="640"
                                            height="360" loading="lazy" decoding="async" class="w-full h-full object-cover" />
                                    @endif
                                    <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer"
                                        class="absolute bottom-2 right-2 min-h-[44px] px-3 py-2 bg-wood-ochre-light text-slate-charcoal font-label-code text-label-code font-bold uppercase border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white transition-colors inline-flex items-center gap-1.5 z-10">
                                        <span class="material-symbols-outlined text-[16px]"
                                            aria-hidden="true">location_on</span>
                                        <span>Buka Google Maps</span>
                                    </a>
                                </div>
                            @else
                                <div
                                    class="p-4 bg-surface-container-lowest border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] flex items-center justify-between gap-3">
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Lihat petunjuk arah
                                        langsung melalui aplikasi Google Maps.</span>
                                    <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer"
                                        class="min-h-[44px] px-3 py-2 bg-wood-ochre-light text-slate-charcoal font-label-code text-label-code font-bold uppercase border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white inline-flex items-center gap-1.5 shrink-0">
                                        <span class="material-symbols-outlined text-[16px]"
                                            aria-hidden="true">location_on</span>Buka Google Maps
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- FAQ Accordion -->
                        <div class="lg:col-span-6 flex flex-col gap-4">
                            <div class="flex flex-col gap-1.5">
                                <span
                                    class="font-label-spec text-label-spec text-primary font-bold uppercase tracking-wider">PERTANYAAN
                                    UMUM</span>
                                <h2
                                    class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                    FAQ PEMBELIAN &amp; SERVICE
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                    Informasi mengenai pemesanan, pembayaran, dan proteksi garansi.
                                </p>
                            </div>
                            @if (!empty($catalog['faqs']))
                                <div class="flex flex-col gap-3 pt-1" id="faq-container">
                                    @foreach ($catalog['faqs'] as $fIdx => $faq)
                                        <div
                                            class="faq-item bg-surface-container-lowest border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111]">
                                            <button type="button" aria-expanded="{{ $fIdx === 0 ? 'true' : 'false' }}"
                                                aria-controls="faq-answer-{{ $fIdx }}"
                                                class="faq-toggle min-h-[44px] w-full p-3.5 text-left font-headline-sm text-body-md font-bold uppercase text-slate-charcoal flex items-center justify-between gap-3">
                                                <span>{{ $faq['q'] }}</span>
                                                <span
                                                    class="material-symbols-outlined transition-transform duration-200 shrink-0"
                                                    aria-hidden="true">{{ $fIdx === 0 ? 'expand_less' : 'expand_more' }}</span>
                                            </button>
                                            <div id="faq-answer-{{ $fIdx }}"
                                                class="faq-answer px-3.5 pb-3.5 pt-2 text-on-surface-variant font-body-sm text-body-sm border-t border-canvas-border {{ $fIdx === 0 ? '' : 'hidden' }}">
                                                {{ $faq['a'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="p-4 bg-surface-container-lowest border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111] font-body-sm text-body-sm text-on-surface-variant">
                                    Belum ada daftar pertanyaan ditambahkan. Hubungi admin via WhatsApp untuk tanya stok dan
                                    garansi secara langsung.
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- STICKY FLOATING WHATSAPP ACTION BUTTON FOR MOBILE -->
            <div class="lg:hidden fixed bottom-4 right-4 z-40">
                <a class="flex items-center gap-2 min-h-[48px] px-4 py-3 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[3px] border-canvas-border shadow-[4px_4px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111]"
                    href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya tertarik melihat katalog dan ingin tanya stok laptop/PC') }}"
                    rel="noopener noreferrer" target="_blank">
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">chat</span>
                    <span>Chat WA Admin</span>
                </a>
            </div>
        </div>
    </main>

    <!-- PRODUCT IMAGE LIGHTBOX MODAL -->
    <div id="product-lightbox" class="hidden fixed inset-0 z-[70] bg-black/85 p-4" role="dialog" aria-modal="true"
        aria-labelledby="lightbox-title">
        <div id="lightbox-backdrop" class="w-full h-full flex items-center justify-center">
            <div
                class="w-full max-w-3xl bg-canvas-cream border-[3px] border-canvas-border shadow-[6px_6px_0px_#E5AC67] flex flex-col">
                <div
                    class="flex items-center justify-between gap-3 px-4 py-3 bg-surface-container-lowest border-b-[2px] border-canvas-border">
                    <div class="min-w-0">
                        <h2 id="lightbox-title"
                            class="font-headline-sm text-body-md font-bold uppercase text-slate-charcoal mb-0 truncate">
                            Pratinjau Foto Produk</h2>
                        <span id="lightbox-counter" class="font-label-code text-label-code text-on-surface-variant">1 /
                            1</span>
                    </div>
                    <button type="button" id="lightbox-close-btn" aria-label="Tutup pratinjau foto"
                        class="min-h-[44px] px-3 py-1.5 bg-surface-container-high hover:bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-headline-sm text-body-sm font-bold uppercase">
                        Tutup
                    </button>
                </div>
                <div class="bg-white p-3 flex items-center justify-center min-h-[300px] sm:min-h-[420px]">
                    <img id="lightbox-img" src="" alt="" class="max-h-[70vh] w-auto max-w-full object-contain" />
                </div>
                <div id="lightbox-nav" class="hidden px-4 py-3 bg-canvas-cream border-t-[2px] border-canvas-border">
                    <div class="flex items-center justify-between gap-2 w-full">
                        <button type="button" id="lightbox-prev"
                            class="min-h-[44px] px-4 py-2 bg-surface-container-lowest hover:bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-headline-sm text-body-sm font-bold uppercase">
                            Sebelumnya
                        </button>
                        <button type="button" id="lightbox-next"
                            class="min-h-[44px] px-4 py-2 bg-surface-container-lowest hover:bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border font-headline-sm text-body-sm font-bold uppercase">
                            Berikutnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="w-full bg-canvas-cream border-t-[3px] border-canvas-border mt-space-xl pb-24 lg:pb-0">
        <div class="max-w-[1320px] mx-auto px-margin-mobile lg:px-margin py-space-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-lg mb-space-xl">
                <div class="flex flex-col gap-space-sm">
                    <div class="font-headline-md text-headline-md font-bold uppercase text-slate-charcoal">
                        {{ $catalog['store_name'] }}</div>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-0">{{ $catalog['tagline'] }}.
                        Penjualan laptop, perakitan PC, monitor, printer &amp; aksesoris komputer dengan garansi resmi
                        dan konsultasi teknisi langsung.</p>
                    <div class="inline-flex items-center gap-2 mt-space-xs">
                        <span class="w-3 h-3 bg-whatsapp-green border border-canvas-border inline-block"
                            aria-hidden="true"></span>
                        <span class="font-label-code text-label-code font-bold uppercase text-on-surface">Toko Fisik
                            &amp; Workshop Aktif</span>
                    </div>
                    @if ($hasSocialLinks)
                        <div class="flex items-center gap-2 mt-2">
                            @if(!empty($catalog['instagram_url']))
                                <a href="{{ $catalog['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                                    title="Instagram" aria-label="Instagram {{ $catalog['store_name'] }}"
                                    class="w-11 h-11 flex items-center justify-center bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.161-2.759 6.161-6.163c0-3.403-2.758-6.162-6.161-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                            @endif
                            @if(!empty($catalog['tiktok_url']))
                                <a href="{{ $catalog['tiktok_url'] }}" target="_blank" rel="noopener noreferrer" title="TikTok"
                                    aria-label="TikTok {{ $catalog['store_name'] }}"
                                    class="w-11 h-11 flex items-center justify-center bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.27 6.27 0 0 0 1.94-4.52V8.9a8.18 8.18 0 0 0 4.77 1.52V6.97a4.85 4.85 0 0 1-.94-.28z" />
                                    </svg>
                                </a>
                            @endif
                            @if(!empty($catalog['facebook_url']))
                                <a href="{{ $catalog['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                                    title="Facebook" aria-label="Facebook {{ $catalog['store_name'] }}"
                                    class="w-11 h-11 flex items-center justify-center bg-wood-ochre-light text-slate-charcoal border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white hover:translate-x-[-1px] hover:translate-y-[-1px] transition-all">
                                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="flex flex-col gap-space-sm">
                    <h3
                        class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal border-b-2 border-canvas-border pb-1 mb-0">
                        Jam Operasional</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant font-medium mb-1">
                        {{ $catalog['hours'] }}</p>
                    <div
                        class="p-2.5 bg-surface-container-high border-2 border-canvas-border shadow-[2px_2px_0px_#111111] mt-space-xs">
                        <p class="font-label-spec text-label-spec text-on-surface font-bold uppercase mb-0">Layanan
                            Rakit &amp; Antar Hari yang Sama</p>
                    </div>
                </div>
                <div class="flex flex-col gap-space-sm">
                    <h3
                        class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal border-b-2 border-canvas-border pb-1 mb-0">
                        Navigasi Cepat</h3>
                    <nav class="flex flex-col gap-space-xs font-body-sm text-body-sm font-semibold"
                        aria-label="Navigasi footer">
                        <a class="py-1 text-on-surface-variant hover:text-primary hover:underline transition-colors uppercase"
                            href="#promo">Katalog Promo Spesial</a>
                        <a class="py-1 text-on-surface-variant hover:text-primary hover:underline transition-colors uppercase"
                            href="#katalog">Laptop &amp; PC Gaming</a>
                        <a class="py-1 text-on-surface-variant hover:text-primary hover:underline transition-colors uppercase"
                            href="#tentang-kami">Profil {{ $catalog['store_name'] }}</a>
                        <a class="py-1 text-on-surface-variant hover:text-primary hover:underline transition-colors uppercase"
                            href="#kontak">Lokasi &amp; Workshop</a>
                    </nav>
                </div>
                <div class="flex flex-col gap-space-sm">
                    <h3
                        class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal border-b-2 border-canvas-border pb-1 mb-0">
                        Hotline WhatsApp</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Tanya stok, custom rakitan PC,
                        atau klaim garansi via chat admin kami:</p>
                    <a class="min-h-[44px] inline-flex items-center justify-center p-3 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal border-2 border-canvas-border shadow-[3px_3px_0px_#111111] hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[4px_4px_0px_#111111] transition-all font-headline-sm text-headline-sm font-bold uppercase tracking-wider"
                        href="https://wa.me/{{ $catalog['whatsapp_number'] }}" rel="noopener noreferrer"
                        target="_blank">
                        <span class="material-symbols-outlined mr-2"
                            aria-hidden="true">chat</span>+{{ $catalog['whatsapp_number'] }}
                    </a>
                    <span class="font-label-code text-label-code text-on-surface-variant uppercase">Melayani konsultasi
                        spek selama jam kerja</span>
                </div>
            </div>
            <div
                class="border-t-2 border-canvas-border pt-space-md flex flex-col md:flex-row items-center justify-between gap-space-sm font-label-code text-label-code text-on-surface-variant">
                <p class="mb-0">© {{ date('Y') }} {{ strtoupper($catalog['store_name']) }}. SEMUA HAK DILINDUNGI.</p>
                <div class="flex items-center gap-3">
                    <span class="font-bold uppercase text-on-surface">INDUSTRIAL BRUTALIST HARDWARE DESK</span>
                    <span>•</span>
                    <a href="/admin" class="font-bold uppercase text-primary hover:underline py-1">PANEL ADMIN</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const WA_PHONE = @json($catalog['whatsapp_number']);
            const STORE_NAME = @json($catalog['store_name']);

            function formatRupiah(number) {
                return 'Rp ' + Math.round(Number(number) || 0).toLocaleString('id-ID');
            }

            // Mobile nav drawer toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileNavDrawer = document.getElementById('mobile-nav-drawer');
            function setMobileMenuOpen(open) {
                if (!mobileMenuBtn || !mobileNavDrawer) return;
                mobileNavDrawer.classList.toggle('hidden', !open);
                mobileMenuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
            mobileMenuBtn?.addEventListener('click', () => {
                const isOpen = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
                setMobileMenuOpen(!isOpen);
            });
            document.querySelectorAll('.mobile-nav-link').forEach((link) => {
                link.addEventListener('click', () => setMobileMenuOpen(false));
            });

            // Product variant pricing & WhatsApp link builder
            function updateCardPricing(card) {
                const title = card.getAttribute('data-title');
                const brand = card.getAttribute('data-brand');
                const select = card.querySelector('.variant-select');
                const qtyInput = card.querySelector('.qty-input');
                const originalEl = card.querySelector('.original-price');
                const promoEl = card.querySelector('.promo-price');
                const saveBadge = card.querySelector('.save-badge');
                const totalEstEl = card.querySelector('.total-estimate');
                const waBtn = card.querySelector('.wa-btn');

                if (!select || !waBtn) return;

                const selectedOption = select.options[select.selectedIndex];
                const label = selectedOption.getAttribute('data-label') || selectedOption.text;
                const price = parseInt(selectedOption.getAttribute('data-price'), 10) || 0;
                const originalPrice = parseInt(selectedOption.getAttribute('data-original'), 10) || 0;
                const saveAmount = Math.max(0, originalPrice - price);
                const qty = qtyInput ? Math.max(1, parseInt(qtyInput.value, 10) || 1) : 1;
                const totalPrice = price * qty;

                if (originalEl) {
                    originalEl.textContent = formatRupiah(originalPrice);
                    originalEl.classList.toggle('hidden', saveAmount <= 0);
                }
                if (saveBadge) {
                    saveBadge.textContent = 'Hemat ' + formatRupiah(saveAmount);
                    saveBadge.classList.toggle('hidden', saveAmount <= 0);
                }
                if (promoEl) {
                    promoEl.textContent = formatRupiah(price);
                }
                if (totalEstEl) {
                    if (qty > 1) {
                        totalEstEl.textContent = `Total (${qty} unit): ${formatRupiah(totalPrice)}`;
                        totalEstEl.classList.remove('hidden');
                    } else {
                        totalEstEl.classList.add('hidden');
                    }
                }

                const isSoldOut = card.getAttribute('data-sold-out') === '1';
                const messageText = isSoldOut ? [
                    `Halo ${STORE_NAME}, saya ingin menanyakan apakah produk ini bisa restock:`,
                    `- Produk: ${title} (${brand})`,
                    `- Varian/Spesifikasi: ${label}`,
                    ``,
                    `Kapan perkiraan unit ready kembali?`
                ].join('\n') : [
                    `Halo ${STORE_NAME}, saya ingin memesan:`,
                    `- Produk: ${title} (${brand})`,
                    `- Varian/Spesifikasi: ${label}`,
                    `- Harga Promo: ${formatRupiah(price)} / unit`,
                    `- Jumlah: ${qty} unit`,
                    `- Total Estimasi: ${formatRupiah(totalPrice)}`,
                    ``,
                    `Apakah stok promo ini masih tersedia?`
                ].join('\n');

                waBtn.setAttribute('href', `https://wa.me/${WA_PHONE}?text=${encodeURIComponent(messageText)}`);
            }

            const productGrid = document.getElementById('product-grid');
            const productCards = Array.from(document.querySelectorAll('.product-card'));
            productCards.forEach((card) => {
                const select = card.querySelector('.variant-select');
                const qtyInput = card.querySelector('.qty-input');
                select?.addEventListener('change', () => updateCardPricing(card));
                qtyInput?.addEventListener('input', () => updateCardPricing(card));
                qtyInput?.addEventListener('change', () => updateCardPricing(card));
                updateCardPricing(card);
            });

            // Multi-photo carousel counter sync
            document.querySelectorAll('[data-carousel-total]').forEach((carouselEl) => {
                const total = carouselEl.getAttribute('data-carousel-total') || '1';
                const counter = carouselEl.parentElement?.querySelector('.carousel-counter');
                carouselEl.addEventListener('slid.bs.carousel', (ev) => {
                    if (counter && typeof ev.to === 'number') {
                        counter.textContent = `${ev.to + 1}/${total}`;
                    }
                });
            });

            // Copy product anchor link button
            document.querySelectorAll('.copy-link-btn').forEach((btn) => {
                btn.addEventListener('click', async () => {
                    const productId = btn.getAttribute('data-product-id');
                    if (!productId) return;
                    const targetUrl = `${window.location.origin}/#produk-${productId}`;
                    try {
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            await navigator.clipboard.writeText(targetUrl);
                        } else {
                            const tmp = document.createElement('input');
                            tmp.value = targetUrl;
                            document.body.appendChild(tmp);
                            tmp.select();
                            document.execCommand('copy');
                            document.body.removeChild(tmp);
                        }
                        btn.textContent = 'Tersalin!';
                        setTimeout(() => { btn.textContent = 'Salin Link'; }, 2000);
                    } catch (e) {
                        btn.textContent = 'Gagal';
                        setTimeout(() => { btn.textContent = 'Salin Link'; }, 2000);
                    }
                });
            });

            // Search, Category Filter, Sort & Ready-Only Toggle
            let activeCat = 'Semua';
            const searchInput = document.getElementById('catalog-search');
            const searchClearBtn = document.getElementById('catalog-search-clear');
            const sortSelect = document.getElementById('catalog-sort');
            const readyOnlyCheck = document.getElementById('catalog-ready-only');
            const resetBtn = document.getElementById('catalog-reset-btn');
            const resultCountEl = document.getElementById('catalog-result-count');
            const filterBtns = document.querySelectorAll('.category-btn');

            function applyFilterAndSort() {
                const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
                const readyOnly = Boolean(readyOnlyCheck?.checked);
                const sortMode = sortSelect?.value || 'default';

                searchClearBtn?.classList.toggle('hidden', query.length === 0);

                if (productGrid && productCards.length > 1) {
                    const sorted = [...productCards].sort((a, b) => {
                        if (sortMode === 'price-asc') {
                            return (parseInt(a.dataset.minPrice, 10) || 0) - (parseInt(b.dataset.minPrice, 10) || 0);
                        }
                        if (sortMode === 'price-desc') {
                            return (parseInt(b.dataset.minPrice, 10) || 0) - (parseInt(a.dataset.minPrice, 10) || 0);
                        }
                        return (parseInt(a.dataset.order, 10) || 0) - (parseInt(b.dataset.order, 10) || 0);
                    });
                    sorted.forEach((c) => productGrid.appendChild(c));
                }

                let visibleCount = 0;
                productCards.forEach((card) => {
                    const cardCat = card.getAttribute('data-category');
                    const isSoldOut = card.getAttribute('data-sold-out') === '1';
                    const matchCat = activeCat === 'Semua' || cardCat === activeCat;
                    const matchReady = !readyOnly || !isSoldOut;
                    const matchQuery = !query || card.textContent.toLowerCase().includes(query);
                    const isVisible = matchCat && matchReady && matchQuery;
                    card.style.display = isVisible ? 'flex' : 'none';
                    if (isVisible) visibleCount++;
                });

                if (resultCountEl) {
                    resultCountEl.textContent = `Menampilkan ${visibleCount} dari ${productCards.length} produk`;
                }
                const emptyState = document.getElementById('catalog-empty-state');
                emptyState?.classList.toggle('hidden', visibleCount > 0);
            }

            filterBtns.forEach((btn) => {
                btn.addEventListener('click', () => {
                    filterBtns.forEach((b) => {
                        b.classList.remove('bg-wood-ochre-light', 'shadow-[3px_3px_0px_#111111]');
                        b.classList.add('bg-canvas-cream', 'shadow-[2px_2px_0px_#111111]');
                        b.setAttribute('aria-pressed', 'false');
                    });
                    btn.classList.remove('bg-canvas-cream', 'shadow-[2px_2px_0px_#111111]');
                    btn.classList.add('bg-wood-ochre-light', 'shadow-[3px_3px_0px_#111111]');
                    btn.setAttribute('aria-pressed', 'true');
                    activeCat = btn.getAttribute('data-cat') || 'Semua';
                    applyFilterAndSort();
                });
            });

            searchInput?.addEventListener('input', applyFilterAndSort);
            searchClearBtn?.addEventListener('click', () => {
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.focus();
                }
                applyFilterAndSort();
            });
            sortSelect?.addEventListener('change', applyFilterAndSort);
            readyOnlyCheck?.addEventListener('change', applyFilterAndSort);
            resetBtn?.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                if (readyOnlyCheck) readyOnlyCheck.checked = false;
                if (sortSelect) sortSelect.value = 'default';
                const firstCatBtn = filterBtns[0];
                if (firstCatBtn) {
                    firstCatBtn.click();
                } else {
                    activeCat = 'Semua';
                    applyFilterAndSort();
                }
            });

            // Highlight direct Story Card product hash links
            function highlightAnchoredProduct() {
                const hash = window.location.hash;
                if (!hash || !hash.startsWith('#produk-')) return;
                const target = document.getElementById(hash.slice(1));
                if (!target) return;
                if (target.style.display === 'none') {
                    resetBtn?.click();
                }
                target.classList.add('ring-4', 'ring-wood-ochre-dark');
                setTimeout(() => {
                    target.classList.remove('ring-4', 'ring-wood-ochre-dark');
                }, 2800);
            }
            window.addEventListener('hashchange', highlightAnchoredProduct);
            highlightAnchoredProduct();

            // FAQ Accordion with aria-expanded sync
            const faqToggles = document.querySelectorAll('.faq-toggle');
            faqToggles.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const item = btn.closest('.faq-item');
                    const answer = item?.querySelector('.faq-answer');
                    const icon = btn.querySelector('.material-symbols-outlined');
                    if (!answer) return;
                    const isHidden = answer.classList.contains('hidden');

                    document.querySelectorAll('.faq-answer').forEach((ans) => ans.classList.add('hidden'));
                    document.querySelectorAll('.faq-toggle').forEach((tg) => tg.setAttribute('aria-expanded', 'false'));
                    document.querySelectorAll('.faq-toggle .material-symbols-outlined').forEach((ic) => { ic.textContent = 'expand_more'; });

                    if (isHidden) {
                        answer.classList.remove('hidden');
                        btn.setAttribute('aria-expanded', 'true');
                        if (icon) icon.textContent = 'expand_less';
                    }
                });
            });

            // Product Lightbox Modal
            const lightboxModal = document.getElementById('product-lightbox');
            const lightboxTitle = document.getElementById('lightbox-title');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCounter = document.getElementById('lightbox-counter');
            const lightboxNav = document.getElementById('lightbox-nav');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');
            const lightboxClose = document.getElementById('lightbox-close-btn');
            let lightboxImages = [];
            let lightboxIdx = 0;
            let lightboxLastFocus = null;

            function updateLightboxSlide() {
                if (!lightboxImages.length || !lightboxImg) return;
                lightboxImg.src = lightboxImages[lightboxIdx];
                lightboxImg.alt = `${lightboxTitle?.textContent || 'Produk'} (${lightboxIdx + 1}/${lightboxImages.length})`;
                if (lightboxCounter) {
                    lightboxCounter.textContent = `${lightboxIdx + 1} / ${lightboxImages.length}`;
                }
                lightboxNav?.classList.toggle('hidden', lightboxImages.length <= 1);
            }

            function closeLightbox() {
                if (!lightboxModal || lightboxModal.classList.contains('hidden')) return;
                lightboxModal.classList.add('hidden');
                document.body.style.overflow = '';
                if (lightboxLastFocus && typeof lightboxLastFocus.focus === 'function') {
                    lightboxLastFocus.focus();
                }
            }

            document.querySelectorAll('.lightbox-trigger').forEach((trigger) => {
                trigger.addEventListener('click', () => {
                    if (!lightboxModal) return;
                    try {
                        lightboxImages = JSON.parse(trigger.getAttribute('data-lightbox-images') || '[]');
                    } catch (e) {
                        lightboxImages = [];
                    }
                    if (!lightboxImages.length) return;
                    lightboxLastFocus = trigger;
                    const title = trigger.getAttribute('data-lightbox-title') || 'Pratinjau Foto Produk';
                    if (lightboxTitle) lightboxTitle.textContent = title;

                    lightboxIdx = 0;
                    const carouselRefId = trigger.getAttribute('data-carousel-ref');
                    if (carouselRefId) {
                        const carouselEl = document.getElementById(carouselRefId);
                        const items = carouselEl ? Array.from(carouselEl.querySelectorAll('.carousel-item')) : [];
                        const activePos = items.findIndex((it) => it.classList.contains('active'));
                        if (activePos >= 0) lightboxIdx = activePos;
                    }

                    updateLightboxSlide();
                    lightboxModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    lightboxClose?.focus();
                });
            });

            lightboxPrev?.addEventListener('click', () => {
                if (lightboxImages.length <= 1) return;
                lightboxIdx = (lightboxIdx - 1 + lightboxImages.length) % lightboxImages.length;
                updateLightboxSlide();
            });
            lightboxNext?.addEventListener('click', () => {
                if (lightboxImages.length <= 1) return;
                lightboxIdx = (lightboxIdx + 1) % lightboxImages.length;
                updateLightboxSlide();
            });
            const lightboxBackdrop = document.getElementById('lightbox-backdrop');
            lightboxClose?.addEventListener('click', closeLightbox);
            lightboxModal?.addEventListener('click', (ev) => {
                if (ev.target === lightboxModal || ev.target === lightboxBackdrop) closeLightbox();
            });

            document.addEventListener('keydown', (ev) => {
                if (ev.key === 'Escape') {
                    closeLightbox();
                    if (mobileNavDrawer && !mobileNavDrawer.classList.contains('hidden')) {
                        setMobileMenuOpen(false);
                        mobileMenuBtn?.focus();
                    }
                }
            });
        })();
    </script>
</body>

</html>