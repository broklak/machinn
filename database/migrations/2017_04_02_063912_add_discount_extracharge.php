<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountExtracharge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_extracharge', function (Blueprint $table) {
            $table->integer('price')->after('extracharge_id');
            $table->integer('discount')->after('qty');
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->integer('subtotal')->after('room_plan_rate');
            $table->integer('discount')->after('room_plan_rate')->default(0);
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
            $table->dropColumn('price');
            $table->dropColumn('discount');
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->dropColumn('subtotal');
            $table->dropColumn('discount');
        });
    }
}
