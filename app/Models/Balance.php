<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 残金額マスタ
 *
 * @property int $balance_id 残金額ID
 * @property Carbon $date 残金額更新日
 * @property int $initial_value 初期金額
 * @property int $current_value 現在金額
 * @property Carbon $created_at 作成日時
 * @property Carbon $updated_at 更新日時
 */
class Balance extends Model
{
    protected $table = 'balances';
    protected $primaryKey = 'balance_id';
}
