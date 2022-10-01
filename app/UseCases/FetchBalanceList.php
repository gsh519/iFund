<?php

namespace App\UseCases;

use App\Models\Balance;
use Illuminate\Support\Collection;

class FetchBalanceList
{
    public function __invoke(): Collection
    {
        $balances = Balance::with('payments')->get();
        return $balances;
    }
}
