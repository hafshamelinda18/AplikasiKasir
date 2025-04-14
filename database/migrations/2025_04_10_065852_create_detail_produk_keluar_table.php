<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProdukKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_produk_keluar', function (Blueprint $table) {
            $table->bigIncrements('DetailPKID');
    
            $table->unsignedBigInteger('pkID')->nullable();
            $table->unsignedBigInteger('ProdukID');
            $table->unsignedInteger('JumlahKeluar'); // Jumlah barang keluar
            $table->timestamps();

            $table->foreign('pkID')->references('pkID')->on('produk_keluar')->onDelete('cascade');
            $table->foreign('ProdukID')->references('ProdukID')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_produk_keluar');
    }
}
