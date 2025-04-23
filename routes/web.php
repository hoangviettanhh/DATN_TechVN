<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StatisticsController;

// Web Routes
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Web Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
    
    // Email Verification Routes
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])->name('verification.resend');
});

// Web Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/checkout/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('checkout.vnpay-return');
    Route::get('/order/success/{id}', [CheckoutController::class, 'orderSuccess'])->name('order.success');
});

// Admin routes
Route::prefix('admin')->middleware('web')->group(function () {
    // Guest routes (Login)
    Route::middleware('guest')->group(function () {
        Route::get('users/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('users/login/store', [LoginController::class, 'login'])->name('admin.login.store');
        Route::get('users/register', [LoginController::class, 'showRegisterForm'])->name('admin.register');
        Route::post('users/register/store', [LoginController::class, 'register'])->name('admin.register.store');
    });

    // Protected routes
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('admin.dashboard');
        Route::get('main', [MainController::class, 'index']);
        Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Category Routes
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.list');
            Route::get('/add', [CategoryController::class, 'create'])->name('admin.categories.add');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
            Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
            Route::post('/deactivate/{id}', [CategoryController::class, 'deactivate'])->name('admin.categories.deactivate');
            Route::post('/activate/{id}', [CategoryController::class, 'activate'])->name('admin.categories.activate');
        });

        // Product Routes
        Route::prefix('products')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.list');
            Route::get('/add', [AdminProductController::class, 'create'])->name('admin.products.add');
            Route::post('/store', [AdminProductController::class, 'store'])->name('admin.products.store');
            Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
            Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
            Route::delete('/destroy/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
            Route::delete('/images/{id}', [AdminProductController::class, 'destroyImage'])->name('admin.products.images.destroy');
            Route::post('/deactivate/{id}', [AdminProductController::class, 'deactivate'])->name('admin.products.deactivate');
            Route::post('/activate/{id}', [AdminProductController::class, 'activate'])->name('admin.products.activate');
        });

        // User Routes
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.list');
            Route::get('/add', [UserController::class, 'create'])->name('admin.users.add');
            Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
            Route::get('/edit/{id_user}', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/update/{id_user}', [UserController::class, 'update'])->name('admin.users.update');
            Route::delete('/destroy/{id_user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
            Route::post('/deactivate/{id_user}', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
            Route::post('/activate/{id_user}', [UserController::class, 'activate'])->name('admin.users.activate');
        });

        // Admin Order Routes
        Route::prefix('orders')->name('admin.orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('list');
            Route::get('/show/{id_order}', [AdminOrderController::class, 'show'])->name('show');
            Route::get('/edit/{id_order}', [AdminOrderController::class, 'edit'])->name('edit');
            Route::put('/update/{id_order}', [AdminOrderController::class, 'update'])->name('update');
            Route::post('/confirm/{id_order}', [AdminOrderController::class, 'confirm'])->name('confirm');
            Route::post('/cancel/{id_order}', [AdminOrderController::class, 'cancel'])->name('cancel');
        });

        // Statistics Routes
        Route::prefix('statistics')->name('admin.statistics.')->group(function () {
            Route::get('/revenue', [StatisticsController::class, 'revenue'])->name('revenue');
            Route::get('/revenue/export', [StatisticsController::class, 'exportRevenue'])->name('revenue.export');
        });
    });
});
