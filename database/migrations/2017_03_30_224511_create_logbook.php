<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->increments('logbook_id');
            $table->text('logbook_message');
            $table->integer('to_dept_id')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('logbook_status')->comment('0;not active, 1:active')->default(1);
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
        Schema::dropIfExists('logbooks');
    }
}
