<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mandor_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('portfolio_id')->constrained('portfolio')->onDelete('cascade')->onUpdate('cascade');

            $table->string('gambar')->nullable();
            $table->string('jenis_pekerjaan')->nullable();


            $table->text('keterangan')->nullable();


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
        Schema::dropIfExists('progress');
    }
}
