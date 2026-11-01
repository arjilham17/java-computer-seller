<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    private string $backupPath;
    private string $storePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storePath = storage_path('app/catalog.json');
        $this->backupPath = storage_path('app/catalog.json.testbak');
        if (file_exists($this->storePath)) {
            copy($this->storePath, $this->backupPath);
            @unlink($this->storePath);
        }
    }

    protected function tearDown(): void
    {
        @unlink($this->storePath);
        if (file_exists($this->backupPath)) {
            rename($this->backupPath, $this->storePath);
        }
        parent::tearDown();
    }

    public function test_landing_page_renders_brand_bootstrap_and_all_categories(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Java Computer Seller');
        $response->assertSee('bootstrap@5.3.3/dist/css/bootstrap.min.css', false);
        $response->assertSee('rel="icon"', false);
        $response->assertSee('/favicon.svg');
        $response->assertSee('https://maps.app.goo.gl/qmSLZJgEqVFwbqXh8');
        $response->assertSee('-7.3425692,108.1080775');
        $response->assertSee('catalog-empty-state');
        $response->assertSee('Produk Tidak Ditemukan');

        foreach (['Laptop', 'PC', 'Printer', 'Monitor', 'Aksesoris'] as $category) {
            $response->assertSee($category);
        }
    }

    public function test_catalog_config_contains_valid_variants_and_whatsapp_links(): void
    {
        $catalog = config('catalog');
        $this->assertNotEmpty($catalog['whatsapp_number']);
        $this->assertNotEmpty($catalog['products']);

        foreach ($catalog['products'] as $product) {
            $this->assertNotEmpty($product['variants'], "Product {$product['name']} must have variants");
            foreach ($product['variants'] as $variant) {
                $this->assertGreaterThan(0, $variant['promo_price']);
                $this->assertLessThanOrEqual($variant['original_price'], $variant['promo_price']);
            }
        }

        $response = $this->get('/');
        $response->assertSee('https://wa.me/' . $catalog['whatsapp_number'], false);
    }

    public function test_admin_requires_login_and_can_update_landing_content_and_products(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertStatus(200)->assertSee('Login Admin');

        $this->post('/admin/login', ['password' => 'wrong-password'])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('password');

        $this->post('/admin/login', [
            'password' => env('ADMIN_PASSWORD'),
        ])->assertRedirect('/admin');

        $this->get('/admin')->assertStatus(200)->assertSee('Dashboard Admin');

        $this->post('/admin/settings', [
            'store_name' => 'Java Computer Seller Official',
            'tagline' => 'Pusat Komputer Resmi & Bergaransi',
            'whatsapp_number' => '6281122334455',
            'address' => 'Jl. Merdeka No. 10',
            'hours' => '08.00 - 21.00 WIB',
            'instagram_url' => 'https://instagram.com/javacomp.id',
            'tiktok_url' => 'https://tiktok.com/@javacomp.id',
            'facebook_url' => 'https://facebook.com/javacomp.id',
            'hero_badge' => 'PROMO SPESIAL',
            'hero_title' => 'ASUS ROG Strix G16',
            'hero_subtitle' => 'Core i7 • RTX 4060 • 16GB RAM',
            'hero_original_price' => 22999000,
            'hero_promo_price' => 20999000,
            'hero_bonus' => 'Gratis Mouse Gaming',
        ])->assertRedirect('/admin');

        $this->post('/admin/products', [
            'id' => 'monitor-samsung-24',
            'name' => 'Samsung Essential Monitor S3',
            'brand' => 'Samsung',
            'category' => 'Monitor',
            'badge' => 'Produk Baru',
            'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
            'specs_text' => "Panel IPS\n100Hz Refresh Rate",
            'variants_text' => "24 Inch FHD | 1450000 | 1690000\n27 Inch FHD | 1890000 | 2150000",
        ])->assertRedirect('/admin');

        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('Java Computer Seller Official');
        $home->assertSee('ASUS ROG Strix G16');
        $home->assertSee('Samsung Essential Monitor S3');
        $home->assertSee('https://wa.me/6281122334455', false);
        $home->assertSee('https://instagram.com/javacomp.id');
        $home->assertSee('https://tiktok.com/@javacomp.id');
        $home->assertSee('https://facebook.com/javacomp.id');

        $this->delete('/admin/products/monitor-samsung-24')->assertRedirect('/admin');
        $this->get('/')->assertDontSee('Samsung Essential Monitor S3');
    }

    public function test_admin_can_download_excel_template_and_bulk_import_products(): void
    {
        $this->post('/admin/login', [
            'password' => env('ADMIN_PASSWORD'),
        ])->assertRedirect('/admin');

        $template = $this->get('/admin/products/template');
        $template->assertStatus(200);
        $this->assertStringContainsString('id,name,brand,category,badge,image,specs_text,variants_text', $template->getContent());

        $csv = implode("\n", [
            'id,name,brand,category,badge,image,specs_text,variants_text',
            '"laptop-hp-14s","HP 14s Ryzen 5","HP","Laptop","Promo Kampus","https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80","Layar FHD;Garansi 2 Tahun","8GB / 512GB SSD | 6299000 | 6899000;16GB / 512GB SSD | 6999000 | 7599000"',
            '"aksesoris-mouse-g102","Logitech G102 Lightsync","Logitech","Aksesoris","Best Seller","https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=800&q=80","Sensor 8000 DPI;RGB Lightsync","Hitam | 239000 | 299000;Putih | 245000 | 299000"',
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->createWithContent('produk-massal.csv', $csv);
        $this->post('/admin/products/import', ['file' => $file])
            ->assertRedirect('/admin')
            ->assertSessionHasNoErrors();

        $home = $this->get('/');
        $home->assertSee('HP 14s Ryzen 5');
        $home->assertSee('Logitech G102 Lightsync');

        $badCsv = "id,name,brand,category,badge,image,specs_text,variants_text\nbad-id,Produk,Brand,KategoriSalah,Badge,https://example.com/a.jpg,Spec,Varian | 1000 | 2000";
        $badFile = \Illuminate\Http\UploadedFile::fake()->createWithContent('bad.csv', $badCsv);
        $this->post('/admin/products/import', ['file' => $badFile])
            ->assertRedirect('/admin')
            ->assertSessionHasErrors('import');
    }

    public function test_admin_can_upload_multiple_product_photos(): void
    {
        $this->post('/admin/login', [
            'password' => env('ADMIN_PASSWORD'),
        ])->assertRedirect('/admin');

        $tinyPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        $photo1 = \Illuminate\Http\UploadedFile::fake()->createWithContent('depan.png', $tinyPng);
        $photo2 = \Illuminate\Http\UploadedFile::fake()->createWithContent('samping.png', $tinyPng);

        $this->post('/admin/products', [
            'id' => 'laptop-multi-foto',
            'name' => 'Laptop Multi Foto Series',
            'brand' => 'ASUS',
            'category' => 'Laptop',
            'badge' => 'Galeri Lengkap',
            'photos' => [$photo1, $photo2],
            'specs_text' => "Layar OLED\nRAM 16GB",
            'variants_text' => "16GB / 512GB | 9500000 | 10500000",
        ])->assertRedirect('/admin')->assertSessionHasNoErrors();

        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('carousel-laptop-multi-foto', false);
        $home->assertSee('/uploads/products/laptop-multi-foto-', false);

        foreach (glob(public_path('uploads/products/laptop-multi-foto-*')) ?: [] as $f) {
            @unlink($f);
        }
    }

    public function test_admin_can_change_and_remove_logo(): void
    {
        $this->post('/admin/login', ['password' => env('ADMIN_PASSWORD')]);
        $settings = [
            'store_name' => 'Java Computer Seller',
            'tagline' => 'Tagline',
            'whatsapp_number' => '6281234567890',
            'address' => 'Alamat',
            'hours' => '09.00 - 20.00',
            'hero_badge' => 'PROMO',
            'hero_title' => 'Judul',
            'hero_subtitle' => 'Sub',
            'hero_original_price' => 2000,
            'hero_promo_price' => 1000,
            'hero_bonus' => 'Bonus',
        ];
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');

        $this->post('/admin/settings', $settings + [
            'logo' => \Illuminate\Http\UploadedFile::fake()->createWithContent('logo.png', $png),
        ])->assertRedirect('/admin')->assertSessionHasNoErrors();
        $this->get('/')->assertSee('/uploads/logo/logo-', false)->assertDontSee('>JC<', false);

        $this->post('/admin/settings', $settings + ['remove_logo' => '1'])->assertRedirect('/admin');
        $this->get('/')->assertDontSee('/uploads/logo/', false)->assertSee('>JC<', false);

        $this->post('/admin/settings', $settings + [
            'logo' => \Illuminate\Http\UploadedFile::fake()->createWithContent('logo.svg', '<svg onload="alert(1)"/>'),
        ])->assertSessionHasErrors('logo');

        foreach (glob(public_path('uploads/logo/logo-*')) ?: [] as $f) {
            @unlink($f);
        }
    }

    public function test_admin_can_update_about_us_and_contact_content(): void
    {
        $this->post('/admin/login', ['password' => env('ADMIN_PASSWORD')]);
        $settings = [
            'store_name' => 'Java Computer Seller',
            'tagline' => 'Tagline Toko Komputer',
            'whatsapp_number' => '6281234567890',
            'address' => 'Jl. Kaliurang KM 5 No. 12, Sleman',
            'hours' => '09.00 - 21.00 WIB',
            'hero_badge' => 'PROMO SPECIAL',
            'hero_title' => 'PC Gaming Monster',
            'hero_subtitle' => 'RTX 4080 • Core i9',
            'hero_original_price' => 35000000,
            'hero_promo_price' => 32000000,
            'hero_bonus' => 'Bonus Keyboard Mechanical',
            'about_title' => 'KEUNGGULAN UTAMA WORKSHOP KAMI',
            'about_subtitle' => 'Layanan rakit PC spesialis gaming & workstation.',
            'about_features_text' => "Komponen 100% Asli | Bergaransi distributor resmi dan ada nota fisik | verified_user\nTeknisi Berpengalaman | Siap bantu uji performa dan instalasi sistem",
            'contact_title' => 'KUNJUNGI SHOWROOM KAMI',
            'contact_subtitle' => 'Silakan datang langsung untuk konsultasi hardware dan benchmark.',
            'map_image' => 'https://example.com/custom-map.png',
            'map_link' => 'https://maps.app.goo.gl/custom-location',
            'faq_text' => "Apakah bisa rakit langsung di tempat? | Ya, teknisi kami dapat merakit di depan Anda langsung.\nApakah ada garansi toko? | Ya, ada garansi tukar baru 7 hari pertama.",
        ];

        $this->post('/admin/settings', $settings)
            ->assertRedirect('/admin')
            ->assertSessionHasNoErrors();

        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('KEUNGGULAN UTAMA WORKSHOP KAMI');
        $home->assertSee('Layanan rakit PC spesialis gaming & workstation.');
        $home->assertSee('Komponen 100% Asli');
        $home->assertSee('Bergaransi distributor resmi dan ada nota fisik');
        $home->assertSee('Teknisi Berpengalaman');
        $home->assertSee('KUNJUNGI SHOWROOM KAMI');
        $home->assertSee('Silakan datang langsung untuk konsultasi hardware dan benchmark.');
        $home->assertSee('Jl. Kaliurang KM 5 No. 12, Sleman');
        $home->assertSee('https://example.com/custom-map.png');
        $home->assertSee('https://maps.app.goo.gl/custom-location');
        $home->assertSee('Apakah bisa rakit langsung di tempat?');
        $home->assertSee('Ya, teknisi kami dapat merakit di depan Anda langsung.');
    }

    public function test_admin_can_toggle_product_sold_out(): void
    {
        $this->post('/admin/products/laptop-lenovo-ideapad/toggle-sold')
            ->assertRedirect('/admin/login');

        $this->post('/admin/login', ['password' => env('ADMIN_PASSWORD')]);

        $this->post('/admin/products/laptop-lenovo-ideapad/toggle-sold')
            ->assertRedirect('/admin')
            ->assertSessionHas('status');

        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('SOLD OUT');
        $home->assertSee('Sold Out (Tanya Restock)');

        $this->post('/admin/products/laptop-lenovo-ideapad/toggle-sold')
            ->assertRedirect('/admin');

        $homeAgain = $this->get('/');
        $homeAgain->assertStatus(200);
        $homeAgain->assertSee('UNIT READY STOCK');
    }

    public function test_admin_can_download_backup_json(): void
    {
        $this->get('/admin/backup')->assertRedirect('/admin/login');

        $this->post('/admin/login', ['password' => env('ADMIN_PASSWORD')]);

        $response = $this->get('/admin/backup');
        $response->assertStatus(200);
        $this->assertStringContainsString('application/json', (string) $response->headers->get('content-type'));
        $this->assertStringContainsString('catalog-backup-', (string) $response->headers->get('content-disposition'));

        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('store_name', $data);
        $this->assertArrayHasKey('products', $data);
    }

    public function test_admin_deleting_product_and_changing_logo_cleans_orphaned_files(): void
    {
        $this->post('/admin/login', ['password' => env('ADMIN_PASSWORD')]);

        // Test orphaned product image deletion
        $testUploadDir = public_path('uploads/products');
        @mkdir($testUploadDir, 0775, true);
        $testImageName = 'test-orphan-' . uniqid() . '.jpg';
        $testImagePath = $testUploadDir . '/' . $testImageName;
        file_put_contents($testImagePath, 'fake-image-bytes');
        $this->assertFileExists($testImagePath);

        // Save a test product referencing this uploaded image
        $this->post('/admin/products', [
            'id' => 'test-orphan-product',
            'name' => 'Produk Orphan Test',
            'brand' => 'TestBrand',
            'category' => 'Aksesoris',
            'badge' => 'Test',
            'image' => '/uploads/products/' . $testImageName,
            'specs_text' => 'Spec A;Spec B',
            'variants_text' => 'Varian 1 | 50000 | 60000',
        ])->assertRedirect('/admin');

        // Delete the product
        $this->delete('/admin/products/test-orphan-product')->assertRedirect('/admin');
        $this->assertFileDoesNotExist($testImagePath);

        // Test orphaned logo deletion when removed
        $logoDir = public_path('uploads/logo');
        @mkdir($logoDir, 0775, true);
        $testLogoName = 'logo-orphan-' . uniqid() . '.png';
        $testLogoPath = $logoDir . '/' . $testLogoName;
        file_put_contents($testLogoPath, 'fake-logo-bytes');
        $this->assertFileExists($testLogoPath);

        // Force set catalog logo to this test file
        $catalogPath = storage_path('app/catalog.json');
        $catalog = json_decode(file_get_contents($catalogPath), true);
        $catalog['logo'] = '/uploads/logo/' . $testLogoName;
        file_put_contents($catalogPath, json_encode($catalog));

        // Remove logo via admin settings
        $settingsData = [
            'store_name' => $catalog['store_name'],
            'tagline' => $catalog['tagline'],
            'whatsapp_number' => $catalog['whatsapp_number'],
            'address' => $catalog['address'],
            'hours' => $catalog['hours'],
            'hero_badge' => 'PROMO SPESIAL',
            'hero_title' => 'ASUS ROG Strix G16',
            'hero_subtitle' => 'Core i7 • RTX 4060 • 16GB RAM',
            'hero_original_price' => 22999000,
            'hero_promo_price' => 20999000,
            'hero_bonus' => 'Gratis Mouse Gaming',
            'remove_logo' => 1,
        ];
        $this->post('/admin/settings', $settingsData)->assertRedirect('/admin');
        $this->assertFileDoesNotExist($testLogoPath);
    }

    public function test_admin_can_upload_photo_exceeding_4mb_and_dashboard_has_compression_script(): void
    {
        $this->post('/admin/login', [
            'password' => env('ADMIN_PASSWORD'),
        ])->assertRedirect('/admin');

        $admin = $this->get('/admin');
        $admin->assertSee('compressImageIfNeeded');
        $admin->assertSee('Foto &gt; 4096 KB (4 MB) otomatis dikompres', false);

        $tinyPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        $largePhoto = \Illuminate\Http\UploadedFile::fake()->createWithContent('foto-5mb.png', $tinyPng . str_repeat('0', 5000000));

        $this->post('/admin/products', [
            'id' => 'laptop-foto-besar',
            'name' => 'Laptop Foto Besar',
            'brand' => 'Lenovo',
            'category' => 'Laptop',
            'badge' => 'High Res',
            'photos' => [$largePhoto],
            'specs_text' => "Layar 4K\nRAM 32GB",
            'variants_text' => "32GB / 1TB | 15000000 | 16500000",
        ])->assertRedirect('/admin')->assertSessionHasNoErrors();

        $this->get('/')->assertSee('/uploads/products/laptop-foto-besar-', false);

        foreach (glob(public_path('uploads/products/laptop-foto-besar-*')) ?: [] as $f) {
            @unlink($f);
        }
    }
}
