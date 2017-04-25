<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePosPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outlet_transaction_payment', function (Blueprint $table) {
            $table->integer('cc_type_id')->nullable()->after('card_number');
            $table->string('cc_holder', 75)->nullable()->after('card_number');
            $table->string('card_number', 50)->nullable()->change();
            $table->integer('settlement_id')->nullable()->after('card_number');
            $table->integer('card_type')->nullable()->after('card_number')->comment('1:credit card, 2:debit card');
        });

        Schema::table('outlet_transaction_header', function (Blueprint $table) {
            $table->integer('total_tax')->after('total_discount')->default(0);
            $table->integer('total_service')->after('total_discount')->default(0);
            $table->integer('booking_id')->after('bill_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outlet_transaction_payment', function (Blueprint $table) {
            $table->dropColumn('cc_type_id');
            $table->dropColumn('settlement_id');
            $table->dropColumn('card_type');
            $table->dropColumn('cc_holder');
        });

        Schema::table('outlet_transaction_header', function (Blueprint $table) {
            $table->dropColumn('total_tax');
            $table->dropColumn('total_service');
            $table->dropColumn('booking_id');
        });
    }
}
