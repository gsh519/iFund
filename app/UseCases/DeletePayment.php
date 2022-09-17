<?php

namespace App\UseCases;

use App\Models\Balance;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DeletePayment
{
    public function __invoke(array $payment_ids)
    {
        DB::beginTransaction();

        // 削除する支出を取得
        /** @var Collection<Payment> $delete_payments */
        $delete_payments = Payment::query()
            ->with('balance')
            ->whereIn('payment_id', $payment_ids)
            ->get();

        $delete_payments->each(function ($payment) {
            // 残金額の再計算
            /** @var Balance $balance */
            $balance = $payment->balance;
            $balance->current_value += $payment->value;
            $balance->save();

            // 削除
            $payment->delete();
        });

        DB::commit();
    }
}
