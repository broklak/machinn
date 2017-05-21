<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAccReceivable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_receivable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->nullable();
            $table->date('date');
            $table->integer('amount');
            $table->text('desc')->nullable();
            $table->integer('partner_id')->nullable();
            $table->tinyInteger('paid')->comment('0:unpaid, 1:paid')->default(0);
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });

        Schema::create('cash_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cash_account_id');
            $table->integer('amount');
            $table->text('desc')->nullable();
            $table->tinyInteger('type')->comment('1:debit, 2:credit');
            $table->timestamps();
        });

        Schema::table('back_income', function (Blueprint $table) {
            $table->integer('account_receivable_id')->nullable();
        });

        Schema::table('partner_groups', function (Blueprint $table) {
            $table->tinyInteger('booking_paid_first')->comment('0:no, 1:yes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_receivable');
        Schema::dropIfExists('cash_transaction');

        Schema::table('back_income', function (Blueprint $table) {
            $table->dropColumn('account_receivable_id');
        });

        Schema::table('partner_groups', function (Blueprint $table) {
            $table->dropColumn('booking_paid_first');
        });
    }
}
