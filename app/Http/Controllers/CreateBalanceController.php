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
    public function init(Request $request): View
    {
        // 年・月が一致するやつがすでに存在していたらそれを表示
        $balance = Balance::query()
            ->where('balance_year', $request->balance_year)
            ->where('balance_month', $request->balance_month)
            ->first();

        // なければ空で表示
        if (!$balance instanceof Balance) {
            $balance = new Balance();
        }

        return view('balance', [
            'balance_year' => $request->balance_year,
            'balance_month' => $request->balance_month,
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
            'balance_year' => $request->balance_year,
            'balance_month' => $request->balance_month,
            'balance' => $updated_balance,
        ]);
    }
}
