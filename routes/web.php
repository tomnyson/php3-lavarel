<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;

Route::get('/', function () {
    return view('home');
});

Route::get('/hello', [HomeController::class, 'xinchao']);
Route::get('/users', [HomeController::class, 'getUsers']);
Route::get('/product', [ProductController::class, 'productview']);
Route::get('/product/search', [ProductController::class, 'productSearch']);
Route::get('/product/{id}', [ProductController::class, 'productdetail']);
Route::get('/shop', [ShopController::class, 'shopview']);
Route::get('/shop/{id}', [ShopController::class, 'shopchitiet']);
