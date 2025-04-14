<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('DetailID');
            $table->unsignedBigInteger('PenjualanID')->nullable();
            $table->unsignedBigInteger('ProdukID')->nullable();
            $table->decimal('Harga', 10, 2);
            $table->integer('JumlahProduk');
            $table->decimal('SubTotal', 10, 2)->storedAs('Harga * JumlahProduk');
            $table->timestamps();

            $table->foreign('PenjualanID')->references('PenjualanID')->on('penjualans')->ondelete('cascade');
            $table->foreign('ProdukID')->references('ProdukID')->on('produk')->ondelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penjualan');
    }
}
