<?php

use App\Http\Controllers\CatalogController;
use App\Http\Middleware\EnsureAdminAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('landing');
Route::get('/admin/login', [CatalogController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [CatalogController::class, 'login'])
    ->middleware('throttle:10,1')
    ->name('admin.login.post');
Route::post('/admin/logout', [CatalogController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware(EnsureAdminAuthenticated::class)->group(function () {
    Route::get('/', [CatalogController::class, 'admin'])->name('admin.dashboard');
    Route::get('/backup', [CatalogController::class, 'backupCatalog'])->name('admin.backup');
    Route::post('/settings', [CatalogController::class, 'updateSettings'])->name('admin.settings');
    Route::get('/products/template', [CatalogController::class, 'downloadTemplate'])->name('admin.products.template');
    Route::post('/products/import', [CatalogController::class, 'importProducts'])->name('admin.products.import');
    Route::post('/products', [CatalogController::class, 'saveProduct'])->name('admin.products.save');
    Route::post('/products/{id}/toggle-sold', [CatalogController::class, 'toggleSoldOut'])->name('admin.products.toggle_sold');
    Route::delete('/products/{id}', [CatalogController::class, 'deleteProduct'])->name('admin.products.delete');
});
