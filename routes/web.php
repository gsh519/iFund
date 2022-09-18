<?php

use App\Http\Controllers\CreatePaymentController;
use App\Http\Controllers\DeletePaymentController;
use App\Http\Controllers\FetchBalanceController;
use App\Http\Controllers\FetchBalanceViewController;
use App\Http\Controllers\UpdatePaymentController;
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
Route::get('/', [FetchBalanceViewController::class, 'init'])->name('home');
Route::get('/balance', [FetchBalanceController::class, 'get'])->name('balance');

// 支出新規作成・残金額再計算
Route::post('/payment/create', [CreatePaymentController::class, 'create'])->name('payment.create');

// 支出更新・残金額再計算
Route::post('/payment/{payment}/update', [UpdatePaymentController::class, 'update'])->name('payment.update');

// 支出削除処理・残金額再計算
Route::post('/payment/delete', [DeletePaymentController::class, 'delete'])->name('payment.delete');
