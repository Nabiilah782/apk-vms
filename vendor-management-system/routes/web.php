<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataVendorController;
use App\Http\Controllers\ServiceCatalogController;
use App\Http\Controllers\ListServiceCatalogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home route
Route::get('/', function () {
    return view('dashboard.index');
})->name('home');

// Vendor routes (tanpa API)
Route::prefix('data-vendors')->name('data_vendors.')->group(function () {
    // CRUD Routes
    Route::get('/', [DataVendorController::class, 'index'])->name('index');
    Route::get('/create', [DataVendorController::class, 'create'])->name('create');
    Route::post('/', [DataVendorController::class, 'store'])->name('store');
    Route::get('/{data_vendor}/edit', [DataVendorController::class, 'edit'])->name('edit');
    Route::put('/{data_vendor}', [DataVendorController::class, 'update'])->name('update');
    Route::delete('/{data_vendor}', [DataVendorController::class, 'destroy'])->name('destroy');
});

// Document routes
Route::prefix('vendor-documents')->name('vendor.documents.')->group(function () {
    Route::delete('/{id}', [DataVendorController::class, 'deleteDocument'])->name('delete');
    Route::get('/download/{id}', [DataVendorController::class, 'downloadDocument'])->name('download');
    Route::get('/view/{id}', [DataVendorController::class, 'viewDocument'])->name('view');
    
    // Route untuk modal dokumen (non-API)
    Route::get('/vendor/{id}', [DataVendorController::class, 'getVendorDocuments'])->name('vendor');
});

// Service Catalog routes
Route::prefix('service-catalog')->name('service_catalog.')->group(function () {
    Route::get('/', [ServiceCatalogController::class, 'index'])->name('index');
    Route::get('/create', [ServiceCatalogController::class, 'create'])->name('create');
    Route::post('/', [ServiceCatalogController::class, 'store'])->name('store');
    Route::get('/{service_catalog}/edit', [ServiceCatalogController::class, 'edit'])->name('edit');
    Route::put('/{service_catalog}', [ServiceCatalogController::class, 'update'])->name('update');
    Route::delete('/{service_catalog}', [ServiceCatalogController::class, 'destroy'])->name('destroy');
});

// List Service Catalog routes
Route::prefix('list-service-catalog')->name('list_service_catalog.')->group(function () {
    Route::get('/', [ListServiceCatalogController::class, 'index'])->name('index');
    Route::get('/create', [ListServiceCatalogController::class, 'create'])->name('create');
    Route::post('/', [ListServiceCatalogController::class, 'store'])->name('store');
    Route::get('/{list_service_catalog}/edit', [ListServiceCatalogController::class, 'edit'])->name('edit');
    Route::put('/{list_service_catalog}', [ListServiceCatalogController::class, 'update'])->name('update');
    Route::delete('/{list_service_catalog}', [ListServiceCatalogController::class, 'destroy'])->name('destroy');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index');

// Fallback route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});