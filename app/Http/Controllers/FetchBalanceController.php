<?php

namespace App\Http\Controllers;

use App\UseCases\FetchBalance;

class FetchBalanceController extends Controller
{
    public function init(FetchBalance $FetchBalance)
    {
        $balance = $FetchBalance();
        return view('index', [
            'balance' => $balance,
        ]);
    }
}
