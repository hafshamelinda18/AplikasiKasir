<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_toko', function (Blueprint $table) {
            $table->bigIncrements('IdToko');
            $table->string('NamaToko', 50);
            $table->string('Pemilik', 50);
            $table->text('Alamat');
            $table->string('NoTelp', 15);
            $table->string('email')->unique();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('profil_toko');
    }
}
