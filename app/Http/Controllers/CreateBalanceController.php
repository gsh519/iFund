<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\UseCases\UpdateBalance;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CreateBalanceController extends Controller
{
    /**
     * 残金額設定画面表示
     *
     * @return View
     */
    public function init(): View
    {
        $today = Carbon::today();
        $today_year = $today->year;
        $next_month = $today->copy()->addMonth()->month;

        // 年・月が一致するやつがすでに存在していたらそれを表示
        $balance = Balance::query()
            ->where('balance_year', $today_year)
            ->where('balance_month', $next_month)
            ->first();

        // なければ空で表示
        if (!$balance instanceof Balance) {
            $balance = new Balance();
        }

        return view('balance', [
            'today_year' => $today_year,
            'next_month' => $next_month,
            'balance' => $balance,
        ]);
    }

    public function create(Request $request, UpdateBalance $UpdateBalance)
    {
        $request->validate([
            'balance_value' => ['required', 'integer'],
        ]);
        // 残金額の更新or新規作成
        $updated_balance = $UpdateBalance($request);

        return view('balance', [
            'today_year' => $request->year,
            'next_month' => $request->month,
            'balance' => $updated_balance,
        ]);
    }
}
