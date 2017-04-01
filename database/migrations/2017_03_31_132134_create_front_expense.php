<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->string('desc')->nullable();
            $table->integer('cost_id');
            $table->integer('department_id');
            $table->integer('cash_account_id');
            $table->date('date');
            $table->tinyInteger('status')->comment('1:approved, 2:unapproved, 3:deleted');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('outlet_transaction_header', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->string('bill_number');
            $table->integer('total_billed');
            $table->integer('total_discount');
            $table->integer('grand_total');
            $table->string('desc')->nullable();
            $table->integer('guest_id')->default(0);
            $table->date('date');
            $table->tinyInteger('status')->comment('1:draft, 2:billed, 3:paid, 4:deleted');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('outlet_transaction_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('extracharge_id');
            $table->integer('guest_id')->default(0);
            $table->integer('price');
            $table->integer('qty');
            $table->integer('discount');
            $table->integer('subtotal');
            $table->tinyInteger('status')->comment('1:draft, 2:billed, 3:paid, 4:deleted');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('extracharges', function (Blueprint $table) {
            $table->integer('extracharge_price')->after('extracharge_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_expenses');
        Schema::dropIfExists('outlet_transaction_header');
        Schema::dropIfExists('outlet_transaction_detail');

        Schema::table('extracharges', function (Blueprint $table) {
            $table->dropColumn('extracharge_price');
        });
    }
}
