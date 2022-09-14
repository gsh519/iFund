<?php

namespace App\UseCases;

use App\Models\Balance;
use Illuminate\Http\JsonResponse;

class FetchBalance
{
    public function __invoke()
    {
        $balance = Balance::query()
            ->with('payments')
            ->where('balance_year', 2022)
            ->where('balance_month', 9)
            ->first();

        return response()->json($balance);
    }
}
