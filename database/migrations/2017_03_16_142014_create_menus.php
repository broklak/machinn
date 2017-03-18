<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('module_id');
            $table->string('module_name', 75);
            $table->timestamps();
        });

        Schema::create('submodules', function (Blueprint $table) {
            $table->increments('submodule_id');
            $table->string('submodule_name', 75);
            $table->integer('module_id');
            $table->timestamps();
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->increments('class_id');
            $table->string('class_name', 75);
            $table->integer('submodule_id');
            $table->timestamps();
        });

        Schema::create('methods', function (Blueprint $table) {
            $table->increments('method_id');
            $table->string('method_name', 75);
            $table->integer('class_id');
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
        Schema::dropIfExists('modules');
        Schema::dropIfExists('submodules');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('methods');
    }
}
