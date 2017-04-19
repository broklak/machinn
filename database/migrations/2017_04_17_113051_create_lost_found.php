<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLostFound extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('losts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('item_name', 150)->nullable();
            $table->string('item_color', 150)->nullable();
            $table->string('item_value', 150)->nullable();
            $table->string('place', 150)->nullable();
            $table->string('guest_id', 150)->nullable();
            $table->string('report_name', 150)->nullable();
            $table->text('report_address')->nullable();
            $table->text('description')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:active, 2:returned, 3:discard');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('founds', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('lost_id')->nullable();
            $table->integer('founder_employee_id')->nullable();
            $table->string('founder_name')->nullable();
            $table->string('item_name', 150)->nullable();
            $table->string('item_color', 150)->nullable();
            $table->string('item_value', 150)->nullable();
            $table->string('place', 150)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:active, 2:returned, 3:discard');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('damages_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->tinyInteger('type')->comment('1:lost, 2:damages')->default(1);
            $table->integer('room_attribute_id')->nullable();
            $table->integer('room_number_id')->nullable();
            $table->string('asset_name', 75)->nullable();
            $table->integer('guest_id')->nullable();
            $table->integer('founder_employee_id');
            $table->string('founder_name', 100)->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('losts');
        Schema::dropIfExists('founds');
        Schema::dropIfExists('damages_assets');
    }
}
