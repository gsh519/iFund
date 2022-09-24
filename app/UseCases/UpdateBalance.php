<?php

namespace App\UseCases;

use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateBalance
{
    public function __invoke(Request $request)
    {
        // すでにBalanceがある場合それを返す
        $balance = $this->retrieveBalance($request);
        if ($balance) {
            $balance->initial_value = $request->balance_value;
            $balance->current_value = $request->balance_value;
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
            ->where('balance_year', $request->year)
            ->where('balance_month', $request->month)
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
        $balance->balance_year = $request->year;
        $balance->balance_month = $request->month;
        $balance->date = Carbon::now();
        $balance->initial_value = $request->balance_value;
        $balance->current_value = $request->balance_value;
        $balance->save();

        return $balance;
    }
}
