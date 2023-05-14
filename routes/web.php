<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::resource('product', ProductController::class);
Route::resource('cart', CartController::class);
Route::resource('cart-detail', CartDetailController::class);
