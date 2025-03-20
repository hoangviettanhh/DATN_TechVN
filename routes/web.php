<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::prefix('admin')->group(function () {
    Route::get('/products/create', [AdminController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'store'])->name('admin.products.store');
});
