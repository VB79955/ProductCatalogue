<?php

use App\Http\Controllers\Web\EnquiryController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('products.category');
Route::post('/products/{id}/enquiries', [EnquiryController::class, 'store'])->whereNumber('id')->name('enquiries.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->whereNumber('id')->name('products.show');
Route::get('/enquiries/thank-you/{reference}', [EnquiryController::class, 'thankYou'])->name('enquiries.thank-you');
