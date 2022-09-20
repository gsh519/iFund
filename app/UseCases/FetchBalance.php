<?php

namespace App\UseCases;

use App\Models\Balance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FetchBalance
{
    public function __invoke(Request $request): JsonResponse
    {
        $balance = Balance::query()
            ->with('payments')
            ->where('balance_year', $request->year)
            ->where('balance_month', $request->month)
            ->first();

        return response()->json($balance);
    }
}
