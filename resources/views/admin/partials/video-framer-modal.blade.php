<!-- Modal Generator Bingkai Video (100% Client-Side, Zero Server Storage) -->
<div class="modal fade" id="videoFrameModal" tabindex="-1" aria-labelledby="videoFrameModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content brutal-card p-0 overflow-hidden">
            <div class="modal-header border-bottom border-2 border-dark px-4 py-3" style="background-color: #F3ECE1;">
                <div>
                    <span class="badge border border-dark rounded-0 px-2 py-1 mb-1 font-monospace" style="background: #E5AC67; color: #111111;">VIDEO FRAMER • 100% DI BROWSER</span>
                    <h2 class="modal-title h5 fw-bold mb-0" id="videoFrameModalLabel">Generator Bingkai / Frame Video</h2>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup dialog bingkai video"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #FCF9F3;">
                <div id="vf-support-error" class="alert alert-danger rounded-0 border-2 border-dark small fw-semibold d-none" role="alert">
                    Browser Anda belum mendukung perekaman video kanvas (<code>MediaRecorder</code> / <code>captureStream</code>). Gunakan Chrome, Edge, atau Safari versi terbaru.
                </div>

                <div class="row g-4 align-items-start">
                    <!-- Kolom Kiri: Pratinjau Kanvas, Progress & Hasil -->
                    <div class="col-lg-5">
                        <div class="p-3 bg-white border border-2 border-dark shadow-sm text-center">
                            <canvas id="vf-canvas" width="720" height="1280"
                                style="width: 100%; max-width: 300px; height: auto; border: 2.5px solid #111111; box-shadow: 4px 4px 0px #111111; display: block; margin: 0 auto; aspect-ratio: 9/16; background: #FCF9F3;"
                                aria-label="Pratinjau video berbingkai"></canvas>

                            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mt-3">
                                <button type="button" id="vf-preview-toggle" class="btn btn-light btn-sm" disabled>
                                    Putar Pratinjau
                                </button>
                                <span id="vf-format-badge" class="badge border border-dark rounded-0 font-monospace text-dark py-2 px-2" style="background: #F3ECE1;">
                                    Output: Mendeteksi...
                                </span>
                            </div>

                            <div id="vf-video-meta" class="small text-secondary font-monospace mt-2">
                                Belum ada video dipilih. Video hanya diproses di perangkat Anda.
                            </div>

                            <div id="vf-duration-warn" class="alert alert-warning rounded-0 border border-dark py-1 px-2 small text-start mt-2 mb-0 d-none" role="status">
                                Durasi video cukup panjang (&gt; 90 detik). Render berjalan real-time 1x durasi video; biarkan tab browser tetap terbuka hingga selesai.
                            </div>

                            <!-- Progress Render -->
                            <div id="vf-progress-wrap" class="mt-3 text-start d-none">
                                <div class="d-flex justify-content-between small fw-bold font-monospace mb-1">
                                    <span>Memproses Bingkai Video...</span>
                                    <span id="vf-progress-pct">0%</span>
                                </div>
                                <div class="progress rounded-0 border border-dark" style="height: 18px; background: #F3ECE1;">
                                    <div id="vf-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated fw-bold text-dark" role="progressbar" style="width: 0%; background-color: #E5AC67;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div id="vf-progress-detail" class="small text-secondary mt-1">
                                    Mohon jangan tutup atau pindah tab sampai proses selesai.
                                </div>
                            </div>

                            <!-- Hasil Video Jadi -->
                            <div id="vf-result-wrap" class="mt-3 pt-3 border-top border-2 border-dark text-start d-none">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-success border border-dark rounded-0 font-monospace">SELESAI DIPROSES</span>
                                    <span id="vf-result-meta" class="small font-monospace text-secondary"></span>
                                </div>
                                <video id="vf-result-video" controls playsinline class="w-100 border border-2 border-dark bg-dark mb-2" style="max-height: 260px;"></video>
                                <div class="d-flex flex-wrap gap-2">
                                    <a id="vf-download-btn" href="#" download="framed-video.mp4" class="btn btn-success btn-sm flex-grow-1 py-2">
                                        Unduh Video Berbingkai
                                    </a>
                                    <button type="button" id="vf-share-btn" class="btn btn-light btn-sm py-2 d-none">
                                        Bagikan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Kontrol Bingkai & Teks -->
                    <div class="col-lg-7">
                        <div class="brutal-card p-3 mb-3 bg-white">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                <h3 class="h6 fw-bold mb-0">1. Pilih File Video</h3>
                                <span class="badge border border-dark rounded-0 font-monospace text-dark" style="background: #F3ECE1;">ZERO SERVER STORAGE</span>
                            </div>
                            <div class="mb-2">
                                <label for="vf-video-input" class="form-label small fw-semibold">File Video dari Komputer / HP (MP4, MOV, WebM):</label>
                                <input type="file" id="vf-video-input" class="form-control form-control-sm" accept="video/*">
                                <div class="form-text small">Video diproses langsung di memori browser dan tidak pernah dikirim atau disimpan ke server.</div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label for="vf-aspect-select" class="form-label small fw-semibold">Rasio Video:</label>
                                    <select id="vf-aspect-select" class="form-select form-select-sm">
                                        <option value="9:16" selected>9:16 (Story WA / Reels / TikTok)</option>
                                        <option value="1:1">1:1 (Feed IG / Persegi)</option>
                                        <option value="16:9">16:9 (Landscape / YouTube)</option>
                                        <option value="original">Ikuti Rasio Asli Video</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="vf-quality-select" class="form-label small fw-semibold">Resolusi Output:</label>
                                    <select id="vf-quality-select" class="form-select form-select-sm">
                                        <option value="720" selected>HD 720p (Cepat &amp; Ringan)</option>
                                        <option value="1080">Full HD 1080p (Tajam)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="vf-fit-select" class="form-label small fw-semibold">Posisi Video di Slot:</label>
                                    <select id="vf-fit-select" class="form-select form-select-sm">
                                        <option value="contain" selected>Utuh (Tanpa Terpotong)</option>
                                        <option value="cover">Penuh (Isi Penuh / Crop)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="brutal-card p-3 mb-3 bg-white">
                            <h3 class="h6 fw-bold mb-2">2. Gaya Bingkai &amp; Tema</h3>
                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label for="vf-style-select" class="form-label small fw-semibold">Gaya Bingkai:</label>
                                    <select id="vf-style-select" class="form-select form-select-sm">
                                        <option value="full" selected>Bingkai Promo Lengkap (Header + Footer Toko)</option>
                                        <option value="minimal">Bingkai Tipis + Watermark (Video Maksimal)</option>
                                        <option value="custom_png">Bingkai PNG Custom (Upload Frame Sendiri)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="vf-theme-select" class="form-label small fw-semibold">Tema Warna / Hari Besar:</label>
                                    <select id="vf-theme-select" class="form-select form-select-sm">
                                        <option value="default">Klasik Hardware (Default Toko)</option>
                                        <option value="ramadhan">Bulan Ramadhan (Berkah Ramadhan)</option>
                                        <option value="idul_fitri">Hari Raya Idul Fitri (Spesial Lebaran)</option>
                                        <option value="tahun_baru">Tahun Baru (Upgrade Setup Baru)</option>
                                        <option value="kemerdekaan">Hari Kemerdekaan Indonesia (17-08)</option>
                                        <option value="back_to_school">Tahun Ajaran Baru (Pelajar &amp; Mahasiswa)</option>
                                        <option value="pemilu">Promo Pemilu (Pesta Demokrasi)</option>
                                    </select>
                                </div>
                            </div>
                            <div id="vf-custom-frame-wrap" class="mb-1 d-none">
                                <label for="vf-custom-frame-input" class="form-label small fw-semibold">Upload Bingkai PNG Transparan (Opsional, 100% di Browser):</label>
                                <div class="input-group input-group-sm">
                                    <input type="file" id="vf-custom-frame-input" class="form-control form-control-sm" accept="image/png,image/webp">
                                    <button type="button" id="vf-clear-custom-frame" class="btn btn-light btn-sm">Hapus Frame</button>
                                </div>
                                <div class="form-text small">Gunakan gambar PNG berlubang/transparan (misalnya buatan Canva/Photoshop) sesuai rasio video.</div>
                            </div>
                        </div>

                        <div class="brutal-card p-3 mb-3 bg-white">
                            <h3 class="h6 fw-bold mb-2">3. Teks Bingkai &amp; Audio (Opsional)</h3>
                            <div class="mb-2">
                                <label for="vf-product-preset" class="form-label small fw-semibold">Isi Teks Otomatis dari Produk Katalog (Opsional):</label>
                                <select id="vf-product-preset" class="form-select form-select-sm">
                                    <option value="">-- Teks Manual / Video Umum --</option>
                                    @foreach ($catalog['products'] as $vfProd)
                                        @php
                                            $vfMinPrice = !empty($vfProd['variants']) ? min(array_map(static fn ($v) => (int) ($v['promo_price'] ?? 0), $vfProd['variants'])) : 0;
                                        @endphp
                                        <option value="{{ $vfProd['id'] }}"
                                            data-name="{{ $vfProd['name'] }}"
                                            data-brand="{{ $vfProd['brand'] }}"
                                            data-badge="{{ $vfProd['badge'] ?? 'READY STOCK' }}"
                                            data-price="{{ $vfMinPrice }}">
                                            {{ $vfProd['name'] }} ({{ $vfProd['category'] }} - Mulai Rp {{ number_format($vfMinPrice, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-md-5">
                                    <label for="vf-badge-text" class="form-label small fw-semibold">Badge Atas:</label>
                                    <input type="text" id="vf-badge-text" class="form-control form-control-sm" value="READY STOCK TOKO" placeholder="Kosongkan jika tanpa badge">
                                </div>
                                <div class="col-md-7">
                                    <label for="vf-title-text" class="form-label small fw-semibold">Judul / Headline Bawah:</label>
                                    <input type="text" id="vf-title-text" class="form-control form-control-sm" value="{{ $catalog['store_name'] }} - Unit Siap Pakai" placeholder="Contoh: Unboxing Lenovo IdeaPad Slim 3">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="vf-footer-text" class="form-label small fw-semibold">Info Harga / CTA WhatsApp:</label>
                                <input type="text" id="vf-footer-text" class="form-control form-control-sm" value="Order &amp; Konsultasi WA: +{{ $catalog['whatsapp_number'] }}" placeholder="Kosongkan jika tidak perlu">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="vf-include-audio" checked>
                                <label class="form-check-label small fw-semibold" for="vf-include-audio">Sertakan suara / audio asli video</label>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" id="vf-render-btn" class="btn btn-primary btn-sm flex-grow-1 py-2" disabled>
                                Proses &amp; Buat Video Berbingkai
                            </button>
                            <button type="button" id="vf-cancel-btn" class="btn btn-danger btn-sm py-2 px-3 d-none">
                                Batalkan Proses
                            </button>
                            <button type="button" id="vf-reset-btn" class="btn btn-light btn-sm py-2 px-3">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
