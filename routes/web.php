<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dd('Welcome');
    return view('welcome');
});
Route::get('/login', [LoginController::class,'authenticate']);
    
Route::get('/home', [HomeController::class, 'index']);

Route::get('/products', [ProductController::class,'index']);

Route::get('/product/{slug}', [ProductController::class,'show']);

Route::post('/cart', [CartController::class, 'add']);

Route::get('/cart', [CartController::class, 'show']);

Route::get('/checkout', [CheckoutController::class, 'show']);

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::delete('/cart/remove', [CartController::class, 'delete']);

Route::get('/payment/{paymentGetway}', [PaymentController::class, 'show'])->name('payment.show');

Route::get('/about', function () {
    return view ('\about');
   
});
Route::post('/contact', function () {
    return view ('\contact');
   
});
Route::get('/category', [CategoryController::class, 'getAction']);
   


