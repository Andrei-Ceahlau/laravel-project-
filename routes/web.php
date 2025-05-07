<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageUpdateController;
use App\Http\Controllers\ImageUpdaterController;
use App\Http\Controllers\SearchController;

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

// Pagina principală redirectează către dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard și pagini asociate
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta pentru logout
Route::post('/logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Rute pentru produse
Route::resource('products', ProductController::class);

// Rute pentru acțiuni rapide produse
Route::get('/products/{product}/edit-price', [ProductController::class, 'editPrice'])->name('products.edit-price');
Route::put('/products/{product}/update-price', [ProductController::class, 'updatePrice'])->name('products.update-price');
Route::post('/products/{product}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
Route::get('/products/{product}/report', [ProductController::class, 'generateReport'])->name('products.report');
Route::get('/products-export', [ProductController::class, 'export'])->name('products.export');

// Rute pentru gestionarea stocului
Route::get('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add-stock');
Route::put('/products/{product}/update-add-stock', [ProductController::class, 'updateAddStock'])->name('products.update-add-stock');
Route::get('/products/{product}/adjust-stock', [ProductController::class, 'adjustStock'])->name('products.adjust-stock');
Route::put('/products/{product}/update-adjust-stock', [ProductController::class, 'updateAdjustStock'])->name('products.update-adjust-stock');

// Ruta pentru actualizare imagini
Route::get('/update-product-images', [ImageUpdateController::class, 'updateProductImages'])->name('update.product.images');
// Ruta pentru noul controller de actualizare imagini
Route::get('/update-images', [ImageUpdaterController::class, 'updateImages'])->name('update.images');

// Rute pentru ordere
Route::resource('orders', OrderController::class);
Route::get('/orders-export', [OrderController::class, 'export'])->name('orders.export');

// Coș de cumpărături
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Recenzii pentru produse
Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/products/{product}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Ruta pentru căutare globală
Route::get('/search', [SearchController::class, 'search'])->name('search');
