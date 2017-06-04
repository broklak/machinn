<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_deposit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id');
            $table->integer('amount');
            $table->tinyInteger('status')->default(0)->comment('0:not refunded, 1:refunded');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('booking_payment', function (Blueprint $table) {
            $table->tinyInteger('deposit')->default(0)->comment('0:no, 1:yes')->after('bank_transfer_recipient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_deposit');

        Schema::table('booking_payment', function (Blueprint $table) {
            $table->dropColumn('deposit');
        });
    }
}
