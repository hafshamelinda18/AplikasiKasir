<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('PembayaranID');
            $table->unsignedBigInteger('PenjualanID');
            $table->unsignedBigInteger('MetodeID');
            $table->date('TanggalPembayaran');
            $table->decimal('JumlahBayar', 10, 2);
            $table->decimal('Kembalian', 10, 2);
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
        Schema::dropIfExists('pembayaran');
    }
}
