<?php

namespace App\Http\Controllers;

use App\UseCases\FetchBalance;

class FetchBalanceController extends Controller
{
    public function get(FetchBalance $FetchBalance)
    {
        $balance = $FetchBalance();
        return $balance;
    }
}
