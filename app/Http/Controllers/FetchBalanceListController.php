<?php

namespace App\Http\Controllers;

use App\UseCases\FetchBalanceList;
use Carbon\Carbon;

class FetchBalanceListController extends Controller
{
    public function init(FetchBalanceList $fetchBalanceList)
    {
        $balances = $fetchBalanceList();

        // 今年の年を返す
        $today = Carbon::today();
        $balance_year = $today->year;
        $balance_month = $today->month;

        return view('balancelist', [
            'balances' => $balances,
            'balance_year' => $balance_year,
            'balance_month' => $balance_month,
        ]);
    }
}
