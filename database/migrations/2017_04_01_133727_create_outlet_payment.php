<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlet_transaction_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('payment_method')->comment('1:cash FO, 2:cash BO, 3:Credit Card, 4:Transfer Bank');
            $table->integer('total_payment');
            $table->integer('total_paid');
            $table->integer('total_change');
            $table->integer('card_number')->nullable();
            $table->integer('bank')->nullable();
            $table->integer('guest_id')->default(0);
            $table->integer('card_name')->nullable();
            $table->integer('card_expiry_month')->nullable();
            $table->integer('card_expiry_year')->nullable();
            $table->integer('bank_transfer_recipient')->comment('if using bank transfer then fill with cash account id')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlet_transaction_payment');
    }
}
