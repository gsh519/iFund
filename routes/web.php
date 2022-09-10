<?php

use App\Http\Controllers\CreatePaymentController;
use App\Http\Controllers\FetchBalanceController;
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

// トップページ
Route::get('/', [FetchBalanceController::class, 'init'])->name('home');

// 支出投稿・残金額再計算
Route::post('/payment/create', [CreatePaymentController::class, 'create'])->name('payment');
