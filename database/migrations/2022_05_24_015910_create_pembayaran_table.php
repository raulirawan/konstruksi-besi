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
            $table->id();

            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade')->onUpdate('cascade');

            $table->string('kode_pembayaran', 100)->nullable();

            $table->integer('harga')->nullable();

            $table->string('keterangan')->nullable();
            $table->enum('status',['PENDING','LUNAS','GAGAL'])->nullable();



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
