<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnHkStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_numbers', function (Blueprint $table) {
            $table->integer('hk_status')->after('room_number_status')->comment('1:ready, 2:dirty, 3:not ready')->default(1);
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->integer('booking_status')->after('notes')->comment('1.belum checkin, 2:sudah checkin, 3:no showing, 4:Void, 5:checkout')->change();
            $table->integer('type')->after('partner_id')->comment('1:guaranteed booking, 2:tentative booking, 3:checkin')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_numbers', function (Blueprint $table) {
            $table->dropColumn('hk_status');
        });
    }
}
