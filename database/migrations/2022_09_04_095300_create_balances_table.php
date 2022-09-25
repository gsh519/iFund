<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id('balance_id')->comment('残金額ID');
            $table->integer('balance_year')->comment('残金額年');
            $table->integer('balance_month')->comment('残金額月');
            $table->dateTime('date')->comment('残金額更新日');
            $table->integer('initial_value')->comment('初期金額');
            $table->integer('current_value')->comment('現在金額');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
