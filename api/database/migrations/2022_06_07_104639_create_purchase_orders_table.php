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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bond_id')->unsigned();
            $table->date('order_date')->format('Y-m-d'); //Y-m-d
            $table->double('number_bonds_received', 8, 2);
            $table->timestamps();
            $table->foreign('bond_id')
                ->references('id')
                ->on('bonds')
                ->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
};
