<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->bigIncrements('PelangganID');
            $table->string('NamaPelanggan', 200);
            $table->text('Alamat');
            $table->string('NoTelp', 15);
            $table->string('email')->unique();

             // Menambahkan kolom untuk wilayah
             $table->unsignedBigInteger('province_id')->nullable();
             $table->unsignedBigInteger('regency_id')->nullable();
             $table->unsignedBigInteger('district_id')->nullable();
             $table->unsignedBigInteger('village_id')->nullable();
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
        Schema::dropIfExists('pelanggans');
    }
}
