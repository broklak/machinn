<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBookingPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payment', function (Blueprint $table) {
            $table->integer('settlement_id')->after('bank')->nullable();
            $table->integer('card_type')->after('total_payment')->comment('only filled if payment method is card. 1:Credit Card 2:Debit Card')->nullable();
            $table->tinyInteger('cc_type_id')->after('bank')->nullable();
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->integer('grand_total')->after('payment_status');
            $table->text('notes')->after('is_banquet')->nullable();
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->integer('room_plan_rate')->after('room_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_payment', function (Blueprint $table) {
            $table->dropColumn('settlement_id');
            $table->dropColumn('card_type');
            $table->dropColumn('cc_type_id');
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->dropColumn('grand_total');
            $table->dropColumn('notes');
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->dropColumn('room_plan_rate');
        });
    }
}
