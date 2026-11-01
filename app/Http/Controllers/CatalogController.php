<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                $decoded['instagram_url'] = $decoded['instagram_url'] ?? ($default['instagram_url'] ?? '');
                $decoded['tiktok_url'] = $decoded['tiktok_url'] ?? ($default['tiktok_url'] ?? '');
                $decoded['facebook_url'] = $decoded['facebook_url'] ?? ($default['facebook_url'] ?? '');
                return $decoded;
            }
        }
        return $default;
    }

    private function saveCatalog(array $catalog): void
    {
        $path = storage_path('app/catalog.json');
        @mkdir(dirname($path), 0775, true);
        file_put_contents($path, json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }

    public function index()
    {
        return view('landing', ['catalog' => $this->loadCatalog()]);
    }

    public function loginForm()
    {
        return view('admin.login', ['catalog' => $this->loadCatalog()]);
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);
        $expected = (string) env('ADMIN_PASSWORD', '');

        // No fallback password: empty ADMIN_PASSWORD must lock admin, not open it.
        if ($expected === '' || !hash_equals($expected, (string) $request->input('password'))) {
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
        $json = json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $filename = 'catalog-backup-' . date('Y-m-d') . '.json';
        return response($json, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
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

        if (array_key_exists('about_title', $data) && $data['about_title'] !== null) {
            $catalog['about_title'] = $data['about_title'];
        }
        if (array_key_exists('about_subtitle', $data) && $data['about_subtitle'] !== null) {
            $catalog['about_subtitle'] = $data['about_subtitle'];
        }
        if (array_key_exists('about_features_text', $data) && $data['about_features_text'] !== null) {
            $icons = ['verified_user', 'inventory', 'terminal', 'headset_mic', 'build', 'thumb_up'];
            $features = [];
            foreach (preg_split('/\r\n|\r|\n/', (string) $data['about_features_text']) as $idx => $line) {
                $line = trim($line);
                if ($line === '') continue;
                $parts = array_map('trim', explode('|', $line, 3));
                if (!empty($parts[0])) {
                    $features[] = [
                        'title' => $parts[0],
                        'desc' => $parts[1] ?? '',
                        'icon' => !empty($parts[2]) ? $parts[2] : ($icons[$idx % count($icons)]),
                    ];
                }
            }
            if (!empty($features)) {
                $catalog['about_features'] = $features;
            }
        }
        if (array_key_exists('contact_title', $data) && $data['contact_title'] !== null) {
            $catalog['contact_title'] = $data['contact_title'];
        }
        if (array_key_exists('contact_subtitle', $data) && $data['contact_subtitle'] !== null) {
            $catalog['contact_subtitle'] = $data['contact_subtitle'];
        }
        if (array_key_exists('map_image', $data) && $data['map_image'] !== null) {
            $catalog['map_image'] = $data['map_image'];
        }
        if (array_key_exists('map_link', $data) && $data['map_link'] !== null) {
            $catalog['map_link'] = $data['map_link'];
        }
        if (array_key_exists('faq_text', $data) && $data['faq_text'] !== null) {
            $faqs = [];
            foreach (preg_split('/\r\n|\r|\n/', (string) $data['faq_text']) as $line) {
                $line = trim($line);
                if ($line === '') continue;
                $parts = array_map('trim', explode('|', $line, 2));
                if (!empty($parts[0])) {
                    $faqs[] = [
                        'q' => $parts[0],
                        'a' => $parts[1] ?? '',
                    ];
                }
            }
            if (!empty($faqs)) {
                $catalog['faqs'] = $faqs;
            }
        }

        $this->saveCatalog($catalog);
        return redirect('/admin')->with('status', 'Pengaturan toko, hero deal, tentang kami & kontak berhasil diperbarui.');
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

        if (empty($images) && !empty($data['image'])) {
            foreach (preg_split('/\r\n|\r|\n|;/', (string) $data['image']) as $rawUrl) {
                $url = trim($rawUrl);
                if ($url === '') {
                    continue;
                }
                if (filter_var($url, FILTER_VALIDATE_URL) || str_starts_with($url, '/uploads/products/')) {
                    $images[] = $url;
                }
            }
        }

        return array_values(array_unique($images));
    }

    private function buildProduct(array $data, array $uploadedFiles = []): ?array
    {
        $images = $this->extractImages($data, $uploadedFiles);
        if (empty($images)) {
            return null;
        }

        $specs = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n|;/', $data['specs_text']))));
        $variants = [];
        foreach (preg_split('/\r\n|\r|\n|;/', $data['variants_text']) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $parts = array_map('trim', explode('|', $line));
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
            'badge' => $data['badge'],
            'image' => $images[0],
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
                $catalog['products'][$idx] = $product;
                return;
            }
        }
        $catalog['products'][] = $product;
    }

    public function saveProduct(Request $request)
    {
        $data = $request->validate($this->productRules());
        $files = $request->file('photos', []);
        $product = $this->buildProduct($data, is_array($files) ? $files : [$files]);

        if (!$product) {
            return redirect('/admin')->withErrors(['product' => 'Pastikan minimal 1 foto (upload/URL) dan format varian (Label | Harga Promo | Harga Coret) valid.']);
        }

        $catalog = $this->loadCatalog();
        $this->upsertProduct($catalog, $product);
        $this->saveCatalog($catalog);

        return redirect('/admin')->with('status', 'Produk berhasil disimpan.');
    }

    public function downloadTemplate()
    {
        $rows = [
            ['id', 'name', 'brand', 'category', 'badge', 'image', 'specs_text', 'variants_text'],
            [
                'laptop-acer-aspire-5',
                'Acer Aspire 5 Slim 14"',
                'Acer',
                'Laptop',
                'Promo Kuliah',
                'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80',
                'Layar 14" IPS FHD;Garansi Resmi 2 Tahun;Windows 11 Original',
                'Core i3 / 8GB / 512GB SSD | 5799000 | 6399000;Core i5 / 16GB / 512GB SSD | 7699000 | 8299000',
            ],
            [
                'printer-canon-g2020',
                'Canon PIXMA G2020 Ink Tank',
                'Canon',
                'Printer',
                'Siap Cetak',
                'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?auto=format&fit=crop&w=800&q=80',
                'Print Scan Copy;Tinta Botol Hemat;Garansi Resmi',
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

        $headers = array_map(fn ($h) => strtolower(trim((string) $h)), fgetcsv($fh, 0, $delimiter) ?: []);
        $expected = ['id', 'name', 'brand', 'category', 'badge', 'image', 'specs_text', 'variants_text'];
        if ($headers !== $expected) {
            fclose($fh);
            return redirect('/admin')->withErrors(['import' => 'Header kolom tidak sesuai template. Gunakan kolom: ' . implode(', ', $expected)]);
        }

        $parsedProducts = [];
        $lineNum = 1;
        while (($row = fgetcsv($fh, 0, $delimiter)) !== false) {
            $lineNum++;
            if ($row === [null] || empty(array_filter($row, fn ($v) => trim((string) $v) !== ''))) {
                continue;
            }
            $assoc = array_combine($expected, array_pad(array_slice(array_map('trim', $row), 0, 8), 8, ''));
            $validator = Validator::make($assoc, $this->productRules());
            if ($validator->fails()) {
                fclose($fh);
                return redirect('/admin')->withErrors(['import' => "Baris {$lineNum}: " . $validator->errors()->first()]);
            }
            $product = $this->buildProduct($assoc);
            if (!$product) {
                fclose($fh);
                return redirect('/admin')->withErrors(['import' => "Baris {$lineNum}: Format varian tidak valid."]);
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
