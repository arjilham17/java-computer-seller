(function () {
    'use strict';

    // shortcut: uses native browser Canvas + MediaRecorder (real-time 1x video duration, 0 server load); upgrade to server-side FFmpeg worker if batch multi-minute 4K rendering is ever needed
    const modalEl = document.getElementById('videoFrameModal');
    const canvas = document.getElementById('vf-canvas');
    if (!modalEl || !canvas) return;

    const cfg = window.ADMIN_VIDEO_FRAMER_CONFIG || {};
    const STORE_NAME = cfg.storeName || 'Java Computer Seller';
    const STORE_LOGO = cfg.storeLogo || null;
    const STORE_WA = cfg.storeWa || '6281234567890';
    const STORE_ADDRESS = cfg.storeAddress || '';
    const THEMES = cfg.themes || {};

    const els = {
        supportError: document.getElementById('vf-support-error'),
        videoInput: document.getElementById('vf-video-input'),
        aspectSelect: document.getElementById('vf-aspect-select'),
        qualitySelect: document.getElementById('vf-quality-select'),
        fitSelect: document.getElementById('vf-fit-select'),
        styleSelect: document.getElementById('vf-style-select'),
        themeSelect: document.getElementById('vf-theme-select'),
        customFrameWrap: document.getElementById('vf-custom-frame-wrap'),
        customFrameInput: document.getElementById('vf-custom-frame-input'),
        clearCustomFrame: document.getElementById('vf-clear-custom-frame'),
        productPreset: document.getElementById('vf-product-preset'),
        badgeText: document.getElementById('vf-badge-text'),
        titleText: document.getElementById('vf-title-text'),
        footerText: document.getElementById('vf-footer-text'),
        includeAudio: document.getElementById('vf-include-audio'),
        previewToggle: document.getElementById('vf-preview-toggle'),
        formatBadge: document.getElementById('vf-format-badge'),
        videoMeta: document.getElementById('vf-video-meta'),
        durationWarn: document.getElementById('vf-duration-warn'),
        progressWrap: document.getElementById('vf-progress-wrap'),
        progressBar: document.getElementById('vf-progress-bar'),
        progressPct: document.getElementById('vf-progress-pct'),
        progressDetail: document.getElementById('vf-progress-detail'),
        resultWrap: document.getElementById('vf-result-wrap'),
        resultMeta: document.getElementById('vf-result-meta'),
        resultVideo: document.getElementById('vf-result-video'),
        downloadBtn: document.getElementById('vf-download-btn'),
        shareBtn: document.getElementById('vf-share-btn'),
        renderBtn: document.getElementById('vf-render-btn'),
        cancelBtn: document.getElementById('vf-cancel-btn'),
        resetBtn: document.getElementById('vf-reset-btn'),
    };

    const ctx = canvas.getContext('2d');
    const previewVideo = document.createElement('video');
    previewVideo.playsInline = true;
    previewVideo.preload = 'auto';
    previewVideo.loop = true;

    let videoObjectUrl = null;
    let videoFileName = 'video';
    let videoDuration = 0;
    let videoNaturalW = 0;
    let videoNaturalH = 0;
    let customFrameUrl = null;
    let customFrameImg = null;
    let logoImg = null;
    let outputObjectUrl = null;
    let outputBlob = null;
    let outputFileName = 'framed-video.mp4';

    let previewRafId = null;
    let isRendering = false;
    let cancelRequested = false;
    let activeRecorder = null;
    let activeExportVideo = null;
    let activeAudioCtx = null;
    let activeExportRafId = null;
    let activeStreams = [];

    const DEFAULT_THEME = {
        canvasBg: '#FCF9F3',
        frameBorder: '#111111',
        shadowHex: '#111111',
        headerBg: '#F3ECE1',
        headerText: '#1A1A1A',
        headerSubText: '#57534E',
        headerSub: 'PUSAT KOMPUTER, LAPTOP & HARDWARE RESMI',
        stripBg: '#E5AC67',
        stripText: '#1A1A1A',
        brandColor: '#825514',
        titleColor: '#1A1A1A',
        promoBg: '#22C55E',
        promoText: '#1A1A1A',
        footerBg: '#F3ECE1',
        waColor: '#15803D',
    };

    function pickSupportedMimeType() {
        if (typeof window.MediaRecorder === 'undefined' || typeof canvas.captureStream !== 'function') {
            return null;
        }
        const candidates = [
            { mimeType: 'video/mp4;codecs=avc1.42E01E,mp4a.40.2', ext: 'mp4', label: 'MP4 (H.264)' },
            { mimeType: 'video/mp4;codecs=avc1.42E01E', ext: 'mp4', label: 'MP4 (H.264)' },
            { mimeType: 'video/mp4', ext: 'mp4', label: 'MP4' },
            { mimeType: 'video/webm;codecs=vp9,opus', ext: 'webm', label: 'WebM (VP9)' },
            { mimeType: 'video/webm;codecs=vp8,opus', ext: 'webm', label: 'WebM (VP8)' },
            { mimeType: 'video/webm', ext: 'webm', label: 'WebM' },
        ];
        for (const item of candidates) {
            try {
                if (typeof MediaRecorder.isTypeSupported === 'function' && MediaRecorder.isTypeSupported(item.mimeType)) {
                    return item;
                }
            } catch (e) {}
        }
        return { mimeType: '', ext: 'webm', label: 'WebM (Default)' };
    }

    const supportedFormat = pickSupportedMimeType();
    if (!supportedFormat) {
        els.supportError?.classList.remove('d-none');
        if (els.formatBadge) els.formatBadge.textContent = 'Browser Tidak Mendukung';
    } else if (els.formatBadge) {
        els.formatBadge.textContent = `Output: .${supportedFormat.ext.toUpperCase()} (${supportedFormat.label})`;
    }

    if (STORE_LOGO) {
        const img = new Image();
        img.onload = () => {
            logoImg = img;
            if (!isRendering) drawCurrentPreview();
        };
        img.src = STORE_LOGO;
    }

    function getTheme() {
        const key = els.themeSelect?.value || 'default';
        return THEMES[key] || THEMES.default || DEFAULT_THEME;
    }

    function toEven(num) {
        return Math.max(2, Math.round(num / 2) * 2);
    }

    function computeCanvasSize() {
        const aspect = els.aspectSelect?.value || '9:16';
        const q = parseInt(els.qualitySelect?.value || '720', 10) >= 1080 ? 1080 : 720;

        if (aspect === '1:1') {
            const side = q === 1080 ? 1080 : 720;
            return { w: side, h: side };
        }
        if (aspect === '16:9') {
            return q === 1080 ? { w: 1920, h: 1080 } : { w: 1280, h: 720 };
        }
        if (aspect === 'original' && videoNaturalW > 0 && videoNaturalH > 0) {
            const shortSide = Math.min(videoNaturalW, videoNaturalH);
            const scale = shortSide > q ? q / shortSide : 1;
            let w = toEven(videoNaturalW * scale);
            let h = toEven(videoNaturalH * scale);
            const maxLong = q === 1080 ? 1920 : 1280;
            if (Math.max(w, h) > maxLong) {
                const s2 = maxLong / Math.max(w, h);
                w = toEven(w * s2);
                h = toEven(h * s2);
            }
            return { w, h };
        }
        return q === 1080 ? { w: 1080, h: 1920 } : { w: 720, h: 1280 };
    }

    function syncCanvasDimensions() {
        const { w, h } = computeCanvasSize();
        if (canvas.width !== w || canvas.height !== h) {
            canvas.width = w;
            canvas.height = h;
        }
        canvas.style.aspectRatio = `${w} / ${h}`;
        canvas.style.maxWidth = w > h ? '100%' : (w === h ? '350px' : '300px');
        return { w, h };
    }

    function fitTextFont(context, text, template, maxW, startPx, minPx) {
        let size = startPx;
        while (size > minPx) {
            context.font = template.replace('{size}', String(Math.round(size)));
            if (context.measureText(text).width <= maxW) break;
            size -= 1.5;
        }
        context.font = template.replace('{size}', String(Math.round(size)));
        return size;
    }

    function drawVideoIntoRect(context, videoEl, rect, fitMode, bgFill) {
        context.save();
        context.beginPath();
        context.rect(rect.x, rect.y, rect.w, rect.h);
        context.clip();

        context.fillStyle = bgFill;
        context.fillRect(rect.x, rect.y, rect.w, rect.h);

        if (videoEl && videoEl.readyState >= 2 && videoEl.videoWidth > 0 && videoEl.videoHeight > 0) {
            const vw = videoEl.videoWidth;
            const vh = videoEl.videoHeight;
            const scale = fitMode === 'cover'
                ? Math.max(rect.w / vw, rect.h / vh)
                : Math.min(rect.w / vw, rect.h / vh);
            const dw = vw * scale;
            const dh = vh * scale;
            const dx = rect.x + (rect.w - dw) / 2;
            const dy = rect.y + (rect.h - dh) / 2;
            context.drawImage(videoEl, dx, dy, dw, dh);
        } else {
            const u = Math.min(rect.w, rect.h);
            context.fillStyle = '#F3ECE1';
            context.fillRect(rect.x, rect.y, rect.w, rect.h);
            context.setLineDash([10, 8]);
            context.lineWidth = 3;
            context.strokeStyle = '#B87834';
            context.strokeRect(rect.x + 16, rect.y + 16, rect.w - 32, rect.h - 32);
            context.setLineDash([]);

            const boxW = Math.min(rect.w - 40, Math.round(u * 0.78));
            const boxH = Math.max(36, Math.round(u * 0.1));
            const bx = rect.x + (rect.w - boxW) / 2;
            const by = rect.y + (rect.h - boxH) / 2 - 12;
            context.fillStyle = '#1A1A1A';
            context.fillRect(bx, by, boxW, boxH);
            context.fillStyle = '#E5AC67';
            fitTextFont(context, '[ PILIH FILE VIDEO LOKAL ]', "bold {size}px 'JetBrains Mono', monospace", boxW - 20, Math.round(u * 0.042), 12);
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText('[ PILIH FILE VIDEO LOKAL ]', rect.x + rect.w / 2, by + boxH / 2 + 1, boxW - 16);
            context.textBaseline = 'alphabetic';
        }
        context.restore();
    }

    function drawLogoBox(context, x, y, size) {
        context.fillStyle = logoImg ? '#FFFFFF' : '#B87834';
        context.fillRect(x, y, size, size);
        context.lineWidth = Math.max(2, Math.round(size * 0.045));
        context.strokeStyle = '#111111';
        context.strokeRect(x, y, size, size);

        if (logoImg && logoImg.naturalWidth > 0) {
            const pad = Math.max(4, Math.round(size * 0.1));
            const maxW = size - pad * 2;
            const maxH = size - pad * 2;
            const s = Math.min(maxW / logoImg.naturalWidth, maxH / logoImg.naturalHeight);
            const dw = logoImg.naturalWidth * s;
            const dh = logoImg.naturalHeight * s;
            context.drawImage(logoImg, x + (size - dw) / 2, y + (size - dh) / 2, dw, dh);
        } else {
            context.fillStyle = '#FFFFFF';
            context.font = `bold ${Math.round(size * 0.44)}px 'Space Grotesk', sans-serif`;
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText('JC', x + size / 2, y + size / 2 + 1);
            context.textBaseline = 'alphabetic';
        }
    }

    function drawBrutalBox(context, x, y, w, h, fill, shadowColor, shadowOff, borderW) {
        if (shadowOff > 0) {
            context.fillStyle = shadowColor;
            context.fillRect(x + shadowOff, y + shadowOff, w, h);
        }
        context.fillStyle = fill;
        context.fillRect(x, y, w, h);
        context.lineWidth = borderW;
        context.strokeStyle = '#111111';
        context.strokeRect(x, y, w, h);
    }

    function drawVideoFrame(context, videoEl) {
        const W = canvas.width;
        const H = canvas.height;
        const u = Math.min(W, H);
        const theme = getTheme();
        const style = els.styleSelect?.value || 'full';
        const fitMode = els.fitSelect?.value || 'contain';
        const badgeStr = (els.badgeText?.value || '').trim();
        const titleStr = (els.titleText?.value || '').trim();
        const footerStr = (els.footerText?.value || '').trim();
        const borderW = Math.max(3, Math.round(u * 0.0055));
        const shadowOff = Math.max(4, Math.round(u * 0.009));
        const shadowHex = theme.shadowHex || '#111111';

        context.fillStyle = theme.canvasBg || '#FCF9F3';
        context.fillRect(0, 0, W, H);

        if (style === 'custom_png') {
            drawVideoIntoRect(context, videoEl, { x: 0, y: 0, w: W, h: H }, fitMode, '#111111');
            if (customFrameImg && customFrameImg.naturalWidth > 0) {
                context.drawImage(customFrameImg, 0, 0, W, H);
            }
            drawCompactOverlayTexts(context, W, H, u, theme, badgeStr, titleStr, footerStr, borderW, shadowHex);
            return;
        }

        if (style === 'minimal') {
            const pad = Math.max(12, Math.round(u * 0.024));
            context.lineWidth = Math.max(4, Math.round(u * 0.008));
            context.strokeStyle = theme.frameBorder || '#111111';
            context.strokeRect(pad / 2, pad / 2, W - pad, H - pad);

            const vRect = { x: pad, y: pad, w: W - pad * 2, h: H - pad * 2 };
            drawVideoIntoRect(context, videoEl, vRect, fitMode, '#141414');
            context.lineWidth = borderW;
            context.strokeStyle = '#111111';
            context.strokeRect(vRect.x, vRect.y, vRect.w, vRect.h);

            // Top-left watermark pill
            const wmPad = Math.max(10, Math.round(u * 0.02));
            const logoSz = Math.max(34, Math.round(u * 0.068));
            const wmX = vRect.x + wmPad;
            const wmY = vRect.y + wmPad;
            context.font = `bold ${Math.round(u * 0.028)}px 'Space Grotesk', sans-serif`;
            const nameW = Math.min(vRect.w * 0.45, context.measureText(STORE_NAME.toUpperCase()).width);
            const pillW = logoSz + nameW + wmPad * 1.4;
            drawBrutalBox(context, wmX, wmY, pillW, logoSz + 8, theme.headerBg || '#F3ECE1', shadowHex, 4, Math.max(2, borderW - 1));
            drawLogoBox(context, wmX + 4, wmY + 4, logoSz);
            context.fillStyle = theme.headerText || '#1A1A1A';
            context.textAlign = 'left';
            context.textBaseline = 'middle';
            fitTextFont(context, STORE_NAME.toUpperCase(), "bold {size}px 'Space Grotesk', sans-serif", nameW + 4, Math.round(u * 0.028), 11);
            context.fillText(STORE_NAME.toUpperCase(), wmX + logoSz + 12, wmY + (logoSz + 8) / 2 + 1, nameW + 4);
            context.textBaseline = 'alphabetic';

            // Top-right badge pill
            if (badgeStr) {
                context.font = `bold ${Math.round(u * 0.023)}px 'JetBrains Mono', monospace`;
                const bw = Math.min(vRect.w * 0.4, context.measureText(badgeStr.toUpperCase()).width + 24);
                const bh = Math.max(32, Math.round(u * 0.05));
                const bx = vRect.x + vRect.w - wmPad - bw;
                drawBrutalBox(context, bx, wmY + 4, bw, bh, theme.stripBg || '#E5AC67', shadowHex, 4, Math.max(2, borderW - 1));
                context.fillStyle = theme.stripText || '#1A1A1A';
                context.textAlign = 'center';
                context.textBaseline = 'middle';
                context.fillText(badgeStr.toUpperCase(), bx + bw / 2, wmY + 4 + bh / 2 + 1, bw - 14);
                context.textBaseline = 'alphabetic';
            }

            // Bottom floating CTA bar
            if (titleStr || footerStr) {
                const barH = Math.round(u * (titleStr && footerStr ? 0.135 : 0.085));
                const barW = vRect.w - wmPad * 2;
                const barX = vRect.x + wmPad;
                const barY = vRect.y + vRect.h - wmPad - barH;
                drawBrutalBox(context, barX, barY, barW, barH, theme.footerBg || '#F3ECE1', shadowHex, 5, Math.max(2, borderW - 1));

                context.textAlign = 'left';
                context.textBaseline = 'middle';
                if (titleStr && footerStr) {
                    context.fillStyle = theme.headerText || '#1A1A1A';
                    fitTextFont(context, titleStr.toUpperCase(), "bold {size}px 'Space Grotesk', sans-serif", barW - 28, Math.round(u * 0.036), 13);
                    context.fillText(titleStr.toUpperCase(), barX + 14, barY + barH * 0.34, barW - 28);

                    context.fillStyle = theme.waColor || '#15803D';
                    fitTextFont(context, footerStr, "bold {size}px 'JetBrains Mono', monospace", barW - 28, Math.round(u * 0.026), 11);
                    context.fillText(footerStr, barX + 14, barY + barH * 0.72, barW - 28);
                } else {
                    const solo = titleStr ? titleStr.toUpperCase() : footerStr;
                    context.fillStyle = titleStr ? (theme.headerText || '#1A1A1A') : (theme.waColor || '#15803D');
                    fitTextFont(context, solo, "bold {size}px 'Space Grotesk', sans-serif", barW - 28, Math.round(u * 0.034), 12);
                    context.fillText(solo, barX + 14, barY + barH / 2 + 1, barW - 28);
                }
                context.textBaseline = 'alphabetic';
            }
            return;
        }

        // STYLE: full (Industrial Brutalist Promo Frame)
        const pad = Math.max(18, Math.round(u * 0.04));
        const gap = Math.max(12, Math.round(u * 0.022));
        const innerW = W - pad * 2;

        // Outer border
        context.lineWidth = Math.max(5, Math.round(u * 0.009));
        context.strokeStyle = theme.frameBorder || '#111111';
        context.strokeRect(pad * 0.45, pad * 0.45, W - pad * 0.9, H - pad * 0.9);

        // Header bar
        const headerH = Math.round(H * (H >= W ? 0.105 : 0.145));
        const headerY = pad;
        drawBrutalBox(context, pad, headerY, innerW, headerH, theme.headerBg || '#F3ECE1', shadowHex, shadowOff, borderW);

        const logoSz = Math.round(headerH * 0.72);
        const logoX = pad + Math.round((headerH - logoSz) / 2);
        const logoY = headerY + Math.round((headerH - logoSz) / 2);
        drawLogoBox(context, logoX, logoY, logoSz);

        // Optional badge pill on top-right of header
        let rightReserved = 16;
        if (badgeStr) {
            const bFontPx = Math.max(11, Math.round(u * 0.022));
            context.font = `bold ${bFontPx}px 'JetBrains Mono', monospace`;
            const pillW = Math.min(innerW * 0.36, context.measureText(badgeStr.toUpperCase()).width + 24);
            const pillH = Math.round(headerH * 0.48);
            const pillX = pad + innerW - pillW - 14;
            const pillY = headerY + Math.round((headerH - pillH) / 2);
            drawBrutalBox(context, pillX, pillY, pillW, pillH, theme.stripBg || '#E5AC67', '#111111', 3, 2);
            context.fillStyle = theme.stripText || '#1A1A1A';
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText(badgeStr.toUpperCase(), pillX + pillW / 2, pillY + pillH / 2 + 1, pillW - 12);
            context.textBaseline = 'alphabetic';
            rightReserved = pillW + 26;
        }

        const textX = logoX + logoSz + Math.max(12, Math.round(u * 0.02));
        const textMaxW = Math.max(80, innerW - (textX - pad) - rightReserved);
        context.textAlign = 'left';
        context.textBaseline = 'middle';
        context.fillStyle = theme.headerText || '#1A1A1A';
        fitTextFont(context, STORE_NAME.toUpperCase(), "bold {size}px 'Space Grotesk', sans-serif", textMaxW, Math.round(headerH * 0.34), 13);
        context.fillText(STORE_NAME.toUpperCase(), textX, headerY + headerH * 0.36, textMaxW);

        context.fillStyle = theme.headerSubText || '#57534E';
        const subLabel = theme.headerSub || 'PUSAT KOMPUTER, LAPTOP & HARDWARE RESMI';
        fitTextFont(context, subLabel, "bold {size}px 'JetBrains Mono', monospace", textMaxW, Math.round(headerH * 0.19), 9);
        context.fillText(subLabel, textX, headerY + headerH * 0.72, textMaxW);
        context.textBaseline = 'alphabetic';

        // Footer bar
        const footerH = Math.round(H * (H >= W ? 0.145 : 0.18));
        const footerY = H - pad - footerH;
        drawBrutalBox(context, pad, footerY, innerW, footerH, theme.footerBg || '#F3ECE1', shadowHex, shadowOff, borderW);

        // Top accent strip inside footer
        const accentH = Math.max(8, Math.round(footerH * 0.11));
        context.fillStyle = theme.stripBg || '#E5AC67';
        context.fillRect(pad + borderW / 2, footerY + borderW / 2, innerW - borderW, accentH);
        context.beginPath();
        context.moveTo(pad, footerY + accentH + borderW / 2);
        context.lineTo(pad + innerW, footerY + accentH + borderW / 2);
        context.lineWidth = Math.max(2, borderW - 1);
        context.strokeStyle = '#111111';
        context.stroke();

        const ftInnerTop = footerY + accentH + 6;
        const ftInnerH = footerH - accentH - 10;
        const ftPadX = Math.max(14, Math.round(u * 0.025));
        const ftTextMaxW = innerW - ftPadX * 2;
        context.textAlign = 'left';
        context.textBaseline = 'middle';

        const headlineText = (titleStr || STORE_NAME).toUpperCase();
        context.fillStyle = theme.headerText || '#1A1A1A';
        fitTextFont(context, headlineText, "bold {size}px 'Space Grotesk', sans-serif", ftTextMaxW, Math.round(ftInnerH * 0.34), 14);
        context.fillText(headlineText, pad + ftPadX, ftInnerTop + ftInnerH * 0.28, ftTextMaxW);

        const ctaText = footerStr || `Order & Konsultasi WA: +${STORE_WA}`;
        context.fillStyle = theme.waColor || '#15803D';
        fitTextFont(context, ctaText, "bold {size}px 'JetBrains Mono', monospace", ftTextMaxW, Math.round(ftInnerH * 0.24), 11);
        context.fillText(ctaText, pad + ftPadX, ftInnerTop + ftInnerH * 0.63, ftTextMaxW);

        if (STORE_ADDRESS) {
            context.fillStyle = '#57534E';
            fitTextFont(context, STORE_ADDRESS, "600 {size}px 'Work Sans', sans-serif", ftTextMaxW, Math.round(ftInnerH * 0.16), 9);
            context.fillText(STORE_ADDRESS, pad + ftPadX, ftInnerTop + ftInnerH * 0.88, ftTextMaxW);
        }
        context.textBaseline = 'alphabetic';

        // Center Video Slot
        const videoY = headerY + headerH + gap;
        const videoH = Math.max(120, footerY - gap - videoY);
        const vRect = { x: pad, y: videoY, w: innerW, h: videoH };
        context.fillStyle = shadowHex;
        context.fillRect(vRect.x + shadowOff, vRect.y + shadowOff, vRect.w, vRect.h);
        drawVideoIntoRect(context, videoEl, vRect, fitMode, '#141414');
        context.lineWidth = borderW;
        context.strokeStyle = '#111111';
        context.strokeRect(vRect.x, vRect.y, vRect.w, vRect.h);
    }

    function drawCompactOverlayTexts(context, W, H, u, theme, badgeStr, titleStr, footerStr, borderW, shadowHex) {
        const pad = Math.max(16, Math.round(u * 0.03));
        if (badgeStr) {
            context.font = `bold ${Math.round(u * 0.025)}px 'JetBrains Mono', monospace`;
            const bw = Math.min(W - pad * 2, context.measureText(badgeStr.toUpperCase()).width + 26);
            const bh = Math.max(32, Math.round(u * 0.052));
            drawBrutalBox(context, pad, pad, bw, bh, theme.stripBg || '#E5AC67', shadowHex, 4, Math.max(2, borderW - 1));
            context.fillStyle = theme.stripText || '#1A1A1A';
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText(badgeStr.toUpperCase(), pad + bw / 2, pad + bh / 2 + 1, bw - 14);
            context.textBaseline = 'alphabetic';
        }
        if (titleStr || footerStr) {
            const barH = Math.round(u * (titleStr && footerStr ? 0.12 : 0.075));
            const barW = W - pad * 2;
            const barY = H - pad - barH;
            drawBrutalBox(context, pad, barY, barW, barH, theme.footerBg || '#F3ECE1', shadowHex, 4, Math.max(2, borderW - 1));
            context.textAlign = 'left';
            context.textBaseline = 'middle';
            if (titleStr && footerStr) {
                context.fillStyle = theme.headerText || '#1A1A1A';
                fitTextFont(context, titleStr.toUpperCase(), "bold {size}px 'Space Grotesk', sans-serif", barW - 24, Math.round(u * 0.034), 12);
                context.fillText(titleStr.toUpperCase(), pad + 12, barY + barH * 0.34, barW - 24);
                context.fillStyle = theme.waColor || '#15803D';
                fitTextFont(context, footerStr, "bold {size}px 'JetBrains Mono', monospace", barW - 24, Math.round(u * 0.024), 10);
                context.fillText(footerStr, pad + 12, barY + barH * 0.72, barW - 24);
            } else {
                const text = titleStr ? titleStr.toUpperCase() : footerStr;
                context.fillStyle = titleStr ? (theme.headerText || '#1A1A1A') : (theme.waColor || '#15803D');
                fitTextFont(context, text, "bold {size}px 'Space Grotesk', sans-serif", barW - 24, Math.round(u * 0.032), 12);
                context.fillText(text, pad + 12, barY + barH / 2 + 1, barW - 24);
            }
            context.textBaseline = 'alphabetic';
        }
    }

    function drawCurrentPreview() {
        syncCanvasDimensions();
        drawVideoFrame(ctx, videoObjectUrl ? previewVideo : null);
    }

    function stopPreviewPlayback() {
        if (previewRafId) {
            cancelAnimationFrame(previewRafId);
            previewRafId = null;
        }
        if (!previewVideo.paused) {
            previewVideo.pause();
        }
        if (els.previewToggle) {
            els.previewToggle.textContent = 'Putar Pratinjau';
        }
    }

    function startPreviewLoop() {
        if (isRendering || previewVideo.paused) return;
        drawVideoFrame(ctx, previewVideo);
        previewRafId = requestAnimationFrame(startPreviewLoop);
    }

    function setControlsLocked(locked) {
        [
            els.videoInput,
            els.aspectSelect,
            els.qualitySelect,
            els.fitSelect,
            els.styleSelect,
            els.themeSelect,
            els.customFrameInput,
            els.clearCustomFrame,
            els.productPreset,
            els.badgeText,
            els.titleText,
            els.footerText,
            els.includeAudio,
            els.previewToggle,
            els.resetBtn,
        ].forEach((el) => {
            if (el) el.disabled = locked;
        });
        if (els.renderBtn) {
            els.renderBtn.disabled = locked || !videoObjectUrl || !supportedFormat;
            els.renderBtn.textContent = locked ? 'Sedang Memproses Video...' : 'Proses & Buat Video Berbingkai';
        }
        els.cancelBtn?.classList.toggle('d-none', !locked);
    }

    function cleanupExportResources() {
        if (activeExportRafId) {
            cancelAnimationFrame(activeExportRafId);
            activeExportRafId = null;
        }
        if (activeExportVideo) {
            try {
                activeExportVideo.pause();
                activeExportVideo.removeAttribute('src');
                activeExportVideo.load();
            } catch (e) {}
            activeExportVideo = null;
        }
        activeStreams.forEach((stream) => {
            try {
                stream.getTracks().forEach((t) => t.stop());
            } catch (e) {}
        });
        activeStreams = [];
        if (activeAudioCtx) {
            try {
                activeAudioCtx.close();
            } catch (e) {}
            activeAudioCtx = null;
        }
        activeRecorder = null;
    }

    function cancelExport() {
        if (!isRendering) return;
        cancelRequested = true;
        if (activeRecorder && activeRecorder.state !== 'inactive') {
            try {
                activeRecorder.stop();
            } catch (e) {}
        }
        cleanupExportResources();
        isRendering = false;
        els.progressWrap?.classList.add('d-none');
        setControlsLocked(false);
        drawCurrentPreview();
    }

    async function startExport() {
        if (!videoObjectUrl || !supportedFormat || isRendering) return;

        stopPreviewPlayback();
        isRendering = true;
        cancelRequested = false;
        setControlsLocked(true);
        els.resultWrap?.classList.add('d-none');
        els.progressWrap?.classList.remove('d-none');
        updateProgressUI(0, 0, videoDuration);

        try {
            if (document.fonts && document.fonts.ready) {
                await Promise.race([
                    document.fonts.ready,
                    new Promise((resolve) => setTimeout(resolve, 1000)),
                ]);
            }
            if (cancelRequested) return;

            syncCanvasDimensions();

            const expVideo = document.createElement('video');
            expVideo.playsInline = true;
            expVideo.preload = 'auto';
            expVideo.src = videoObjectUrl;
            activeExportVideo = expVideo;

            await new Promise((resolve, reject) => {
                expVideo.onloadeddata = () => resolve();
                expVideo.onerror = () => reject(new Error('Gagal memuat ulang file video untuk ekspor.'));
                expVideo.load();
            });
            if (cancelRequested) return;

            const totalDur = Number.isFinite(expVideo.duration) && expVideo.duration > 0 ? expVideo.duration : videoDuration;
            expVideo.currentTime = 0;

            // Draw frame 0 immediately so stream starts crisp
            drawVideoFrame(ctx, expVideo);

            const canvasStream = canvas.captureStream(30);
            activeStreams.push(canvasStream);

            let recordStream = canvasStream;
            const wantAudio = Boolean(els.includeAudio?.checked);

            if (wantAudio) {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                if (AudioCtx) {
                    try {
                        const audioCtx = new AudioCtx();
                        activeAudioCtx = audioCtx;
                        if (audioCtx.state === 'suspended') {
                            await audioCtx.resume();
                        }
                        const srcNode = audioCtx.createMediaElementSource(expVideo);
                        const destNode = audioCtx.createMediaStreamDestination();
                        srcNode.connect(destNode);
                        activeStreams.push(destNode.stream);
                        const audioTracks = destNode.stream.getAudioTracks();
                        if (audioTracks.length > 0) {
                            recordStream = new MediaStream([
                                ...canvasStream.getVideoTracks(),
                                ...audioTracks,
                            ]);
                        }
                    } catch (audioErr) {
                        expVideo.muted = true;
                    }
                } else {
                    expVideo.muted = true;
                }
            } else {
                expVideo.muted = true;
            }

            const q = parseInt(els.qualitySelect?.value || '720', 10);
            const recorderOpts = {
                videoBitsPerSecond: q >= 1080 ? 6000000 : 3500000,
            };
            if (supportedFormat.mimeType) {
                recorderOpts.mimeType = supportedFormat.mimeType;
            }

            let recorder;
            try {
                recorder = new MediaRecorder(recordStream, recorderOpts);
            } catch (e) {
                // Fallback to video-only stream if browser rejects audio codec pairing
                recorder = new MediaRecorder(canvasStream, supportedFormat.mimeType ? { mimeType: supportedFormat.mimeType } : {});
            }
            activeRecorder = recorder;

            const chunks = [];
            recorder.ondataavailable = (ev) => {
                if (ev.data && ev.data.size > 0) {
                    chunks.push(ev.data);
                }
            };

            const exportDone = new Promise((resolve, reject) => {
                recorder.onerror = (ev) => reject(ev.error || new Error('Terjadi kendala saat merekam video.'));
                recorder.onstop = () => resolve();
            });

            recorder.start(250);
            await expVideo.play();

            const renderLoop = () => {
                if (cancelRequested || !activeExportVideo) return;
                drawVideoFrame(ctx, expVideo);
                const cur = expVideo.currentTime || 0;
                const pct = totalDur > 0 ? Math.min(99, Math.round((cur / totalDur) * 100)) : 50;
                updateProgressUI(pct, cur, totalDur);
                if (!expVideo.ended && !expVideo.paused) {
                    activeExportRafId = requestAnimationFrame(renderLoop);
                }
            };
            activeExportRafId = requestAnimationFrame(renderLoop);

            await new Promise((resolve) => {
                expVideo.onended = () => resolve();
            });

            if (!cancelRequested) {
                drawVideoFrame(ctx, expVideo);
                updateProgressUI(100, totalDur, totalDur);
                await new Promise((resolve) => setTimeout(resolve, 140));
                if (recorder.state !== 'inactive') {
                    recorder.stop();
                }
                await exportDone;
            }

            cleanupExportResources();

            if (!cancelRequested && chunks.length > 0) {
                const finalType = recorder.mimeType || supportedFormat.mimeType || `video/${supportedFormat.ext}`;
                const finalExt = finalType.includes('mp4') ? 'mp4' : 'webm';
                outputBlob = new Blob(chunks, { type: finalType });
                if (outputObjectUrl) URL.revokeObjectURL(outputObjectUrl);
                outputObjectUrl = URL.createObjectURL(outputBlob);

                const safeBase = videoFileName.replace(/\.[^.]+$/, '').replace(/[^a-zA-Z0-9_-]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 40) || 'video';
                const themeKey = els.themeSelect?.value || 'default';
                outputFileName = `framed-${safeBase}-${themeKey}.${finalExt}`;

                if (els.resultVideo) {
                    els.resultVideo.src = outputObjectUrl;
                    els.resultVideo.load();
                }
                if (els.downloadBtn) {
                    els.downloadBtn.href = outputObjectUrl;
                    els.downloadBtn.download = outputFileName;
                    els.downloadBtn.textContent = `Unduh Video (.${finalExt.toUpperCase()})`;
                }
                if (els.resultMeta) {
                    const mb = (outputBlob.size / (1024 * 1024)).toFixed(2);
                    els.resultMeta.textContent = `${finalExt.toUpperCase()} • ${mb} MB • ${canvas.width}x${canvas.height}`;
                }
                if (els.shareBtn) {
                    els.shareBtn.classList.toggle('d-none', !navigator.share);
                }
                els.resultWrap?.classList.remove('d-none');
            }
        } catch (err) {
            cleanupExportResources();
            if (!cancelRequested) {
                alert(`Gagal memproses video: ${err?.message || 'Coba format MP4 standar atau resolusi 720p.'}`);
            }
        } finally {
            isRendering = false;
            els.progressWrap?.classList.add('d-none');
            setControlsLocked(false);
            drawCurrentPreview();
        }
    }

    function updateProgressUI(pct, curSec, totalSec) {
        if (els.progressBar) {
            els.progressBar.style.width = `${pct}%`;
            els.progressBar.setAttribute('aria-valuenow', String(pct));
        }
        if (els.progressPct) {
            els.progressPct.textContent = `${pct}%`;
        }
        if (els.progressDetail) {
            const rem = Math.max(0, totalSec - curSec);
            els.progressDetail.textContent = `Waktu: ${curSec.toFixed(1)} / ${totalSec.toFixed(1)} dtk (sisa ~${rem.toFixed(0)} dtk). Jangan tutup tab ini.`;
        }
    }

    function resetAll() {
        cancelExport();
        stopPreviewPlayback();
        if (videoObjectUrl) {
            URL.revokeObjectURL(videoObjectUrl);
            videoObjectUrl = null;
        }
        if (outputObjectUrl) {
            URL.revokeObjectURL(outputObjectUrl);
            outputObjectUrl = null;
        }
        outputBlob = null;
        videoDuration = 0;
        videoNaturalW = 0;
        videoNaturalH = 0;
        previewVideo.removeAttribute('src');
        previewVideo.load();
        if (els.videoInput) els.videoInput.value = '';
        if (els.resultVideo) {
            els.resultVideo.removeAttribute('src');
            els.resultVideo.load();
        }
        els.resultWrap?.classList.add('d-none');
        els.durationWarn?.classList.add('d-none');
        if (els.previewToggle) els.previewToggle.disabled = true;
        if (els.renderBtn) els.renderBtn.disabled = true;
        if (els.videoMeta) els.videoMeta.textContent = 'Belum ada video dipilih. Video hanya diproses di perangkat Anda.';
        drawCurrentPreview();
    }

    // Event bindings
    els.videoInput?.addEventListener('change', (e) => {
        const file = e.target.files?.[0];
        if (!file) return;

        stopPreviewPlayback();
        els.resultWrap?.classList.add('d-none');
        if (videoObjectUrl) URL.revokeObjectURL(videoObjectUrl);
        videoObjectUrl = URL.createObjectURL(file);
        videoFileName = file.name || 'video';

        previewVideo.src = videoObjectUrl;
        previewVideo.onloadedmetadata = () => {
            videoDuration = Number.isFinite(previewVideo.duration) ? previewVideo.duration : 0;
            videoNaturalW = previewVideo.videoWidth || 0;
            videoNaturalH = previewVideo.videoHeight || 0;
            const mb = (file.size / (1024 * 1024)).toFixed(2);
            if (els.videoMeta) {
                els.videoMeta.textContent = `${file.name} (${videoNaturalW}x${videoNaturalH} • ${videoDuration.toFixed(1)} dtk • ${mb} MB)`;
            }
            els.durationWarn?.classList.toggle('d-none', videoDuration <= 90);
            if (els.previewToggle) els.previewToggle.disabled = false;
            if (els.renderBtn) els.renderBtn.disabled = !supportedFormat;

            previewVideo.currentTime = Math.min(0.1, videoDuration / 2 || 0);
        };
        previewVideo.onseeked = () => {
            if (previewVideo.paused && !isRendering) {
                drawCurrentPreview();
            }
        };
        previewVideo.onerror = () => {
            alert('File video tidak dapat dibaca oleh browser. Pastikan formatnya MP4, MOV, atau WebM yang valid.');
            resetAll();
        };
        previewVideo.load();
    });

    els.previewToggle?.addEventListener('click', async () => {
        if (!videoObjectUrl || isRendering) return;
        if (previewVideo.paused) {
            try {
                previewVideo.muted = !els.includeAudio?.checked;
                await previewVideo.play();
                els.previewToggle.textContent = 'Jeda Pratinjau';
                startPreviewLoop();
            } catch (e) {}
        } else {
            stopPreviewPlayback();
            drawCurrentPreview();
        }
    });

    els.styleSelect?.addEventListener('change', () => {
        const isCustom = els.styleSelect.value === 'custom_png';
        els.customFrameWrap?.classList.toggle('d-none', !isCustom);
        drawCurrentPreview();
    });

    els.customFrameInput?.addEventListener('change', (e) => {
        const file = e.target.files?.[0];
        if (!file) return;
        if (customFrameUrl) URL.revokeObjectURL(customFrameUrl);
        customFrameUrl = URL.createObjectURL(file);
        const img = new Image();
        img.onload = () => {
            customFrameImg = img;
            drawCurrentPreview();
        };
        img.onerror = () => {
            alert('Gambar bingkai PNG gagal dibaca.');
        };
        img.src = customFrameUrl;
    });

    els.clearCustomFrame?.addEventListener('click', () => {
        if (customFrameUrl) {
            URL.revokeObjectURL(customFrameUrl);
            customFrameUrl = null;
        }
        customFrameImg = null;
        if (els.customFrameInput) els.customFrameInput.value = '';
        drawCurrentPreview();
    });

    els.productPreset?.addEventListener('change', () => {
        const opt = els.productPreset.options[els.productPreset.selectedIndex];
        if (!opt || !opt.value) return;
        const name = opt.getAttribute('data-name') || '';
        const brand = opt.getAttribute('data-brand') || '';
        const badge = opt.getAttribute('data-badge') || 'READY STOCK';
        const price = parseInt(opt.getAttribute('data-price') || '0', 10) || 0;
        if (els.badgeText) els.badgeText.value = badge;
        if (els.titleText) els.titleText.value = `${name}${brand ? ' (' + brand + ')' : ''}`;
        if (els.footerText) {
            const priceLabel = price > 0 ? `Mulai Rp ${price.toLocaleString('id-ID')} • ` : '';
            els.footerText.value = `${priceLabel}WA +${STORE_WA}`;
        }
        drawCurrentPreview();
    });

    [els.aspectSelect, els.qualitySelect, els.fitSelect, els.themeSelect, els.includeAudio].forEach((el) => {
        el?.addEventListener('change', () => {
            if (el === els.includeAudio && !previewVideo.paused) {
                previewVideo.muted = !els.includeAudio.checked;
            }
            drawCurrentPreview();
        });
    });

    [els.badgeText, els.titleText, els.footerText].forEach((el) => {
        el?.addEventListener('input', () => {
            if (!isRendering) drawCurrentPreview();
        });
    });

    els.renderBtn?.addEventListener('click', startExport);
    els.cancelBtn?.addEventListener('click', cancelExport);
    els.resetBtn?.addEventListener('click', resetAll);

    els.shareBtn?.addEventListener('click', async () => {
        if (!outputBlob || !navigator.share) return;
        try {
            const file = new File([outputBlob], outputFileName, { type: outputBlob.type || 'video/mp4' });
            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                await navigator.share({
                    title: `${STORE_NAME} - Video Promo`,
                    files: [file],
                });
            }
        } catch (err) {
            if (err.name !== 'AbortError') {
                console.error(err);
            }
        }
    });

    modalEl.addEventListener('shown.bs.modal', () => {
        if (!isRendering) drawCurrentPreview();
    });

    modalEl.addEventListener('hidden.bs.modal', () => {
        if (isRendering) cancelExport();
        stopPreviewPlayback();
    });

    drawCurrentPreview();
})();
