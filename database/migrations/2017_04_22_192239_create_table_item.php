<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_category_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('desc')->nullable();
            $table->tinyInteger('type')->comment('1:non beverages, 2:beverages')->default(1);
            $table->integer('discount')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0:not active, 1:active');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('pos_tax', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->integer('percentage');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('pos_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->integer('fnb_type')->comment('1:room service, 2:outlet dining, 3:outlet banquet')->default(1);
            $table->integer('category_id');
            $table->integer('cost_basic')->default(0);
            $table->double('cost_before_tax')->default(0);
            $table->integer('cost_sales')->default(0);
            $table->integer('stock')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0:not active, 1:active, 2:sold out');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('pos_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->tinyInteger('type')->comment('1:resto, 2:banquet')->default(1);
            $table->text('desc')->nullable();
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
        Schema::dropIfExists('pos_category_item');
        Schema::dropIfExists('pos_tax');
        Schema::dropIfExists('pos_item');
        Schema::dropIfExists('pos_table');
    }
}
