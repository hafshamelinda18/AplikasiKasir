<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('ProdukID');
            $table->string('KodeProduk', 200)->unique;
            $table->string('NamaProduk', 100);
            $table->unsignedBigInteger('KategoriID');
            $table->unsignedBigInteger('SatuanID');
            $table->decimal('Harga', 10, 2);
            $table->integer('Stok')->default(0);
            $table->string('Keterangan', 100)->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('produk');
    }
}
