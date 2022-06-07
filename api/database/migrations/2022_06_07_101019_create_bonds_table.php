<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->date('emisia_date')->format('Y-m-d');
            $table->date('turnover_date')->format('Y-m-d'); //Y-m-d
            $table->double('nominal_price', 8, 2);
            $table->enum('frequency_payment_coupons', ['1', '2', '4', '12']);
            $table->enum('period_for_calculating_interest', ['360', '364', '365']);
            $table->tinyInteger('coupon_interest');
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
        Schema::dropIfExists('bonds');
    }
};
