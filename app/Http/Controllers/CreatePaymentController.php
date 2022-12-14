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
        $date = Carbon::parse($request->payment_date);
        // paymentを追加
        // balanceに再計算して更新
        $current_balance = Balance::query()
            ->where('balance_year', $date->year)
            ->where('balance_month', $date->month)
            ->first();

        DB::beginTransaction();

        $payment = new Payment();
        $payment->balance_id = $current_balance->balance_id;
        $payment->payment_date = $request->payment_date;
        $payment->memo = $request->memo;
        $payment->value = $request->value;
        $payment->save();

        // 再計算して更新
        $current_balance->date = Carbon::now();
        $current_balance->current_value = $current_balance->current_value - $request->value;
        $current_balance->save();

        DB::commit();

        return $current_balance->load('payments');
    }
}
