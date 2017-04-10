<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 75)->nullable();
            $table->string('fax', 75)->nullable();
            $table->string('email', 75)->nullable();
            $table->string('logo', 255)->nullable();
            $table->timestamps();
        });

        Schema::table('logbooks', function (Blueprint $table) {
            $table->tinyInteger('done')->after('logbook_status')->default(0);
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->tinyInteger('banquet_time_id')->after('checkout_date')->nullable();
            $table->tinyInteger('banquet_event_id')->after('checkout_date')->nullable();
            $table->string('banquet_event_name', 255)->after('checkout_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_profile');

        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropColumn('done');
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->dropColumn('banquet_time_id');
            $table->dropColumn('banquet_event_id');
            $table->dropColumn('banquet_event_name');
        });
    }
}
