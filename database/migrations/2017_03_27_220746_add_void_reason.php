<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVoidReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_header', function (Blueprint $table) {
            $table->text('void_reason')->after('payment_status')->nullable();
            $table->integer('payment_status')->after('booking_status')->comment('1.belum bayar, 2:sudah dp, 3:Lunas, 4:refunded')->change();
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->integer('guest_id')->after('booking_id');
            $table->integer('status')->after('notes')->comment('1:vacant, 2:occupied, 3:guaranteed booking, 4:tentative booking, 5:Dirty, 6:Out of order, 7:no Show booked, 8:void booked')->change();
        });

        Schema::table('booking_payment', function (Blueprint $table) {
            $table->integer('guest_id')->after('booking_id');
            $table->tinyInteger('flow_type')->after('total_payment')->default(1)->comment('1:credit, 2:debit');
            $table->integer('type')->after('payment_method')->comment('1:down payment, 2:cicilan, 3:Extracharge, 4:pelunasan, 5:refund')->change();
        });

        Schema::table('booking_extracharge', function (Blueprint $table) {
            $table->integer('guest_id')->after('booking_id');
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
            $table->dropColumn('void_reason');
        });

        Schema::table('booking_room', function (Blueprint $table) {
            $table->dropColumn('guest_id');
        });

        Schema::table('booking_payment', function (Blueprint $table) {
            $table->dropColumn('guest_id');
            $table->dropColumn('flow_type');
        });

        Schema::table('booking_extracharge', function (Blueprint $table) {
            $table->dropColumn('guest_id');
        });
    }
}
