<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProdukSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_produk_supply', function (Blueprint $table) {
            $table->bigIncrements('DetailSupID');
            $table->unsignedBigInteger('SupplyID')->nullable();
            $table->unsignedBigInteger('ProdukID');
            $table->unsignedBigInteger('PemasokID')->nullable(); 
            $table->decimal('HargaBeli', 10, 2); // Menyimpan harga per unit
            $table->decimal('total_harga', 10, 2)->storedAs('JumlahMasuk * HargaBeli'); // Kolom yang dihitung secara otomatis
            $table->integer('JumlahMasuk');
            $table->date('tanggal_kadaluarsa')->nullable(); // Kolom tanggal kadaluarsa
            $table->date('tanggal_cek')->nullable();
            $table->timestamps();

            $table->foreign('SupplyID')->references('SupplyID')->on('produk_supply')->onDelete('cascade');
            $table->foreign('ProdukID')->references('ProdukID')->on('Produk')->onDelete('cascade');
            $table->foreign('PemasokID')->references('PemasokID')->on('pemasoks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_produk_supply');
    }
}
