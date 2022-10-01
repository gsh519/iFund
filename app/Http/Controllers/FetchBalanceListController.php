<?php

namespace App\Http\Controllers;

use App\UseCases\FetchBalanceList;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FetchBalanceListController extends Controller
{
    public function init(Request $request, FetchBalanceList $fetchBalanceList)
    {
        $balances = $fetchBalanceList($request);

        // 今年の年、月を返す
        $today = Carbon::today();
        $today_month = $today->month;
        $today_year = $today->year;
        $calendars = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        return view('balancelist', [
            'balances' => $balances,
            'balance_year' => $request->balance_year ?? Carbon::today()->year,
            'today_month' => $today_month, // 判定用
            'today_year' => $today_year, // 判定用
            'calendars' => $calendars,
        ]);
    }
}
