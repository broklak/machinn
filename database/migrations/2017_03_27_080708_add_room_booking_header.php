<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomBookingHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_header', function (Blueprint $table) {
            $table->string('room_list', 250)->after('checkout_date');
            $table->string('booking_code', 50)->after('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_header', function (Blueprint $table) {
            $table->dropColumn('room_list');
            $table->dropColumn('booking_code');
        });
    }
}
