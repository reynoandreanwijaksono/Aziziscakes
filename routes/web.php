<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{HomeController, ProductController, CartController, CheckoutController, OrderController};
use App\Http\Controllers\Admin\{DashboardController, ProductController as AdminProductController, BrandController, OrderController as AdminOrderController, PaymentController, ShipmentController, UserController, WebsiteContentController};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze / Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::put('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Orders
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/bukti-bayar', [OrderController::class, 'uploadPaymentProof'])->name('orders.payment-proof');
    Route::post('/pesanan/{order}/batal', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/pesanan/{order}/batal', [OrderController::class, 'cancel'])->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Brands
    Route::resource('brands', BrandController::class)->except(['show', 'edit', 'create']);

    // Products
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::delete('products/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Website Content
    Route::get('website-content', [WebsiteContentController::class, 'index'])->name('settings.website.index');
    Route::put('website-content', [WebsiteContentController::class, 'update'])->name('settings.website.update');

    // Payments
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::put('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.status');
    Route::patch('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');

    // Shipments
    Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::put('shipments/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');
    Route::patch('shipments/{shipment}', [ShipmentController::class, 'update']);

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
});
