<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableCashAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_accounts', function (Blueprint $table) {
            $table->date('open_date')->nullable()->after('cash_account_amount');
            $table->integer('open_balance')->default(0)->after('cash_account_amount');
        });

        Schema::table('cash_transaction', function (Blueprint $table) {
            $table->integer('mutation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_accounts', function (Blueprint $table) {
            $table->dropColumn('open_date');
            $table->dropColumn('open_balance');
        });

        Schema::table('cash_transaction', function (Blueprint $table) {
            $table->dropColumn('mutation_id');
        });
    }
}
