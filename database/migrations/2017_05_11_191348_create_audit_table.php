<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('night_audit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->tinyInteger('type')->comment('1:room, 2:outlet')->default(1);
            $table->integer('audited_by');
            $table->timestamps();
        });

        Schema::table('booking_header', function (Blueprint $table) {
            $table->tinyInteger('audited')->comment('0:no, 1:yes')->default(0);
        });

        Schema::table('outlet_transaction_header', function (Blueprint $table) {
            $table->tinyInteger('audited')->comment('0:no, 1:yes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('night_audit');

        Schema::table('booking_header', function (Blueprint $table) {
            $table->dropColumn('audited');
        });

        Schema::table('outlet_transaction_header', function (Blueprint $table) {
            $table->dropColumn('audited');
        });
    }
}
