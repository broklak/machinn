<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number', 75);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->integer('amount');
            $table->text('desc')->nullable();
            $table->tinyInteger('source')->comment('1:supplier, 2:business partner')->comment(1);
            $table->integer('source_id');
            $table->integer('department_id');
            $table->integer('cost_id');
            $table->tinyInteger('status')->comment('0:unapproved, 1:approved')->default(0);
            $table->tinyInteger('paid')->comment('0:no, 1:yes')->default(0);
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
        });

        Schema::create('invoice_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->date('payment_date');
            $table->integer('paid_amount');
            $table->text('desc')->nullable();
            $table->integer('cash_account_id');
            $table->tinyInteger('status')->comment('0:unapproved, 1:approved')->default(0);
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
        Schema::dropIfExists('invoice_payment');
    }
}
