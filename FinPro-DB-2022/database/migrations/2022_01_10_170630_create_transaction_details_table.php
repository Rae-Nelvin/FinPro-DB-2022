<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksiID');
            $table->unsignedBigInteger('barangID');
            $table->bigInteger('jumlahBarang');
            $table->bigInteger('totalHarga');
            $table->string('additionalNotes');
            $table->timestamps();
        });

        Schema::table('transaction_details', function (Blueprint $table){
            $table->foreign('transaksiID')->references('id')->on('transactions')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('barangID')->references('id')->on('menus')
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
        Schema::dropIfExists('transaction_details');
    }
}