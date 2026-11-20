<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CatalogController extends Controller
{
    private const PRODUCT_RULES = [
        'id' => ['required', 'regex:/^[a-z0-9\-]+$/', 'max:80'],
        'name' => 'required|string|max:140',
        'brand' => 'required|string|max:80',
        'category' => 'required|in:Laptop,PC,Printer,Monitor,Aksesoris',
        'badge' => 'required|string|max:80',
        'image' => 'nullable|string|max:2000',
        'photos' => 'nullable|array|max:10',
        'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:12288',
        'specs_text' => 'required|string|max:1000',
        'variants_text' => 'required|string|max:2000',
        'is_sold_out' => 'nullable|boolean',
    ];

    private function productRules(): array
    {
        $rules = self::PRODUCT_RULES;
        if (!extension_loaded('fileinfo')) {
            $rules['photos.*'] = ['nullable', 'file', 'max:12288', function ($attr, $file, $fail) {
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $fail('Format file harus berupa jpg, jpeg, png, atau webp.');
                }
            }];
        }
        return $rules;
    }

    private function logoRule(): array|string
    {
        if (extension_loaded('fileinfo')) {
            return 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        return ['nullable', 'file', 'max:2048', function ($attr, $file, $fail) {
            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $fail('Format logo harus berupa jpg, jpeg, png, atau webp.');
            }
        }];
    }
    // shortcut: single-file JSON store in storage/app/catalog.json, upgrade to relational tables when concurrent multi-admin edits or >200 SKUs are needed
    private function loadCatalog(): array
    {
        $default = config('catalog');
        $path = storage_path('app/catalog.json');
        if (is_file($path)) {
            $decoded = json_decode((string) file_get_contents($path), true);
            if (is_array($decoded) && isset($decoded['products'])) {
                $decoded['about_title'] = $decoded['about_title'] ?? ($default['about_title'] ?? 'KEUNGGULAN JAVA COMPUTER');
                $decoded['about_subtitle'] = $decoded['about_subtitle'] ?? ($default['about_subtitle'] ?? 'Kami bukan sekadar penjual e-commerce biasa. Kami bengkel hardware dan pusat konsultasi komputer fisik yang beroperasi nyata setiap hari.');
                $decoded['about_features'] = $decoded['about_features'] ?? ($default['about_features'] ?? []);
                $decoded['contact_title'] = $decoded['contact_title'] ?? ($default['contact_title'] ?? 'KUNJUNGI TOKO FISIK');
                $decoded['contact_subtitle'] = $decoded['contact_subtitle'] ?? ($default['contact_subtitle'] ?? 'Mau cek fisik barang sebelum beli atau konsultasi spek langsung ke teknisi kami? Silakan mampir ke workshop kami.');
                $decoded['map_image'] = $decoded['map_image'] ?? ($default['map_image'] ?? '');
                $decoded['map_link'] = $decoded['map_link'] ?? ($default['map_link'] ?? 'https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8');
                $decoded['faqs'] = $decoded['faqs'] ?? ($default['faqs'] ?? []);
                $decoded['trust_stats'] = $decoded['trust_stats'] ?? ($default['trust_stats'] ?? []);
                $decoded['hero_badges'] = $decoded['hero_badges'] ?? ($default['hero_badges'] ?? []);
                $decoded['instagram_url'] = $decoded['instagram_url'] ?? ($default['instagram_url'] ?? '');
                $decoded['tiktok_url'] = $decoded['tiktok_url'] ?? ($default['tiktok_url'] ?? '');
                $decoded['facebook_url'] = $decoded['facebook_url'] ?? ($default['facebook_url'] ?? '');
                return $decoded;
            }
        }
        return $default;
    }

    private function verifyAdminPassword(string $inputPassword, array $catalog): bool
    {
        if (!empty($catalog['admin_password_hash'])) {
            return Hash::check($inputPassword, (string) $catalog['admin_password_hash']);
        }

        $expected = (string) config('catalog.admin_password', '');
        return $expected !== '' && hash_equals($expected, $inputPassword);
    }

    private function saveCatalog(array $catalog): void
    {
        unset($catalog['admin_password']);
        $path = storage_path('app/catalog.json');
        @mkdir(dirname($path), 0775, true);
        file_put_contents($path, json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }

    public function index()
    {
        $catalog = $this->loadCatalog();
        usort($catalog['products'], fn (array $a, array $b): int => ((int) !empty($a['is_sold_out'])) <=> ((int) !empty($b['is_sold_out'])));
        return view('landing', ['catalog' => $catalog]);
    }

    public function loginForm()
    {
        return view('admin.login', ['catalog' => $this->loadCatalog()]);
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);
        $catalog = $this->loadCatalog();

        if (!$this->verifyAdminPassword((string) $request->input('password'), $catalog)) {
            return redirect('/admin/login')->withErrors(['password' => 'Password admin tidak sesuai.']);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);
        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function admin()
    {
        return view('admin.dashboard', ['catalog' => $this->loadCatalog()]);
    }

    public function backupCatalog()
    {
        $catalog = $this->loadCatalog();
        unset($catalog['admin_password'], $catalog['admin_password_hash']);
        $json = json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $filename = 'catalog-backup-' . date('Y-m-d') . '.json';
        return response($json, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $catalog = $this->loadCatalog();
        if (!$this->verifyAdminPassword((string) $request->input('current_password'), $catalog)) {
            return redirect('/admin')->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $catalog['admin_password_hash'] = Hash::make($request->input('new_password'));
        unset($catalog['admin_password']);
        $this->saveCatalog($catalog);

        $request->session()->regenerate();
        return redirect('/admin')->with('status', 'Password admin berhasil diperbarui.');
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:120',
            'tagline' => 'required|string|max:200',
            'whatsapp_number' => ['required', 'regex:/^[0-9]{9,16}$/'],
            'address' => 'required|string|max:200',
            'hours' => 'required|string|max:120',
            'hero_badge' => 'required|string|max:100',
            'hero_title' => 'required|string|max:150',
            'hero_subtitle' => 'required|string|max:220',
            'hero_original_price' => 'required|integer|min:1',
            'hero_promo_price' => 'required|integer|min:1|lte:hero_original_price',
            'hero_bonus' => 'required|string|max:180',
            'logo' => $this->logoRule(),
            'remove_logo' => 'nullable|boolean',
            'about_title' => 'nullable|string|max:150',
            'about_subtitle' => 'nullable|string|max:500',
            'about_features_text' => 'nullable|string|max:3000',
            'contact_title' => 'nullable|string|max:150',
            'contact_subtitle' => 'nullable|string|max:500',
            'map_image' => 'nullable|string|max:1000',
            'map_link' => 'nullable|string|max:1000',
            'faq_text' => 'nullable|string|max:4000',
            'trust_stats_text' => 'nullable|string|max:1500',
            'hero_badges_text' => 'nullable|string|max:2000',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
        ]);

        $catalog = $this->loadCatalog();
        $oldLogo = $catalog['logo'] ?? null;
        if ($request->hasFile('logo')) {
            if ($oldLogo && str_starts_with($oldLogo, '/uploads/logo/')) {
                @unlink(public_path(ltrim($oldLogo, '/')));
            }
            $dir = public_path('uploads/logo');
            @mkdir($dir, 0775, true);
            $name = 'logo-' . uniqid() . '.' . strtolower($request->file('logo')->getClientOriginalExtension());
            $request->file('logo')->move($dir, $name);
            $catalog['logo'] = '/uploads/logo/' . $name;
        } elseif ($request->boolean('remove_logo')) {
            if ($oldLogo && str_starts_with($oldLogo, '/uploads/logo/')) {
                @unlink(public_path(ltrim($oldLogo, '/')));
            }
            unset($catalog['logo']);
        }
        $catalog['store_name'] = $data['store_name'];
        $catalog['tagline'] = $data['tagline'];
        $catalog['whatsapp_number'] = $data['whatsapp_number'];
        $catalog['address'] = $data['address'];
        $catalog['hours'] = $data['hours'];
        $catalog['instagram_url'] = $data['instagram_url'] ?? '';
        $catalog['tiktok_url'] = $data['tiktok_url'] ?? '';
        $catalog['facebook_url'] = $data['facebook_url'] ?? '';
        $catalog['hero_deal'] = [
            'badge' => $data['hero_badge'],
            'title' => $data['hero_title'],
            'subtitle' => $data['hero_subtitle'],
            'original_price' => (int) $data['hero_original_price'],
            'promo_price' => (int) $data['hero_promo_price'],
            'bonus' => $data['hero_bonus'],
        ];

        if (array_key_exists('about_title', $data)) {
            $catalog['about_title'] = (string) ($data['about_title'] ?? '');
        }
        if (array_key_exists('about_subtitle', $data)) {
            $catalog['about_subtitle'] = (string) ($data['about_subtitle'] ?? '');
        }
        if (array_key_exists('about_features_text', $data)) {
            $catalog['about_features'] = $this->parseFeatureTriples(
                (string) ($data['about_features_text'] ?? ''),
                ['verified_user', 'inventory', 'terminal', 'headset_mic', 'build', 'thumb_up']
            );
        }
        if (array_key_exists('hero_badges_text', $data)) {
            $catalog['hero_badges'] = $this->parseFeatureTriples(
                (string) ($data['hero_badges_text'] ?? ''),
                ['verified', 'support_agent', 'local_shipping', 'bolt', 'shield', 'build']
            );
        }
        if (array_key_exists('contact_title', $data)) {
            $catalog['contact_title'] = (string) ($data['contact_title'] ?? '');
        }
        if (array_key_exists('contact_subtitle', $data)) {
            $catalog['contact_subtitle'] = (string) ($data['contact_subtitle'] ?? '');
        }
        if (array_key_exists('map_image', $data)) {
            $catalog['map_image'] = (string) ($data['map_image'] ?? '');
        }
        if (array_key_exists('map_link', $data)) {
            $catalog['map_link'] = (string) ($data['map_link'] ?? '');
        }
        if (array_key_exists('faq_text', $data)) {
            $catalog['faqs'] = $this->parsePipePairs((string) ($data['faq_text'] ?? ''), 'q', 'a');
        }
        if (array_key_exists('trust_stats_text', $data)) {
            $catalog['trust_stats'] = $this->parsePipePairs((string) ($data['trust_stats_text'] ?? ''), 'value', 'label');
        }

        $this->saveCatalog($catalog);
        return redirect('/admin')->with('status', 'Pengaturan toko, hero deal, tentang kami & kontak berhasil diperbarui.');
    }

    private function parsePipePairs(string $text, string $firstKey, string $secondKey): array
    {
        $items = [];
        foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
            $line = trim($line);
            if ($line === '') continue;
            $parts = array_map('trim', explode('|', $line, 2));
            if (!empty($parts[0])) {
                $items[] = [
                    $firstKey => $parts[0],
                    $secondKey => $parts[1] ?? '',
                ];
            }
        }
        return $items;
    }

    private function parseFeatureTriples(string $text, array $defaultIcons): array
    {
        $items = [];
        foreach (preg_split('/\r\n|\r|\n/', $text) as $idx => $line) {
            $line = trim($line);
            if ($line === '') continue;
            $parts = array_map('trim', explode('|', $line, 3));
            if (!empty($parts[0])) {
                $items[] = [
                    'title' => $parts[0],
                    'desc' => $parts[1] ?? '',
                    'icon' => !empty($parts[2]) ? $parts[2] : ($defaultIcons[$idx % count($defaultIcons)]),
                ];
            }
        }
        return $items;
    }

    // shortcut: compresses server-side if GD is present; client-side canvas handles compression before upload when GD is absent
    private function compressImageIfNeeded(string $path, int $maxBytes = 4194304): void
    {
        if (!extension_loaded('gd') || !file_exists($path) || filesize($path) <= $maxBytes) {
            return;
        }

        $info = @getimagesize($path);
        if (!$info) {
            return;
        }

        $src = match ($info['mime'] ?? '') {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => @imagecreatefromwebp($path),
            default => null,
        };

        if (!$src) {
            return;
        }

        $w = imagesx($src);
        $h = imagesy($src);
        $maxDim = 1920;

        if ($w > $maxDim || $h > $maxDim) {
            $ratio = min($maxDim / $w, $maxDim / $h);
            $nw = max(1, (int) round($w * $ratio));
            $nh = max(1, (int) round($h * $ratio));
            $dst = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
            imagedestroy($src);
            $src = $dst;
        }

        @imagejpeg($src, $path, 80);
        imagedestroy($src);
    }

    // shortcut: stores uploaded product photos directly in public/uploads/products, upgrade to S3/object storage when deploying across multiple stateless app servers
    private function extractImages(array $data, array $uploadedFiles = []): array
    {
        $images = [];
        if (!empty($uploadedFiles)) {
            $dir = public_path('uploads/products');
            @mkdir($dir, 0775, true);
            foreach ($uploadedFiles as $file) {
                if ($file && $file->isValid()) {
                    $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                    $name = $data['id'] . '-' . uniqid() . '.' . $ext;
                    $targetPath = $dir . '/' . $name;
                    $file->move($dir, $name);
                    $this->compressImageIfNeeded($targetPath);
                    $images[] = '/uploads/products/' . $name;
                }
            }
        }

        if (!empty($data['image'])) {
            foreach (preg_split('/\r\n|\r|\n|;/', (string) $data['image']) as $rawUrl) {
                $url = trim($rawUrl);
                if ($url !== '' && (filter_var($url, FILTER_VALIDATE_URL) || str_starts_with($url, '/uploads/products/'))) {
                    $images[] = $url;
                }
            }
        }

        return array_values(array_unique($images));
    }

    private function buildProduct(array $data, array $uploadedFiles = [], bool $allowEmptyPhoto = false, array $fallbackImages = []): ?array
    {
        $images = $this->extractImages($data, $uploadedFiles);
        if (empty($images) && !empty($fallbackImages)) {
            $images = $fallbackImages;
        }
        if (empty($images) && !$allowEmptyPhoto) {
            return null;
        }

        $specs = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n|;/', (string) ($data['specs_text'] ?? '')))));
        $variants = [];
        foreach (preg_split('/\r\n|\r|\n|;/', (string) ($data['variants_text'] ?? '')) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $parts = array_map('trim', explode('|', $line));
            if (count($parts) === 2 && $parts[0] !== '') {
                $promo = (int) preg_replace('/[^0-9]/', '', $parts[1]);
                if ($promo > 0) {
                    $variants[] = [
                        'label' => $parts[0],
                        'promo_price' => $promo,
                        'original_price' => $promo,
                    ];
                }
                continue;
            }
            if (count($parts) < 3 || $parts[0] === '') {
                continue;
            }
            $promo = max(1, (int) preg_replace('/[^0-9]/', '', $parts[1]));
            $orig = max($promo, (int) preg_replace('/[^0-9]/', '', $parts[2]));
            $variants[] = [
                'label' => $parts[0],
                'promo_price' => $promo,
                'original_price' => $orig,
            ];
        }

        if (empty($variants)) {
            return null;
        }

        return [
            'id' => $data['id'],
            'name' => $data['name'],
            'brand' => $data['brand'],
            'category' => $data['category'],
            'badge' => !empty($data['badge']) ? $data['badge'] : 'Ready Stock',
            'image' => $images[0] ?? '',
            'images' => $images,
            'specs' => $specs ?: ['Garansi Resmi'],
            'variants' => $variants,
            'is_sold_out' => !empty($data['is_sold_out']),
        ];
    }

    private function upsertProduct(array &$catalog, array $product): void
    {
        foreach ($catalog['products'] as $idx => $existing) {
            if ($existing['id'] === $product['id']) {
                if (empty($product['images']) && !empty($existing['images'])) {
                    $product['images'] = $existing['images'];
                    $product['image'] = $existing['image'] ?? ($existing['images'][0] ?? '');
                }
                $catalog['products'][$idx] = $product;
                return;
            }
        }
        $catalog['products'][] = $product;
    }

    public function saveProduct(Request $request)
    {
        $rules = $this->productRules();
        $rules['original_id'] = 'nullable|string|max:80';
        $data = $request->validate($rules);
        $files = $request->file('photos', []);

        $catalog = $this->loadCatalog();
        $originalId = $data['original_id'] ?? null;
        $lookupId = !empty($originalId) ? $originalId : $data['id'];
        $existingProduct = collect($catalog['products'])->firstWhere('id', $lookupId);
        $fallbackImages = $existingProduct ? array_values(array_filter($existingProduct['images'] ?? [$existingProduct['image'] ?? ''])) : [];

        $product = $this->buildProduct(
            $data,
            is_array($files) ? $files : [$files],
            $existingProduct !== null,
            $fallbackImages
        );

        if (!$product) {
            return redirect('/admin')->withErrors(['product' => 'Pastikan minimal 1 foto diupload dan format varian (Label | Harga Promo | Harga Coret) valid.']);
        }

        if (!empty($originalId) && $originalId !== $product['id']) {
            $catalog['products'] = array_values(array_filter(
                $catalog['products'],
                fn (array $p) => $p['id'] !== $originalId
            ));
        }
        $this->upsertProduct($catalog, $product);
        $this->saveCatalog($catalog);

        return redirect('/admin')->with('status', 'Produk berhasil disimpan.');
    }

    public function downloadTemplate()
    {
        $rows = [
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

        $fh = fopen('php://temp', 'r+');
        fwrite($fh, "\xEF\xBB\xBF");
        foreach ($rows as $row) {
            fputcsv($fh, $row);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template-produk-java-computer.csv"',
        ]);
    }

    // shortcut: parses CSV via stdlib fgetcsv (with browser SheetJS converting .xlsx to CSV on select), upgrade to server-side zip XML parser if headless .xlsx API uploads are needed
    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:csv,txt,xlsx,xls|max:5120',
            'csv_payload' => 'nullable|string|max:1000000',
        ]);

        $raw = (string) $request->input('csv_payload', '');
        if ($raw === '' && $request->hasFile('file')) {
            $raw = (string) file_get_contents($request->file('file')->getRealPath());
        }
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', trim($raw));

        if ($raw === '') {
            return redirect('/admin')->withErrors(['import' => 'File template kosong atau belum dipilih.']);
        }

        $firstLine = strtok($raw, "\r\n") ?: '';
        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

        $fh = fopen('php://temp', 'r+');
        fwrite($fh, $raw);
        rewind($fh);

        $rawHeaders = array_map(fn ($h) => strtolower(trim((string) $h)), fgetcsv($fh, 0, $delimiter) ?: []);
        $headerAliasMap = [
            'id' => 'id',
            'slug' => 'id',
            'name' => 'name',
            'nama' => 'name',
            'nama_produk' => 'name',
            'nama produk' => 'name',
            'brand' => 'brand',
            'merek' => 'brand',
            'merk' => 'brand',
            'category' => 'category',
            'kategori' => 'category',
            'badge' => 'badge',
            'label' => 'badge',
            'label_promo' => 'badge',
            'image' => 'image',
            'foto' => 'image',
            'specs_text' => 'specs_text',
            'spesifikasi' => 'specs_text',
            'specs' => 'specs_text',
            'variants_text' => 'variants_text',
            'varian' => 'variants_text',
            'varian_harga' => 'variants_text',
            'variants' => 'variants_text',
        ];
        $headers = array_map(fn ($h) => $headerAliasMap[$h] ?? $h, $rawHeaders);
        $requiredCols = ['name', 'brand', 'category', 'variants_text'];

        if (!empty(array_diff($requiredCols, $headers))) {
            fclose($fh);
            return redirect('/admin')->withErrors([
                'import' => 'Header kolom tidak sesuai template. Minimal wajib ada kolom: name, brand, category, badge, specs_text, variants_text',
            ]);
        }

        $categoryLookup = [
            'laptop' => 'Laptop',
            'pc' => 'PC',
            'printer' => 'Printer',
            'monitor' => 'Monitor',
            'aksesoris' => 'Aksesoris',
        ];

        $parsedProducts = [];
        $lineNum = 1;
        while (($row = fgetcsv($fh, 0, $delimiter)) !== false) {
            $lineNum++;
            if ($row === [null] || empty(array_filter($row, fn ($v) => trim((string) $v) !== ''))) {
                continue;
            }
            $padded = array_pad(array_slice(array_map('trim', $row), 0, count($headers)), count($headers), '');
            $assoc = array_combine($headers, $padded);

            $rawCat = strtolower($assoc['category'] ?? '');
            if (isset($categoryLookup[$rawCat])) {
                $assoc['category'] = $categoryLookup[$rawCat];
            }

            if (empty($assoc['id'])) {
                $slugSource = ($assoc['category'] ?? '') . '-' . ($assoc['name'] ?? '');
                $assoc['id'] = substr(trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($slugSource)), '-'), 0, 80);
            }

            if (empty($assoc['badge'])) {
                $assoc['badge'] = 'Ready Stock';
            }
            if (empty($assoc['specs_text'])) {
                $assoc['specs_text'] = 'Garansi Resmi';
            }
            $assoc['image'] = $assoc['image'] ?? '';

            $validator = Validator::make($assoc, $this->productRules());
            if ($validator->fails()) {
                fclose($fh);
                return redirect('/admin')->withErrors(['import' => "Baris {$lineNum}: " . $validator->errors()->first()]);
            }
            $product = $this->buildProduct($assoc, [], true);
            if (!$product) {
                fclose($fh);
                return redirect('/admin')->withErrors(['import' => "Baris {$lineNum}: Format varian tidak valid. Gunakan format: Nama Varian | Harga Promo | Harga Normal"]);
            }
            $parsedProducts[] = $product;
        }
        fclose($fh);

        if (empty($parsedProducts)) {
            return redirect('/admin')->withErrors(['import' => 'Tidak ada baris produk untuk diimpor.']);
        }

        $catalog = $this->loadCatalog();
        foreach ($parsedProducts as $product) {
            $this->upsertProduct($catalog, $product);
        }
        $this->saveCatalog($catalog);

        return redirect('/admin')->with('status', count($parsedProducts) . ' produk berhasil diposting secara massal.');
    }

    public function toggleSoldOut(string $id)
    {
        $catalog = $this->loadCatalog();
        $updated = false;
        foreach ($catalog['products'] as &$product) {
            if ($product['id'] === $id) {
                $product['is_sold_out'] = !($product['is_sold_out'] ?? false);
                $updated = true;
                break;
            }
        }
        unset($product);

        if ($updated) {
            $this->saveCatalog($catalog);
        }

        return redirect('/admin')->with('status', 'Status produk berhasil diperbarui.');
    }

    public function deleteProduct(string $id)
    {
        $catalog = $this->loadCatalog();
        $productToDelete = null;
        foreach ($catalog['products'] as $p) {
            if ($p['id'] === $id) {
                $productToDelete = $p;
                break;
            }
        }
        if ($productToDelete && !empty($productToDelete['images'])) {
            foreach ($productToDelete['images'] as $img) {
                if (str_starts_with($img, '/uploads/products/')) {
                    @unlink(public_path(ltrim($img, '/')));
                }
            }
        }

        $catalog['products'] = array_values(array_filter(
            $catalog['products'],
            fn (array $p) => $p['id'] !== $id
        ));
        $this->saveCatalog($catalog);

        return redirect('/admin')->with('status', 'Produk berhasil dihapus.');
    }
}
