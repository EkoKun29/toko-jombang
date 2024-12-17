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
        Schema::table('pembelian_teles', function (Blueprint $table) {
            $table->integer('harga')->nullable();
            $table->integer('hutang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian_teles', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->dropColumn('hutang');
        });
    }
};