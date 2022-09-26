<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdatePaymentController extends Controller
{
    public function update(Payment $payment, Request $request)
    {
        /** @var Balance $current_balance */
        $current_balance = $payment->balance;

        DB::beginTransaction();

        $current_balance->current_value += $payment->value;
        $current_balance->save();

        $payment->balance_id = $current_balance->balance_id;
        $payment->memo = $request->memo;
        $payment->value = $request->value;
        $payment->payment_date = $request->payment_date;
        $payment->save();

        // 再計算して更新
        $current_balance->date = Carbon::now();
        $current_balance->current_value -= $request->value;
        $current_balance->save();

        DB::commit();

        return $current_balance->load('payments');
    }
}
