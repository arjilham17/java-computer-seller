<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_standard" name="shell-type"/>
    <title>{{ $catalog['store_name'] }} — {{ $catalog['tagline'] }}</title>
    <link rel="icon" type="image/x-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.ico' }}"/>
    <link rel="icon" type="image/svg+xml" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/favicon.svg' }}"/>
    <link rel="apple-touch-icon" href="{{ !empty($catalog['logo']) ? $catalog['logo'] : '/apple-touch-icon.png' }}"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@600;700&amp;family=Space+Grotesk:wght@600;700&amp;family=Work+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Bootstrap 5.3.3 for Carousel & base utilities -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
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
                        "strike-muted": "#78716C",
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
            html, body { margin: 0; padding: 0; scroll-behavior: smooth; }
            body { overscroll-behavior: none; background-color: #fcf9f3; color: #1c1c18; }
            a { text-decoration: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
        ::-webkit-scrollbar { display: none; }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .brutal-marquee {
            display: flex;
            width: max-content;
            animation: marquee 28s linear infinite;
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-primary-container selection:text-on-primary-container">

<!-- STICKY HEADER / NAVBAR (Brutal Hardware Ochre) -->
<header class="fixed top-0 left-0 right-0 z-50 bg-canvas-cream border-b-[3px] border-canvas-border shadow-[0_4px_0px_#111111]">
    <div class="h-20 max-w-[1320px] mx-auto px-margin-mobile lg:px-margin flex items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-sm sm:gap-space-md">
            @if (!empty($catalog['logo']))
                <img src="{{ $catalog['logo'] }}" alt="Logo {{ $catalog['store_name'] }}" class="h-10 w-auto object-contain border-2 border-canvas-border shadow-[2px_2px_0px_#111111] bg-surface-container-lowest p-0.5"/>
            @else
                <span class="badge bg-wood-ochre-dark text-on-primary font-headline-sm font-bold border-2 border-canvas-border shadow-[2px_2px_0px_#111111] rounded-none px-2.5 py-2">JC</span>
            @endif
            <div class="flex flex-col">
                <a class="font-headline-md text-headline-md tracking-tight font-bold text-slate-charcoal hover:text-wood-ochre-dark transition-colors uppercase" href="/">{{ $catalog['store_name'] }}</a>
                <span class="hidden sm:inline-block font-label-spec text-label-spec text-on-surface-variant font-bold uppercase tracking-wider">Laptop • PC • Printer • Monitor • Aksesoris</span>
            </div>
        </div>
        <nav class="hidden lg:flex items-center gap-space-md">
            <a class="px-3 py-1.5 bg-wood-ochre-light text-on-surface border-2 border-canvas-border shadow-[2px_2px_0px_#111111] font-headline-sm text-body-sm font-bold transition-all uppercase" href="#promo">PROMO</a>
            <a class="px-3 py-1.5 text-on-surface-variant hover:text-on-surface hover:bg-surface-variant font-headline-sm text-body-sm font-semibold transition-all uppercase" href="#katalog">KATALOG</a>
            <a class="px-3 py-1.5 text-on-surface-variant hover:text-on-surface hover:bg-surface-variant font-headline-sm text-body-sm font-semibold transition-all uppercase" href="#tentang-kami">TENTANG KAMI</a>
            <a class="px-3 py-1.5 text-on-surface-variant hover:text-on-surface hover:bg-surface-variant font-headline-sm text-body-sm font-semibold transition-all uppercase" href="#kontak">KONTAK</a>
        </nav>
        <div class="flex items-center gap-space-sm">
            <a class="inline-flex items-center justify-center px-4 py-2 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[4px_4px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all tracking-wider"
               href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya ingin konsultasi perangkat komputer.') }}"
               rel="noopener noreferrer" target="_blank">
                <span class="material-symbols-outlined text-[20px] mr-1.5">chat</span>Chat Admin WA
            </a>
        </div>
    </div>
</header>

<main class="w-full pt-20 bg-surface min-h-[calc(100vh-80px)]">
    <div class="flex flex-col w-full">
        <!-- Ticker Tape / Announcement Marquee -->
        <div class="w-full bg-wood-ochre-light text-slate-charcoal overflow-hidden py-2.5 border-b-[2.5px] border-canvas-border shadow-[0_3px_0px_#111111] select-none">
            <div class="brutal-marquee whitespace-nowrap gap-8 font-label-code text-label-code uppercase font-bold tracking-wider">
                <span>⚡ FLASH SALE MINGGU INI • DISKON HINGGA 35% • GARANSI RESMI &amp; TOKO TUKAR BARU • GRATIS INSTALASI OS &amp; OFFICE • KONSULTASI SPEK 1-ON-1 GRATIS VIA WA ⚡</span>
                <span>⚡ READY STOCK LAPTOP &amp; PC RAKITAN GAMING/KANTOR • PACKING KAYU AMAN KE SELURUH INDONESIA • ORDER VIA WHATSAPP HITUNGAN MENIT ⚡</span>
                <span>⚡ FLASH SALE MINGGU INI • DISKON HINGGA 35% • GARANSI RESMI &amp; TOKO TUKAR BARU • GRATIS INSTALASI OS &amp; OFFICE • KONSULTASI SPEK 1-ON-1 GRATIS VIA WA ⚡</span>
            </div>
        </div>

        <div class="max-w-[1320px] mx-auto px-margin-mobile lg:px-margin w-full">
            <!-- HERO SECTION (PRD 4.2) -->
            @php
                $hero = $catalog['hero_deal'];
                $heroSave = max(0, (int) $hero['original_price'] - (int) $hero['promo_price']);
                $heroSpecs = array_filter(array_map('trim', explode('•', $hero['subtitle'])));
                $heroImage = $catalog['products'][0]['images'][0] ?? $catalog['products'][0]['image'] ?? 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80';
                $heroWaText = "Halo {$catalog['store_name']}, saya ingin mengklaim Flash Deal {$hero['title']} ({$hero['subtitle']}) seharga Rp " . number_format($hero['promo_price'], 0, ',', '.') . ". Apakah stok masih tersedia?";
            @endphp
            <section class="pt-8 pb-12 lg:pt-14 lg:pb-16" id="promo">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg lg:gap-gutter items-center">
                    <!-- Left Column: Value Prop & Messaging -->
                    <div class="lg:col-span-7 flex flex-col gap-5">
                        <div class="inline-flex items-center gap-2 self-start px-3 py-1 bg-wood-ochre-light text-slate-charcoal border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111]">
                            <span class="material-symbols-outlined text-[18px]">local_fire_department</span>
                            <span class="font-label-code text-label-code font-bold uppercase tracking-wider">{{ $hero['badge'] }}</span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-slate-charcoal font-bold leading-tight uppercase tracking-tight">
                            Upgrade Komputer &amp; Laptop <span class="bg-wood-ochre-dark text-on-primary px-2 py-0.5">Tanpa Ribet</span>, Bergaransi Resmi.
                        </h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                            {{ $catalog['tagline'] }}. Solusi hardware terpercaya bagi Pelajar, Kantor, dan Gamer. Dapatkan unit teruji dengan instalasi software lengkap, garansi tukar baru, dan pemesanan instan langsung ke teknisi via WhatsApp.
                        </p>
                        <!-- Brutalist Badges Checklist -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                            <div class="p-3 bg-canvas-cream border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111] flex flex-col gap-1">
                                <div class="flex items-center gap-1.5 text-wood-ochre-dark font-bold font-headline-sm text-body-sm uppercase">
                                    <span class="material-symbols-outlined text-[20px]">verified</span>
                                    <span>Garansi Jelas</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Resmi &amp; ganti baru toko jika ada kendala pabrik.</p>
                            </div>
                            <div class="p-3 bg-canvas-cream border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111] flex flex-col gap-1">
                                <div class="flex items-center gap-1.5 text-wood-ochre-dark font-bold font-headline-sm text-body-sm uppercase">
                                    <span class="material-symbols-outlined text-[20px]">support_agent</span>
                                    <span>Konsultasi 1-on-1</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Bicara langsung dengan teknisi, bukan bot kaku.</p>
                            </div>
                            <div class="p-3 bg-canvas-cream border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111] flex flex-col gap-1">
                                <div class="flex items-center gap-1.5 text-wood-ochre-dark font-bold font-headline-sm text-body-sm uppercase">
                                    <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                                    <span>Siap Kirim Cepat</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Packing busa &amp; kayu aman sampai tujuan.</p>
                            </div>
                        </div>
                        <!-- CTAs -->
                        <div class="flex flex-wrap items-center gap-4 pt-3">
                            <a class="inline-flex items-center justify-center px-6 py-3.5 bg-primary-container hover:bg-wood-ochre-light text-slate-charcoal font-headline-sm text-body-md font-bold uppercase border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all"
                               href="#katalog">
                                <span class="material-symbols-outlined mr-2">inventory_2</span>Lihat Katalog Lengkap
                            </a>
                            <a class="inline-flex items-center justify-center px-6 py-3.5 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-md font-bold uppercase border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all"
                               href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya ingin konsultasi spesifikasi komputer/laptop sesuai budget saya') }}"
                               rel="noopener noreferrer" target="_blank">
                                <span class="material-symbols-outlined mr-2">chat</span>Tanya Admin WA
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Hero Spotlight Flash Deal Card -->
                    <div class="lg:col-span-5">
                        <div class="bg-wood-ochre-dark p-2 border-[3px] border-canvas-border shadow-[6px_6px_0px_#111111]">
                            <div class="bg-surface-container-lowest p-5 border-[2px] border-canvas-border flex flex-col gap-4">
                                <!-- Top Alert Bar -->
                                <div class="flex items-center justify-between gap-2 border-b-[2px] border-canvas-border pb-3">
                                    <span class="px-2.5 py-1 bg-danger-coral text-on-error font-label-code text-label-code font-bold uppercase border border-canvas-border">
                                        STOK TERBATAS
                                    </span>
                                    <span class="px-2.5 py-1 bg-wood-ochre-light text-slate-charcoal font-label-code text-label-code font-bold uppercase border border-canvas-border">
                                        HEMAT RP {{ number_format($heroSave, 0, ',', '.') }}
                                    </span>
                                </div>
                                <!-- Product Visual Preview -->
                                <div class="relative bg-canvas-cream border-[2px] border-canvas-border overflow-hidden p-3 flex flex-col items-center justify-center">
                                    <div class="absolute top-2 left-2 z-10 px-2 py-0.5 bg-slate-charcoal text-surface text-[10px] font-label-code uppercase tracking-wider font-bold">
                                        BEST SELLER
                                    </div>
                                    <img class="w-full h-44 object-cover border border-canvas-border"
                                         alt="{{ $hero['title'] }}"
                                         src="{{ $heroImage }}"/>
                                    <div class="w-full flex items-center justify-between mt-2 pt-2 border-t border-canvas-border font-label-spec text-label-spec uppercase text-on-surface-variant font-bold">
                                        <span>FLASH DEAL UNGGULAN</span>
                                        <span>100% Baru + Segel Toko</span>
                                    </div>
                                </div>
                                <!-- Title & Specs -->
                                <div class="flex flex-col gap-1.5">
                                    <h3 class="font-headline-sm text-headline-sm font-bold text-slate-charcoal uppercase leading-snug mb-0">
                                        {{ $hero['title'] }}
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">{{ $hero['subtitle'] }}</p>
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        @foreach ($heroSpecs as $hSpec)
                                            <span class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec text-slate-charcoal uppercase">{{ $hSpec }}</span>
                                        @endforeach
                                        <span class="px-2 py-0.5 bg-wood-ochre-light border border-canvas-border font-label-spec text-label-spec text-slate-charcoal uppercase">{{ $hero['bonus'] }}</span>
                                    </div>
                                </div>
                                <!-- Price Box -->
                                <div class="p-3 bg-surface-container-low border-[2px] border-canvas-border flex flex-col gap-0.5">
                                    <span class="font-label-code text-label-code text-strike-muted line-through font-semibold">
                                        Harga Normal: Rp {{ number_format($hero['original_price'], 0, ',', '.') }}
                                    </span>
                                    <div class="flex items-baseline justify-between">
                                        <span class="font-price-hero text-price-hero font-bold text-wood-ochre-dark">
                                            Rp {{ number_format($hero['promo_price'], 0, ',', '.') }}
                                        </span>
                                        <span class="font-label-spec text-label-spec uppercase bg-whatsapp-green text-slate-charcoal font-bold px-1.5 py-0.5 border border-canvas-border">PROMO FLASH DEAL</span>
                                    </div>
                                </div>
                                <!-- Claim Button -->
                                <a id="hero-wa-cta"
                                   class="w-full inline-flex items-center justify-center p-3 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-md font-bold uppercase border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all tracking-wider text-center"
                                   href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode($heroWaText) }}"
                                   rel="noopener noreferrer" target="_blank">
                                    <span class="material-symbols-outlined mr-2">shopping_bag</span>Klaim Promo Flash Deal via WA
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TRUST STATS STRIP -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 py-6 my-2 border-y-[2.5px] border-canvas-border bg-canvas-cream">
                <div class="flex flex-col items-center justify-center text-center p-2">
                    <span class="font-headline-lg text-headline-lg font-bold text-wood-ochre-dark">3.800+</span>
                    <span class="font-label-code text-label-code uppercase text-on-surface font-bold">Unit Terjual</span>
                </div>
                <div class="flex flex-col items-center justify-center text-center p-2 border-l-2 border-canvas-border md:border-l-2">
                    <span class="font-headline-lg text-headline-lg font-bold text-wood-ochre-dark">100%</span>
                    <span class="font-label-code text-label-code uppercase text-on-surface font-bold">Garansi Resmi</span>
                </div>
                <div class="flex flex-col items-center justify-center text-center p-2 border-t-2 border-canvas-border md:border-t-0 md:border-l-2">
                    <span class="font-headline-lg text-headline-lg font-bold text-wood-ochre-dark">&lt; 5 Menit</span>
                    <span class="font-label-code text-label-code uppercase text-on-surface font-bold">Respon WA Cepat</span>
                </div>
                <div class="flex flex-col items-center justify-center text-center p-2 border-t-2 md:border-t-0 border-l-2 border-canvas-border">
                    <span class="font-headline-lg text-headline-lg font-bold text-wood-ochre-dark">0 Biaya</span>
                    <span class="font-label-code text-label-code uppercase text-on-surface font-bold">Free Setup &amp; OS</span>
                </div>
            </div>

            <!-- KATALOG PRODUK & INTERACTIVE SPEC VARIANT SELECTOR (PRD 4.3 & 4.4) -->
            <section class="py-12 lg:py-16 flex flex-col gap-8" id="katalog">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b-[3px] border-canvas-border pb-6">
                    <div class="flex flex-col gap-2">
                        <div class="inline-flex items-center gap-1.5 self-start px-2 py-0.5 bg-wood-ochre-light text-slate-charcoal border border-canvas-border font-label-spec text-label-spec font-bold uppercase">
                            <span>KATALOG HARDWARE AKTIF</span>
                        </div>
                        <h2 class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                            PILIHAN PERANGKAT &amp; VARIAN SPEK
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mb-0">
                            Pilih spesifikasi yang sesuai dengan kebutuhan Anda. Harga dan draf pesan WhatsApp akan otomatis diperbarui saat Anda memilih varian RAM, SSD, atau jumlah unit.
                        </p>
                    </div>
                    <!-- Search Bar -->
                    <div class="w-full md:w-72">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                            <input class="w-full pl-10 pr-3 py-2 bg-surface-container-lowest border-[2px] border-canvas-border font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:shadow-[3px_3px_0px_#111111]"
                                   id="catalog-search" placeholder="Cari tipe/merek..." type="text"/>
                        </div>
                    </div>
                </div>

                <!-- Category Filter Pills (PRD 4.3) -->
                <div class="flex flex-wrap items-center gap-2 overflow-x-auto pb-2" id="category-filter-bar">
                    @foreach ($catalog['categories'] as $idx => $cat)
                        <button type="button"
                                class="category-btn px-4 py-2 {{ $idx === 0 ? 'bg-wood-ochre-light shadow-[3px_3px_0px_#111111]' : 'bg-canvas-cream shadow-[2px_2px_0px_#111111] hover:bg-wood-ochre-light' }} font-headline-sm text-body-sm font-bold text-slate-charcoal uppercase border-[2px] border-canvas-border transition-all"
                                data-cat="{{ $cat }}">
                            @if ($idx === 0)
                                ● SEMUA KATALOG ({{ count($catalog['products']) }})
                            @else
                                {{ $cat }}
                            @endif
                        </button>
                    @endforeach
                </div>

                <!-- PRODUCT CARDS GRID (PRD 4.3 & 4.4) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="product-grid">
                    @foreach ($catalog['products'] as $product)
                        @php
                            $firstVariant = $product['variants'][0];
                            $initialSave = max(0, (int) $firstVariant['original_price'] - (int) $firstVariant['promo_price']);
                            $images = $product['images'] ?? [$product['image']];
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
                        <div class="product-card flex flex-col bg-surface-container-lowest border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] {{ !empty($product['is_sold_out']) ? 'opacity-90' : '' }}"
                             data-brand="{{ $product['brand'] }}"
                             data-category="{{ $product['category'] }}"
                             data-title="{{ $product['name'] }}"
                             data-sold-out="{{ !empty($product['is_sold_out']) ? '1' : '0' }}">
                            <div class="relative bg-canvas-cream border-b-[2px] border-canvas-border p-3">
                                <span class="absolute top-5 left-5 z-20 px-2 py-0.5 bg-wood-ochre-dark text-on-primary font-label-code text-label-code font-bold uppercase border border-canvas-border">
                                    {{ $product['badge'] }}
                                </span>
                                @if (!empty($product['is_sold_out']))
                                    <span class="absolute top-5 right-5 z-20 px-2 py-0.5 bg-red-600 text-white font-label-code text-label-code font-bold uppercase border border-canvas-border shadow-[2px_2px_0px_#111111]">
                                        SOLD OUT
                                    </span>
                                @endif
                                @if (count($images) > 1)
                                    <div id="{{ $carouselId }}" class="carousel slide border border-canvas-border">
                                        <div class="carousel-inner">
                                            @foreach ($images as $imgIdx => $imgUrl)
                                                <div class="carousel-item {{ $imgIdx === 0 ? 'active' : '' }}">
                                                    <img src="{{ $imgUrl }}" class="d-block w-full h-48 object-cover" alt="{{ $product['name'] }} ({{ $imgIdx + 1 }})" loading="lazy"/>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon bg-slate-charcoal p-2 border border-canvas-border" aria-hidden="true"></span>
                                            <span class="visually-hidden">Sebelumnya</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon bg-slate-charcoal p-2 border border-canvas-border" aria-hidden="true"></span>
                                            <span class="visually-hidden">Berikutnya</span>
                                        </button>
                                    </div>
                                @else
                                    <img class="w-full h-48 object-cover border border-canvas-border"
                                         alt="{{ $product['name'] }}"
                                         src="{{ $images[0] }}"
                                         loading="lazy"/>
                                @endif
                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-canvas-border font-label-spec text-label-spec font-bold uppercase">
                                    <span class="text-on-surface-variant">{{ $product['category'] }} • {{ $product['brand'] }}</span>
                                    @if (!empty($product['is_sold_out']))
                                        <span class="text-red-700 bg-red-100 px-1 border border-red-300 font-bold">SOLD OUT</span>
                                    @else
                                        <span class="text-whatsapp-green-dark">UNIT READY STOCK</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4 flex flex-col flex-grow gap-3">
                                <h3 class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal mb-0">
                                    {{ $product['name'] }} ({{ $product['brand'] }})
                                </h3>
                                <!-- Monospace spec chips -->
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($product['specs'] as $spec)
                                        <span class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec">{{ $spec }}</span>
                                    @endforeach
                                </div>
                                <!-- Variant Selector -->
                                <div class="flex flex-col gap-1 pt-1">
                                    <label class="font-label-code text-label-code font-bold text-slate-charcoal uppercase">PILIH VARIAN SPESIFIKASI:</label>
                                    <select class="variant-select w-full p-2 bg-canvas-cream border-[2px] border-canvas-border font-body-sm text-body-sm font-semibold text-slate-charcoal focus:outline-none focus:shadow-[3px_3px_0px_#111111]">
                                        @foreach ($product['variants'] as $vIdx => $variant)
                                            @php
                                                $vSave = max(0, (int) $variant['original_price'] - (int) $variant['promo_price']);
                                            @endphp
                                            <option value="v{{ $vIdx }}"
                                                    data-label="{{ $variant['label'] }}"
                                                    data-price="{{ $variant['promo_price'] }}"
                                                    data-original="{{ $variant['original_price'] }}"
                                                    data-save="{{ $vSave }}"
                                                    {{ $vIdx === 0 ? 'selected' : '' }}>
                                                {{ $variant['label'] }} (Rp {{ number_format($variant['promo_price'], 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Dynamic Pricing Bar -->
                                <div class="p-3 bg-surface-container-low border-[2px] border-canvas-border flex flex-col gap-1 mt-auto">
                                    <div class="flex items-center justify-between">
                                        <span class="original-price font-label-code text-label-code text-strike-muted line-through font-semibold" data-role="original">
                                            Rp {{ number_format($firstVariant['original_price'], 0, ',', '.') }}
                                        </span>
                                        <span class="save-badge font-label-spec text-label-spec bg-wood-ochre-light px-1.5 py-0.5 border border-canvas-border uppercase font-bold" data-role="save">
                                            Hemat Rp {{ number_format($initialSave, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex items-baseline justify-between">
                                        <span class="promo-price font-price-catalog text-price-catalog font-bold text-slate-charcoal" data-role="promo">
                                            Rp {{ number_format($firstVariant['promo_price'], 0, ',', '.') }}
                                        </span>
                                        <span class="font-label-code text-label-code font-bold uppercase text-on-surface-variant">/ unit</span>
                                    </div>
                                </div>
                                <!-- Quantity & WA CTA -->
                                <div class="flex items-center gap-2 pt-1">
                                    <div class="w-20">
                                        <label class="sr-only">Qty</label>
                                        <input class="qty-input w-full p-2.5 text-center bg-canvas-cream border-[2px] border-canvas-border font-label-code text-body-md font-bold focus:outline-none focus:shadow-[3px_3px_0px_#111111]"
                                               min="1" max="50" type="number" value="1"/>
                                    </div>
                                    @if (!empty($product['is_sold_out']))
                                        <a class="wa-btn flex-1 inline-flex items-center justify-center p-2.5 bg-neutral-300 hover:bg-neutral-400 text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111] transition-all text-center"
                                           data-role="wa-link"
                                           href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', apakah produk ini bisa di-pre-order / restock: ' . $product['name'] . ' (' . $product['brand'] . ')') }}"
                                           rel="noopener noreferrer" target="_blank">
                                            <span class="material-symbols-outlined text-[18px] mr-1">history_toggle_off</span>Sold Out (Tanya Restock)
                                        </a>
                                    @else
                                        <a class="wa-btn flex-1 inline-flex items-center justify-center p-2.5 bg-whatsapp-green hover:bg-whatsapp-green-dark text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111] hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[4px_4px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111] transition-all text-center"
                                           data-role="wa-link"
                                           href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode($initialText) }}"
                                           rel="noopener noreferrer" target="_blank">
                                            <span class="material-symbols-outlined text-[18px] mr-1">chat</span>Pesan via WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Real-time Order Preview Box (PRD 4.4 Clarity) -->
                <div class="p-4 bg-slate-charcoal text-surface border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] mt-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-whatsapp-green text-slate-charcoal flex items-center justify-center font-bold border border-surface shrink-0">
                            <span class="material-symbols-outlined text-[24px]">sync_alt</span>
                        </div>
                        <div>
                            <h4 class="font-headline-sm text-body-md font-bold uppercase text-wood-ochre-light mb-0.5">
                                Mekanisme Order Instan WhatsApp
                            </h4>
                            <p class="font-body-sm text-body-sm text-surface-variant mb-0">
                                Setiap tombol WhatsApp di atas langsung terhubung ke admin dengan template rapi berisi produk, varian, dan total harga pesanan Anda.
                            </p>
                        </div>
                    </div>
                    <div class="font-label-code text-label-code text-wood-ochre-light uppercase px-3 py-1 bg-slate-charcoal border border-wood-ochre-dark shrink-0">
                        ⚡ TANPA REGISTER • PROSES CEPAT
                    </div>
                </div>
            </section>

            <!-- KEUNGGULAN JAVA COMPUTER (WHY US) -->
            <section class="py-12 border-t-[3px] border-canvas-border" id="tentang-kami">
                <div class="flex flex-col gap-2 mb-8">
                    <span class="font-label-spec text-label-spec text-wood-ochre-dark font-bold uppercase tracking-wider">MENGAPA BELANJA DI SINI?</span>
                    <h2 class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                        {{ $catalog['about_title'] ?? ('KEUNGGULAN ' . strtoupper($catalog['store_name'])) }}
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mb-0">
                        {{ $catalog['about_subtitle'] ?? 'Kami bukan sekadar penjual e-commerce biasa. Kami bengkel hardware dan pusat konsultasi komputer fisik yang beroperasi nyata setiap hari.' }}
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ($catalog['about_features'] ?? [] as $feat)
                        <div class="bg-surface-container-lowest p-5 border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col gap-3">
                            <div class="w-12 h-12 bg-wood-ochre-light border-[2px] border-canvas-border flex items-center justify-center text-slate-charcoal">
                                <span class="material-symbols-outlined text-[28px]">{{ $feat['icon'] ?? 'verified_user' }}</span>
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
            </section>

            <!-- TESTIMONI & BUKTI PENGIRIMAN -->
            <section class="py-12 border-t-[3px] border-canvas-border">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div class="flex flex-col gap-2">
                        <span class="font-label-spec text-label-spec text-wood-ochre-dark font-bold uppercase tracking-wider">KEPUASAN PELANGGAN</span>
                        <h2 class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                            KATA MEREKA TENTANG KAMI
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                            Ulasan asli dari pelajar, pelaku UMKM kantor, dan gamer seputar pelayanan {{ $catalog['store_name'] }}.
                        </p>
                    </div>
                    <div class="p-2.5 bg-canvas-cream border-[2px] border-canvas-border shadow-[2px_2px_0px_#111111]">
                        <span class="font-label-code text-label-code font-bold uppercase text-slate-charcoal">★ 4.9 / 5.0 RATING GOOGLE REVIEWS</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Review 1 -->
                    <div class="bg-surface-container-lowest p-5 border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col justify-between gap-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex text-wood-ochre-dark">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="font-body-md text-body-md text-slate-charcoal font-medium italic mb-0">
                                "Pesan PC Rakitan Ryzen 5 untuk editing dan skripsi kuliah. Sore deal via WA, malam langsung dikirim tes benchmark dan game lancar jaya. Mantap teknisi Java Computer!"
                            </p>
                        </div>
                        <div class="border-t border-canvas-border pt-3 flex items-center justify-between">
                            <div>
                                <div class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">Rian Pratama</div>
                                <div class="font-label-code text-label-code text-on-surface-variant">Mahasiswa &amp; Content Creator</div>
                            </div>
                            <span class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec font-bold">VERIFIED</span>
                        </div>
                    </div>
                    <!-- Review 2 -->
                    <div class="bg-surface-container-lowest p-5 border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col justify-between gap-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex text-wood-ochre-dark">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="font-body-md text-body-md text-slate-charcoal font-medium italic mb-0">
                                "Beli 3 unit PC Desktop kantor sekaligus printer Epson EcoTank. Semuanya siap pakai tinggal colok listrik. Faktur toko dan garansi rapi banget. Rekomendasi kantor!"
                            </p>
                        </div>
                        <div class="border-t border-canvas-border pt-3 flex items-center justify-between">
                            <div>
                                <div class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">Hendra Kurniawan</div>
                                <div class="font-label-code text-label-code text-on-surface-variant">Manager Operasional CV Logistik</div>
                            </div>
                            <span class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec font-bold">VERIFIED</span>
                        </div>
                    </div>
                    <!-- Review 3 -->
                    <div class="bg-surface-container-lowest p-5 border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col justify-between gap-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex text-wood-ochre-dark">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="font-body-md text-body-md text-slate-charcoal font-medium italic mb-0">
                                "Klaim promo laptop via WhatsApp super gampang, gak perlu muter-muter bikin akun. Ditambahin bonus menarik. Admin ramah dan komunikatif."
                            </p>
                        </div>
                        <div class="border-t border-canvas-border pt-3 flex items-center justify-between">
                            <div>
                                <div class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">Dimas Anggoro</div>
                                <div class="font-label-code text-label-code text-on-surface-variant">Gamer &amp; Pengguna Pribadi</div>
                            </div>
                            <span class="px-2 py-0.5 bg-surface-container-high border border-canvas-border font-label-spec text-label-spec font-bold">VERIFIED</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- LOKASI TOKO, JAM BUKA & FAQ (PRD SECTION 4.1 & SECTION 6) -->
            <section class="py-12 border-t-[3px] border-canvas-border" id="kontak">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                    <!-- Store Location Details & Map Preview -->
                    <div class="lg:col-span-6 flex flex-col gap-5">
                        <div class="flex flex-col gap-1.5">
                            <span class="font-label-spec text-label-spec text-wood-ochre-dark font-bold uppercase tracking-wider">LOKASI WORKSHOP KAMI</span>
                            <h2 class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                {{ $catalog['contact_title'] ?? 'KUNJUNGI TOKO FISIK' }}
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                {{ $catalog['contact_subtitle'] ?? 'Mau cek fisik barang sebelum beli atau konsultasi spek langsung ke teknisi kami? Silakan mampir ke workshop kami.' }}
                            </p>
                        </div>
                        <!-- Location Information Box -->
                        <div class="p-4 bg-canvas-cream border-[2.5px] border-canvas-border shadow-[4px_4px_0px_#111111] flex flex-col gap-3">
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-wood-ochre-dark mt-0.5">location_on</span>
                                <div>
                                    <div class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">Alamat Workshop Utama:</div>
                                    <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                        {{ $catalog['address'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5 border-t border-canvas-border pt-2.5">
                                <span class="material-symbols-outlined text-wood-ochre-dark mt-0.5">schedule</span>
                                <div>
                                    <div class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">Jam Buka Toko Fisik &amp; CS:</div>
                                    <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                        {{ $catalog['hours'] }} (Tetap Melayani Chat WA)
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5 border-t border-canvas-border pt-2.5">
                                <span class="material-symbols-outlined text-wood-ochre-dark mt-0.5">phone_iphone</span>
                                <div>
                                    <div class="font-headline-sm text-body-sm font-bold uppercase text-slate-charcoal">Kontak WhatsApp Langsung:</div>
                                    <p class="font-body-md text-body-md text-on-surface-variant font-bold mb-0">
                                        +{{ $catalog['whatsapp_number'] }} (Admin {{ $catalog['store_name'] }})
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Map Component -->
                        @php
                            $mapSrc = $catalog['map_image'] ?? 'https://maps.google.com/maps?q=-7.3425692,108.1080775&hl=id&z=17&output=embed';
                            $mapLink = $catalog['map_link'] ?? 'https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8';
                            $isIframe = str_contains($mapSrc, 'maps.google.com') || str_contains($mapSrc, 'output=embed');
                        @endphp
                        <div class="relative w-full h-60 border-[2.5px] border-canvas-border shadow-[3px_3px_0px_#111111] overflow-hidden bg-canvas-cream">
                            @if ($isIframe)
                                <iframe src="{{ $mapSrc }}"
                                        class="w-full h-full border-0"
                                        loading="lazy"
                                        allowfullscreen
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Lokasi Toko"></iframe>
                            @else
                                <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ $mapSrc }}');"></div>
                            @endif
                            <a href="{{ $mapLink }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="absolute bottom-2 right-2 px-2.5 py-1.5 bg-wood-ochre-light text-slate-charcoal font-label-code text-label-code font-bold uppercase border-2 border-canvas-border shadow-[2px_2px_0px_#111111] hover:bg-white transition-colors flex items-center gap-1.5 z-10">
                                <span class="material-symbols-outlined text-[16px]">location_on</span>
                                <span>Buka Google Maps</span>
                            </a>
                        </div>
                    </div>

                    <!-- FAQ Accordion -->
                    <div class="lg:col-span-6 flex flex-col gap-4">
                        <div class="flex flex-col gap-1.5">
                            <span class="font-label-spec text-label-spec text-wood-ochre-dark font-bold uppercase tracking-wider">PERTANYAAN UMUM</span>
                            <h2 class="font-headline-lg text-headline-lg font-bold uppercase text-slate-charcoal mb-0">
                                FAQ PEMBELIAN &amp; SERVICE
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-0">
                                Semua yang perlu Anda ketahui mengenai pemesanan, pembayaran, dan proteksi garansi.
                            </p>
                        </div>
                        <!-- Accordion Items -->
                        <div class="flex flex-col gap-3 pt-1" id="faq-container">
                            @foreach ($catalog['faqs'] ?? [] as $fIdx => $faq)
                                <div class="faq-item bg-surface-container-lowest border-[2px] border-canvas-border shadow-[3px_3px_0px_#111111]">
                                    <button type="button" class="faq-toggle w-full p-3.5 text-left font-headline-sm text-body-md font-bold uppercase text-slate-charcoal flex items-center justify-between">
                                        <span>{{ $faq['q'] }}</span>
                                        <span class="material-symbols-outlined transition-transform duration-200">{{ $fIdx === 0 ? 'expand_less' : 'expand_more' }}</span>
                                    </button>
                                    <div class="faq-answer px-3.5 pb-3.5 pt-2 text-on-surface-variant font-body-sm text-body-sm border-t border-canvas-border {{ $fIdx === 0 ? '' : 'hidden' }}">
                                        {{ $faq['a'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
                </div>
            </section>
        </div>

        <!-- STICKY FLOATING WHATSAPP ACTION BUTTON FOR MOBILE -->
        <div class="lg:hidden fixed bottom-4 right-4 z-40">
            <a class="flex items-center gap-2 px-4 py-3 bg-whatsapp-green text-slate-charcoal font-headline-sm text-body-sm font-bold uppercase border-[3px] border-canvas-border shadow-[4px_4px_0px_#111111] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[1px_1px_0px_#111111]"
               href="https://wa.me/{{ $catalog['whatsapp_number'] }}?text={{ urlencode('Halo ' . $catalog['store_name'] . ', saya tertarik melihat katalog dan ingin tanya stok laptop/PC') }}"
               rel="noopener noreferrer" target="_blank">
                <span class="material-symbols-outlined text-[22px]">chat</span>
                <span>Chat Java WA</span>
            </a>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="w-full bg-canvas-cream border-t-[3px] border-canvas-border mt-space-xl">
    <div class="max-w-[1320px] mx-auto px-margin-mobile lg:px-margin py-space-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-lg mb-space-xl">
            <div class="flex flex-col gap-space-sm">
                <div class="font-headline-md text-headline-md font-bold uppercase text-slate-charcoal">{{ $catalog['store_name'] }}</div>
                <p class="font-body-md text-body-md text-on-surface-variant mb-0">{{ $catalog['tagline'] }}. Pusat penjualan laptop, perakitan PC, monitor, printer &amp; aksesoris komputer terpercaya dengan garansi resmi dan konsultasi teknisi langsung.</p>
                <div class="inline-flex items-center gap-2 mt-space-xs">
                    <span class="w-3 h-3 bg-whatsapp-green border border-canvas-border inline-block"></span>
                    <span class="font-label-code text-label-code font-bold uppercase text-on-surface">Toko Fisik &amp; Service Center Aktif</span>
                </div>
            </div>
            <div class="flex flex-col gap-space-sm">
                <h3 class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal border-b-2 border-canvas-border pb-1 mb-0">Jam Operasional</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant font-medium mb-1">{{ $catalog['hours'] }}</p>
                <div class="p-2.5 bg-surface-container-high border-2 border-canvas-border shadow-[2px_2px_0px_#111111] mt-space-xs">
                    <p class="font-label-spec text-label-spec text-on-surface font-bold uppercase mb-0">Layanan Rakit &amp; Antar Hari yang Sama</p>
                </div>
            </div>
            <div class="flex flex-col gap-space-sm">
                <h3 class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal border-b-2 border-canvas-border pb-1 mb-0">Navigasi Cepat</h3>
                <nav class="flex flex-col gap-space-xs font-body-sm text-body-sm font-semibold">
                    <a class="text-on-surface-variant hover:text-wood-ochre-dark hover:underline transition-colors uppercase" href="#promo">Katalog Promo Spesial</a>
                    <a class="text-on-surface-variant hover:text-wood-ochre-dark hover:underline transition-colors uppercase" href="#katalog">Laptop &amp; PC Gaming</a>
                    <a class="text-on-surface-variant hover:text-wood-ochre-dark hover:underline transition-colors uppercase" href="#tentang-kami">Profil {{ $catalog['store_name'] }}</a>
                    <a class="text-on-surface-variant hover:text-wood-ochre-dark hover:underline transition-colors uppercase" href="#kontak">Lokasi &amp; Service Center</a>
                </nav>
            </div>
            <div class="flex flex-col gap-space-sm">
                <h3 class="font-headline-sm text-headline-sm font-bold uppercase text-slate-charcoal border-b-2 border-canvas-border pb-1 mb-0">Hotline WhatsApp</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-0">Tanya stok, custom rakitan PC, atau klaim garansi via chat admin kami:</p>
                <a class="inline-flex items-center justify-center p-3 bg-whatsapp-green text-slate-charcoal border-2 border-canvas-border shadow-[3px_3px_0px_#111111] hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[4px_4px_0px_#111111] transition-all font-headline-sm text-headline-sm font-bold uppercase tracking-wider"
                   href="https://wa.me/{{ $catalog['whatsapp_number'] }}" rel="noopener noreferrer" target="_blank">
                    <span class="material-symbols-outlined mr-2">chat</span>+{{ $catalog['whatsapp_number'] }}
                </a>
                <span class="font-label-code text-label-code text-on-surface-variant uppercase">Respon rata-rata: &lt; 5 Menit</span>
            </div>
        </div>
        <div class="border-t-2 border-canvas-border pt-space-md flex flex-col md:flex-row items-center justify-between gap-space-sm font-label-code text-label-code text-on-surface-variant">
            <p class="mb-0">© {{ date('Y') }} {{ strtoupper($catalog['store_name']) }}. SEMUA HAK DILINDUNGI.</p>
            <div class="flex items-center gap-3">
                <span class="font-bold uppercase text-on-surface">INDUSTRIAL BRUTALIST HARDWARE DESK</span>
                <span>•</span>
                <a href="/admin" class="font-bold uppercase text-wood-ochre-dark hover:underline">PANEL ADMIN</a>
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

    function updateCardPricing(card) {
        const title = card.getAttribute('data-title');
        const brand = card.getAttribute('data-brand');
        const select = card.querySelector('.variant-select');
        const qtyInput = card.querySelector('.qty-input');
        const originalEl = card.querySelector('.original-price');
        const promoEl = card.querySelector('.promo-price');
        const saveBadge = card.querySelector('.save-badge');
        const waBtn = card.querySelector('.wa-btn');

        if (!select || !qtyInput || !waBtn) return;

        const selectedOption = select.options[select.selectedIndex];
        const label = selectedOption.getAttribute('data-label') || selectedOption.text;
        const price = parseInt(selectedOption.getAttribute('data-price'), 10) || 0;
        const originalPrice = parseInt(selectedOption.getAttribute('data-original'), 10) || 0;
        const saveAmount = parseInt(selectedOption.getAttribute('data-save'), 10) || Math.max(0, originalPrice - price);
        const qty = Math.max(1, parseInt(qtyInput.value, 10) || 1);
        const totalPrice = price * qty;

        if (originalEl) originalEl.textContent = formatRupiah(originalPrice);
        if (promoEl) promoEl.textContent = formatRupiah(price);
        if (saveBadge) saveBadge.textContent = 'Hemat ' + formatRupiah(saveAmount);

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

    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card) => {
        const select = card.querySelector('.variant-select');
        const qtyInput = card.querySelector('.qty-input');
        if (select) select.addEventListener('change', () => updateCardPricing(card));
        if (qtyInput) {
            qtyInput.addEventListener('input', () => updateCardPricing(card));
            qtyInput.addEventListener('change', () => updateCardPricing(card));
        }
        updateCardPricing(card);
    });

    let activeCat = 'Semua';
    const searchInput = document.getElementById('catalog-search');
    const filterBtns = document.querySelectorAll('.category-btn');

    function applyFilter() {
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        productCards.forEach((card) => {
            const cardCat = card.getAttribute('data-category');
            const matchCat = activeCat === 'Semua' || cardCat === activeCat;
            const matchQuery = !query || card.textContent.toLowerCase().includes(query);
            card.style.display = (matchCat && matchQuery) ? 'flex' : 'none';
        });
    }

    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterBtns.forEach((b) => {
                b.classList.remove('bg-wood-ochre-light', 'shadow-[3px_3px_0px_#111111]');
                b.classList.add('bg-canvas-cream', 'shadow-[2px_2px_0px_#111111]');
            });
            btn.classList.remove('bg-canvas-cream', 'shadow-[2px_2px_0px_#111111]');
            btn.classList.add('bg-wood-ochre-light', 'shadow-[3px_3px_0px_#111111]');
            activeCat = btn.getAttribute('data-cat') || 'Semua';
            applyFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }

    const faqToggles = document.querySelectorAll('.faq-toggle');
    faqToggles.forEach((btn) => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = btn.querySelector('.material-symbols-outlined');
            const isHidden = answer.classList.contains('hidden');

            document.querySelectorAll('.faq-answer').forEach((ans) => ans.classList.add('hidden'));
            document.querySelectorAll('.faq-toggle .material-symbols-outlined').forEach((ic) => ic.textContent = 'expand_more');

            if (isHidden) {
                answer.classList.remove('hidden');
                if (icon) icon.textContent = 'expand_less';
            }
        });
    });
})();
</script>
</body>
</html>
