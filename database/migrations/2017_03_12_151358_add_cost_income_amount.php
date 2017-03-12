<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCostIncomeAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->integer('cost_amount')->after('cost_date')->default(0);
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->integer('income_amount')->after('income_date')->default(0);
        });

        Schema::table('extracharge_groups', function (Blueprint $table) {
            $table->integer('outlet_posting')->after('extracharge_group_name')->default(1)->comment('0:no, 1:yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropColumn('cost_amount');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('income_amount');
        });

        Schema::table('extracharge_groups', function (Blueprint $table) {
            $table->dropColumn('outlet_posting');
        });
    }
}
