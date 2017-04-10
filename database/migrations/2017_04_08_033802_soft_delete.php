<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('banquet_events', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('banquets', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cash_accounts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cc_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('contact_groups', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('costs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('employee_shifts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('employee_status', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('employee_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('extracharge_groups', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('extracharges', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('partner_groups', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('property_attributes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('property_floors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('provinces', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('room_attributes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('room_numbers', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('room_plans', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('taxes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('logbooks', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('front_expenses', function (Blueprint $table) {
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
        Schema::table('banks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('banquet_events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('banquets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('cash_accounts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('cc_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('contact_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('costs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('employee_shifts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('employee_status', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('employee_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('extracharge_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('extracharges', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('partner_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('property_attributes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('property_floors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('provinces', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('room_attributes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('room_numbers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('room_plans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('taxes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('front_expenses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
