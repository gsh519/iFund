<?php

namespace App\Http\Controllers;

use App\UseCases\FetchBalance;
use Illuminate\Http\Request;

class FetchBalanceController extends Controller
{
    public function get(Request $request, FetchBalance $FetchBalance)
    {
        $balance = $FetchBalance($request);
        return $balance;
    }
}
