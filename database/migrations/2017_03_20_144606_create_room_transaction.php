<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_room', function (Blueprint $table) {
            $table->increments('booking_room_id');
            $table->integer('booking_id');
            $table->integer('room_number_id');
            $table->integer('room_rate');
            $table->date('room_transaction_date');
            $table->text('notes')->nullable();
            $table->integer('status')->comment('1:vacant, 2:occupied, 3:guaranteed booking, 4:tentative booking, 5:Dirty, 6:Out of order');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_header', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->integer('guest_id');
            $table->integer('room_plan_id');
            $table->integer('partner_id');
            $table->integer('type')->comment('1:guaranteed booking, 2:tentative booking');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->integer('adult_num')->default(2);
            $table->integer('child_num')->default(0);
            $table->tinyInteger('is_banquet')->default(0)->comment('1:yes , 0:no');
            $table->integer('booking_status')->comment('1.belum checkin, 2:sudah checkin, 3:no showing, 4:Void');
            $table->integer('payment_status')->comment('1.belum bayar, 2:sudah dp, 3:Lunas');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_payment', function (Blueprint $table) {
            $table->increments('booking_payment_id');
            $table->integer('booking_id');
            $table->integer('payment_method')->comment('1:cash FO, 2:cash BO, 3:Credit Card, 4:Transfer Bank');
            $table->integer('type')->comment('1:down payment, 2:cicilan, 3:Extracharge, 4:pelunasan');
            $table->integer('total_payment');
            $table->integer('card_number')->nullable();
            $table->integer('bank')->nullable();
            $table->integer('card_name')->nullable();
            $table->integer('card_expiry_month')->nullable();
            $table->integer('card_expiry_year')->nullable();
            $table->integer('bank_transfer_recipient')->comment('if using bank transfer then fill with cash account id')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_extracharge', function (Blueprint $table) {
            $table->increments('booking_extracharge_id');
            $table->integer('booking_id');
            $table->integer('booking_room_id');
            $table->integer('extracharge_id');
            $table->integer('qty');
            $table->integer('total_payment');
            $table->integer('status')->comment('0:Dihapus, 1:belum bayar, 2:lunas')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('guests', function (Blueprint $table) {
            $table->increments('guest_id');
            $table->integer('id_type')->comment('1:ktp, 2:sim, 3:passpor')->default(1);
            $table->string('id_number', 75);
            $table->string('first_name', 125);
            $table->tinyInteger('type')->comment('1:regular, 2:vip')->default(1);
            $table->integer('title')->comment('1:Mr. , 2:Mrs. ,3:Miss')->default(1);
            $table->string('last_name', 125)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace', 75)->nullable();
            $table->string('religion',25)->nullable();
            $table->tinyInteger('gender')->comment('1:male, 2:female')->default(1);
            $table->string('job',75)->nullable();
            $table->text('address')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->string('email',75)->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('homephone', 50)->nullable();
            $table->string('handphone', 50)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('booking_room');
        Schema::dropIfExists('booking_header');
        Schema::dropIfExists('booking_payment');
        Schema::dropIfExists('booking_extracharge');
        Schema::dropIfExists('guests');
    }
}
