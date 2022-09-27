<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 支出トラン
 *
 * @property int $payment_id 支出ID
 * @property int $balance_id 残金額ID
 * @property Carbon $payment_date 支出日
 * @property string $memo メモ
 * @property int $value 支出金額
 * @property Carbon $created_at 作成日時
 * @property Carbon $updated_at 更新日時
 */
class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    /*
    |-------------------
    | RELATION
    |-------------------
    |
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balance()
    {
        return $this->belongsTo(Balance::class, 'balance_id', 'balance_id');
    }

    /*
    |-------------------
    | ACCESSOR
    |-------------------
    |
    */

    // number_format_value
    public function getNumberFormatValueAttribute(): ?string
    {
        return number_format($this->value);
    }

    /*
    |-------------------
    | SCOPE
    |-------------------
    |
    */
}
