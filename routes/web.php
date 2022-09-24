<?php

use App\Http\Controllers\CreateBalanceController;
use App\Http\Controllers\CreatePaymentController;
use App\Http\Controllers\DeletePaymentController;
use App\Http\Controllers\FetchBalanceController;
use App\Http\Controllers\FetchBalanceViewController;
use App\Http\Controllers\UpdatePaymentController;
use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', [FetchBalanceViewController::class, 'init'])->name('home');
Route::get('/balance', [FetchBalanceController::class, 'get'])->name('balance');

// 支出新規作成・残金額再計算
Route::post('/payment/create', [CreatePaymentController::class, 'create'])->name('payment.create');

// 支出更新・残金額再計算
Route::post('/payment/{payment}/update', [UpdatePaymentController::class, 'update'])->name('payment.update');

// 支出削除処理・残金額再計算
Route::post('/payment/delete', [DeletePaymentController::class, 'delete'])->name('payment.delete');

/**
 * 残金額設定ページ
 */
Route::get('/balance/create', [CreateBalanceController::class, 'init'])->name('balance.create');
Route::post('/balance/create', [CreateBalanceController::class, 'create']);
