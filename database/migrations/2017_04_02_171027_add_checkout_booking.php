<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckoutBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_extracharge', function (Blueprint $table) {
            $table->tinyInteger('checkout')->after('status')->default(0);
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->tinyInteger('checkout')->after('payment_status')->default(0);
        });

        Schema::table('booking_payment', function (Blueprint $table) {
            $table->tinyInteger('checkout')->after('type')->default(0);
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->tinyInteger('checkout')->after('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_extracharge', function (Blueprint $table) {
            $table->dropColumn('checkout');
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->dropColumn('checkout');
        });

        Schema::table('booking_payment', function (Blueprint $table) {
            $table->dropColumn('checkout');
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->dropColumn('checkout');
        });
    }
}
