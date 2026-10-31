<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('landing');
Route::get('/admin/login', [CatalogController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [CatalogController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [CatalogController::class, 'logout'])->name('admin.logout');
Route::get('/admin', [CatalogController::class, 'admin'])->name('admin.dashboard');
Route::post('/admin/settings', [CatalogController::class, 'updateSettings'])->name('admin.settings');
Route::get('/admin/products/template', [CatalogController::class, 'downloadTemplate'])->name('admin.products.template');
Route::post('/admin/products/import', [CatalogController::class, 'importProducts'])->name('admin.products.import');
Route::post('/admin/products', [CatalogController::class, 'saveProduct'])->name('admin.products.save');
Route::delete('/admin/products/{id}', [CatalogController::class, 'deleteProduct'])->name('admin.products.delete');
