<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::get('/products/featured', [ProductApiController::class, 'featured']);
Route::get('/products/{id}', [ProductApiController::class, 'show'])->whereNumber('id');
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/categories/{category}/products', [CategoryApiController::class, 'products']);
Route::get('/categories', [CategoryApiController::class, 'index']);
