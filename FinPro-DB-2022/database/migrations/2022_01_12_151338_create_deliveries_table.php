<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksiID');
            $table->string('status');
            $table->string('alamatPembeli');
            $table->unsignedBigInteger('pembeliID');
            $table->unsignedBigInteger('deliveryStaffID');
            $table->timestamps();
        });

        Schema::table('deliveries', function (Blueprint $table){
            $table->foreign('transaksiID')->references('id')->on('transactions')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembeliID')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('deliveryStaffID')->references('id')->on('staff')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
