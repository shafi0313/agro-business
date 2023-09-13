<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocalizationController;

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

Route::get('/locale/{locale}', [LocalizationController::class, 'locale']);


Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/register-store', [AuthController::class, 'registerStore'])->name('registerStore');
Route::get('/register-verify/{token}', [AuthController::class, 'registerVerify'])->name('registerVerify');
Route::get('/verify-notification', [AuthController::class, 'verifyNotification'])->name('verifyNotification');

Route::post('/verify-resend', [AuthController::class, 'verifyResend'])->name('verifyResend');

Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
Route::post('/forget-password-process', [AuthController::class, 'forgetPasswordProcess'])->name('forgetPasswordProcess');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password-process', [AuthController::class, 'resetPasswordProcess'])->name('resetPasswordProcess');
Route::get('/reset-verify-notification', [AuthController::class, 'resetVerifyNotification'])->name('resetVerifyNotification');

Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware('compressed')->group(function () {
// Route::middleware('compressed')->group(function () {
    Route::get('/', 'App\Http\Controllers\Frontend\IndexController@index')->name('index');
    Route::get('/all-products', 'App\Http\Controllers\Frontend\IndexController@allProducts')->name('allProducts');
    Route::get('/all-products/{catId}', 'App\Http\Controllers\Frontend\IndexController@productsByCat')->name('allProductByCategory');
    Route::get('/read-product/{id}', 'App\Http\Controllers\Frontend\IndexController@productDetails')->name('productDetails');
    Route::get('/about', 'App\Http\Controllers\Frontend\IndexController@about')->name('about');
    Route::get('/contact', 'App\Http\Controllers\Frontend\IndexController@contact')->name('contact');
// });
