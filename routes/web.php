<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// ─── Public ───────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// ─── User (phai dang nhap) ────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/cart',       [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',  [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout',  [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/my-orders',  [CartController::class, 'myOrders'])->name('user.orders');
});

// ─── Admin ────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                          [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/products',                 [AdminController::class, 'store'])->name('products.store');
    Route::post('/products/{id}',            [AdminController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}',          [AdminController::class, 'delete'])->name('products.delete');
    Route::get('/orders',                    [AdminController::class, 'orders'])->name('orders');
});
