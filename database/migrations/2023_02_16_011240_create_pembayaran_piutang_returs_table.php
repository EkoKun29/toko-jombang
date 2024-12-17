<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_piutang_returs', function (Blueprint $table) {
            $table->id();
            $table->string('toko');
            $table->string('nama_konsumen');
            $table->integer('no_nota_piutang');
            $table->string('tgl_nota_piutang');
            $table->integer('sisa_piutang');
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
        Schema::dropIfExists('pembayaran_piutang_returs');
    }
};
