<?php

namespace App\UseCases;

use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FetchBalanceList
{
    public function __invoke(Request $request): Collection
    {
        $balances = Balance::query()
            ->with('payments')
            ->where('balance_year', $request->balance_year ?? Carbon::today()->year)
            ->get();
        return $balances;
    }
}
