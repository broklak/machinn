<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployerData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 25)->nullable();
            $table->string('ktp', 75)->nullable();
            $table->string('birthplace', 75)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('religion')->nullable();
            $table->tinyInteger('gender')->comment('1:male, 2:female')->default(1);
            $table->text('address')->nullable();
            $table->string('phone',25)->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('employee_status_id')->nullable();
            $table->integer('employee_type_id')->nullable();
            $table->date('join_date')->nullable();
            $table->string('npwp', 35)->nullable();
            $table->string('bank_name', 25)->nullable();
            $table->string('bank_number', 35)->nullable();
            $table->string('bank_account_name', 75)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nik');
            $table->dropColumn('ktp');
            $table->dropColumn('birthplace');
            $table->dropColumn('birthdate');
            $table->dropColumn('religion');
            $table->dropColumn('gender');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('department_id');
            $table->dropColumn('employee_status_id');
            $table->dropColumn('employee_type_id');
            $table->dropColumn('join_date');
            $table->dropColumn('npwp');
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_number');
            $table->dropColumn('bank_account_name');
        });
    }
}
