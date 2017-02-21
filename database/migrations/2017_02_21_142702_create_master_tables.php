<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('bank_id');
            $table->string('bank_name', 50);
            $table->tinyInteger('bank_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('banquet_events', function (Blueprint $table) {
            $table->increments('event_id');
            $table->string('event_name', 255);
            $table->tinyInteger('event_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('banquets', function (Blueprint $table) {
            $table->increments('banquet_id');
            $table->string('banquet_name', 100);
            $table->string('banquet_start', 50);
            $table->string('banquet_end', 50);
            $table->tinyInteger('banquet_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('cash_accounts', function (Blueprint $table) {
            $table->increments('cash_account_id');
            $table->string('cash_account_name', 100);
            $table->text('cash_account_desc');
            $table->integer('cash_account_amount');
            $table->tinyInteger('cash_account_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('cc_types', function (Blueprint $table) {
            $table->increments('cc_type_id');
            $table->string('cc_type_name', 50);
            $table->tinyInteger('cc_type_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('costs', function (Blueprint $table) {
            $table->increments('cost_id');
            $table->string('cost_name', 50);
            $table->tinyInteger('cost_type')->default('1')->comment('1:fix cost, 2:variable cost');
            $table->date('cost_date');
            $table->tinyInteger('cost_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->increments('country_id');
            $table->string('country_name', 75);
            $table->tinyInteger('country_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('department_id');
            $table->string('department_name', 50);
            $table->tinyInteger('department_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('employee_shifts', function (Blueprint $table) {
            $table->increments('employee_shift_id');
            $table->string('employee_shift_name', 50);
            $table->tinyInteger('employee_shift_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('employee_status', function (Blueprint $table) {
            $table->increments('employee_status_id');
            $table->string('employee_status_name', 25);
            $table->tinyInteger('employee_status_active')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('employee_types', function (Blueprint $table) {
            $table->increments('employee_type_id');
            $table->string('employee_type_name', 50);
            $table->tinyInteger('employee_type_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('extracharge_groups', function (Blueprint $table) {
            $table->increments('extracharge_group_id');
            $table->string('extracharge_group_name', 50);
            $table->tinyInteger('extracharge_group_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('extracharges', function (Blueprint $table) {
            $table->increments('extracharge_id');
            $table->integer('extracharge_group_id');
            $table->string('extracharge_name', 100);
            $table->tinyInteger('extracharge_type')->default('1')->comment('1:one time, 2:reoccuring');
            $table->tinyInteger('extracharge_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('income_id');
            $table->string('income_name', 50);
            $table->date('income_date');
            $table->tinyInteger('income_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('partner_groups', function (Blueprint $table) {
            $table->increments('partner_group_id');
            $table->string('partner_group_name', 255);
            $table->tinyInteger('partner_group_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->increments('partner_id');
            $table->integer('partner_group_id');
            $table->string('partner_name', 100);
            $table->integer('discount_weekend');
            $table->integer('discount_weekday');
            $table->integer('discount_special');
            $table->tinyInteger('partner_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('property_attributes', function (Blueprint $table) {
            $table->increments('property_attribute_id');
            $table->string('property_attribute_name', 100);
            $table->tinyInteger('property_attribute_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('property_floors', function (Blueprint $table) {
            $table->increments('property_floor_id');
            $table->string('property_floor_name', 100);
            $table->tinyInteger('property_floor_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('province_id');
            $table->integer('country_id');
            $table->string('province_name', 100);
            $table->tinyInteger('province_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('room_attributes', function (Blueprint $table) {
            $table->increments('room_attribute_id');
            $table->string('room_attribute_name', 75);
            $table->tinyInteger('room_attribute_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('room_numbers', function (Blueprint $table) {
            $table->increments('room_number_id');
            $table->string('room_number_code')->unique();
            $table->integer('room_type_id');
            $table->integer('room_floor_id');
            $table->tinyInteger('room_number_status')->default('1')->comment('1:vacant, 2:occupied, 3: guarenteed booking, 4:tentative booking, 5 : dirty, 6 : out of order');
            $table->timestamps();
        });

        Schema::create('room_plans', function (Blueprint $table) {
            $table->increments('room_plan_id');
            $table->string('room_plan_name', 100);
            $table->integer('room_plan_additional_cost');
            $table->tinyInteger('room_plan_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('room_rates', function (Blueprint $table) {
            $table->increments('room_rate_id');
            $table->integer('room_rate_day_type_id');
            $table->integer('room_rate_type_id');
            $table->integer('room_price');
            $table->timestamps();
        });

        Schema::create('room_rate_day_types', function (Blueprint $table) {
            $table->increments('room_rate_day_type_id');
            $table->string('room_rate_day_type_name', 50);
            $table->string('room_rate_day_type_list', 100)->comment('list of days in integer');
            $table->timestamps();
        });

        Schema::create('room_types', function (Blueprint $table) {
            $table->increments('room_type_id');
            $table->string('room_type_name', 100);
            $table->text('room_type_attributes');
            $table->integer('room_type_max_adult');
            $table->integer('room_type_max_child');
            $table->tinyInteger('room_type_banquet')->comment('0:no, 1:yes');
            $table->tinyInteger('room_type_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('settlements', function (Blueprint $table) {
            $table->increments('settlement_id');
            $table->integer('settlement_bank_id');
            $table->string('settlement_name', 75);
            $table->tinyInteger('settlement_status')->default('1')->comment('0:not active, 1:active');
            $table->timestamps();
        });

        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('tax_id');
            $table->string('tax_name', 100);
            $table->integer('tax_percentage');
            $table->tinyInteger('tax_type')->default('1')->comment('1:charged to customer, 2:paid by hotel');
            $table->tinyInteger('tax_status')->default('1')->comment('0:not active, 1:active');
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
        Schema::dropIfExists('banks');
        Schema::dropIfExists('banquet_events');
        Schema::dropIfExists('banquets');
        Schema::dropIfExists('cash_accounts');
        Schema::dropIfExists('cc_types');
        Schema::dropIfExists('costs');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('employee_shifts');
        Schema::dropIfExists('employee_status');
        Schema::dropIfExists('employee_types');
        Schema::dropIfExists('extracharge_groups');
        Schema::dropIfExists('extracharges');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('partner_groups');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('property_attributes');
        Schema::dropIfExists('property_floors');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('room_attributes');
        Schema::dropIfExists('room_numbers');
        Schema::dropIfExists('room_plans');
        Schema::dropIfExists('room_rates');
        Schema::dropIfExists('room_rate_day_types');
        Schema::dropIfExists('room_types');
        Schema::dropIfExists('settlements');
        Schema::dropIfExists('taxes');
    }
}
