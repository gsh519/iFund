<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 残金額マスタ
 *
 * @property int $balance_id 残金額ID
 * @property int $balance_year 残金額年
 * @property int $balance_month 残金額月
 * @property Carbon $date 残金額更新日
 * @property int $initial_value 初期金額
 * @property int $current_value 現在金額
 * @property Carbon $created_at 作成日時
 * @property Carbon $updated_at 更新日時
 *
 * @property-read Payment $payments
 */
class Balance extends Model
{
    protected $table = 'balances';
    protected $primaryKey = 'balance_id';

    /*
    |-------------------
    | RELATION
    |-------------------
    |
    */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'balance_id', 'balance_id')
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc');
    }


    /*
    |-------------------
    | ACCESSOR
    |-------------------
    |
    */

    // number_format_current_value
    public function getNumberFormatCurrentValueAttribute(): ?string
    {
        return number_format($this->current_value);
    }

    /*
    |-------------------
    | SCOPE
    |-------------------
    |
    */
}
