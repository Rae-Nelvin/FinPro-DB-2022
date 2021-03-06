<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembeliID');
            $table->unsignedBigInteger('cashierStaffID');
            $table->unsignedBigInteger('chefStaffID');
            $table->unsignedBigInteger('deliveryStaffID')->nullable();
            $table->bigInteger('totalHarga');
            $table->string('status');
            $table->string('buktiPembayaran')->nullable();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table){
            $table->foreign('pembeliID')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cashierStaffID')->references('id')->on('staff')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('chefStaffID')->references('id')->on('staff')
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
        Schema::dropIfExists('transactions');
    }
}
