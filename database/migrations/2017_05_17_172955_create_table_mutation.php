<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMutation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_mutation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from');
            $table->integer('to');
            $table->date('date');
            $table->integer('amount');
            $table->text('desc')->nullable();
            $table->tinyInteger('status')->comment('0:unapproved, 1:approved')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });

        Schema::create('back_income', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->comment('1:modal, 2:piutang, 3:penerimaan lainnnya');
            $table->date('date');
            $table->integer('amount');
            $table->integer('income_id');
            $table->text('desc')->nullable();
            $table->integer('cash_account_recipient');
            $table->tinyInteger('status')->comment('0:unapproved, 1:approved')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_mutation');
        Schema::dropIfExists('back_income');
    }
}
