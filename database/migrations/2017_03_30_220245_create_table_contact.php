<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('contact_id');
            $table->string('contact_name');
            $table->string('contact_group_id');
            $table->string('contact_phone');
            $table->text('contact_address')->nullable();
            $table->tinyInteger('contact_status')->comment('0;not active, 1:active')->default(1);
            $table->timestamps();
        });

        Schema::create('contact_groups', function (Blueprint $table) {
            $table->increments('contact_group_id');
            $table->string('contact_group_name');
            $table->text('contact_group_desc')->nullable();
            $table->tinyInteger('contact_group_status')->comment('0;not active, 1:active')->default(1);
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
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contact_groups');
    }
}
