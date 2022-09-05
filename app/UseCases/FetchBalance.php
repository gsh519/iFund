<?php

namespace App\UseCases;

use App\Models\Balance;

class FetchBalance
{
    public function __invoke()
    {
        return Balance::query()
            ->with('payments')
            ->where('balance_year', 2022)
            ->where('balance_month', 9)
            ->first();
    }
}
