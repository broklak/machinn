<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_accounts', function (Blueprint $table) {
            $table->tinyInteger('type')->comment('1:bank, 2:cash')->default(1);
            $table->string('code')->nullable();
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
            $table->dropColumn('type');
            $table->dropColumn('code');
        });
    }
}
