<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableCashTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_transaction', function (Blueprint $table) {
            $table->integer('booking_id')->nullable();
            $table->integer('expense_id')->nullable();
            $table->integer('pos_id')->nullable();
            $table->integer('income_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_transaction', function (Blueprint $table) {
            $table->dropColumn('booking_id');
            $table->dropColumn('expense_id');
            $table->dropColumn('pos_id');
            $table->dropColumn('income_id');
        });
    }
}
