<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id();

            $table->string('nama_project', 100)->nullable();
            $table->string('gambar')->nullable();
            $table->string('tipe_bangunan', 100)->nullable();
            $table->string('model_bangunan', 100)->nullable();
            $table->string('luas', 100)->nullable();
            $table->integer('harga')->nullable();

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
        Schema::dropIfExists('portfolio');
    }
}
