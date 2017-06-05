<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableDeposit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_deposit', function (Blueprint $table) {
            $table->text('desc')->nullable()->after('amount');
            $table->integer('refund_amount')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_deposit', function (Blueprint $table) {
           $table->dropColumn('desc');
           $table->dropColumn('refund_amount');
        });
    }
}
