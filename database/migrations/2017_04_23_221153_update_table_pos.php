<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outlet_transaction_header', function (Blueprint $table) {
            $table->string('waiters', 100)->after('bill_number')->nullable();
            $table->integer('guest_num')->after('bill_number')->default(2);
            $table->integer('table_id')->after('bill_number')->nullable();
            $table->integer('room_id')->after('bill_number')->nullable();
            $table->integer('bill_type')->after('bill_number')->default(1)->comment('1:direct payment, 2:billed to room');
            $table->integer('delivery_type')->after('bill_number')->default(1)->comment('1:dine in, 2:room service');
            $table->tinyInteger('source')->after('bill_number')->default(1)->comment('1:front, 2:resto');
        });

        Schema::table('outlet_transaction_detail', function (Blueprint $table) {
            $table->integer('delivery_status')->default(1)->comment('0:not delivered, 1:delivered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outlet_transaction_header', function (Blueprint $table) {
            $table->dropColumn('waiters');
            $table->dropColumn('guest_num');
            $table->dropColumn('table_id');
            $table->dropColumn('room_id');
            $table->dropColumn('bill_type');
            $table->dropColumn('delivery_type');
            $table->dropColumn('source');
        });

        Schema::table('outlet_transaction_detail', function (Blueprint $table) {
            $table->dropColumn('delivery_status');
        });
    }
}
