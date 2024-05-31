<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\CheckPermission;

Route::get('/', [ShopController::class, 'index']);

Route::get('/hello', [HomeController::class, 'xinchao']);
Route::get('/users', [HomeController::class, 'getUsers']);
Route::get('/product', [ProductController::class, 'productview']);
Route::get('/product/search', [ProductController::class, 'productSearch']);
Route::get('/product/{id}', [ProductController::class, 'productdetail']);
Route::get('/shop', [ShopController::class, 'index']);
Route::get('/shop/{id}', [ShopController::class, 'shopchitiet']);
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('cart', CartController::class);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('tabletkindfire@gmail.com')
            ->subject('Test Email');
    });
    return 'Email sent successfully';
})->middleware(CheckPermission::class);
require __DIR__ . '/auth.php';
