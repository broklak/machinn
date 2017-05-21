<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAssetProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_attributes', function (Blueprint $table) {
            $table->integer('type')->comment('1:Furniture Hotel, 2:Electronic, 3:Kitchen Equipment, 4:others')->default(1);
            $table->integer('purchase_amount')->default(0);
            $table->date('purchase_date')->nullable();
            $table->integer('qty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_attributes', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('purchase_amount');
            $table->dropColumn('purchase_date');
            $table->dropColumn('qty');
        });
    }
}
