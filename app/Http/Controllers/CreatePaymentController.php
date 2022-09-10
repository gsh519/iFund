<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreatePaymentController extends Controller
{
    public function create(Request $request)
    {
        // paymentを追加
        // balanceに再計算して更新
        $current_balance = Balance::query()
            ->where('balance_year', $request->year)
            ->where('balance_month', $request->month)
            ->first();

        DB::beginTransaction();

        $today = Carbon::today();
        $payment = new Payment();
        $payment->balance_id = $current_balance->balance_id;
        $payment->payment_date = $today;
        $payment->memo = $request->memo;
        $payment->value = $request->value;
        $payment->save();

        // 再計算して更新
        $current_balance->date = Carbon::now();
        $current_balance->current_value = $current_balance->current_value - $request->value;
        $current_balance->save();

        DB::commit();
    }
}
