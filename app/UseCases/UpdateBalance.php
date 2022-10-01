<?php

namespace App\UseCases;

use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateBalance
{
    private $insert_value;
    public function __invoke(Request $request)
    {
        $this->insert_value = (int)$request->balance_value;

        // すでにBalanceがある場合それを返す
        $balance = $this->retrieveBalance($request);

        if ($balance) {
            $balance->initial_value = $this->insert_value;
            foreach ($balance->payments as $payment) {
                $this->insert_value -= $payment->value;
            }
            $balance->current_value = $this->insert_value;
            $balance->save();
            return $balance;
        } else {
            // なければ新規作成
            return $this->createBalance($request);
        }
    }

    /**
     * 条件に一致するBalanceを返す
     *
     * @param Request $request
     * @return Balance|null
     */
    private function retrieveBalance(Request $request): ?Balance
    {
        return Balance::query()
            ->with('payments')
            ->where('balance_year', $request->balance_year)
            ->where('balance_month', $request->balance_month)
            ->first();
    }

    /**
     * Balanceを新規作成
     *
     * @param Request $request
     * @return Balance
     */
    private function createBalance(Request $request): Balance
    {
        $balance = new Balance();
        $balance->balance_year = $request->balance_year;
        $balance->balance_month = $request->balance_month;
        $balance->date = Carbon::now();
        $balance->initial_value = $this->insert_value;
        $balance->current_value = $this->insert_value;
        $balance->save();

        return $balance;
    }
}
