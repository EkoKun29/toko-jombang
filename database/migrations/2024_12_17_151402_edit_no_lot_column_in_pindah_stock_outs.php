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
        Schema::table('pindah_stock_outs', function (Blueprint $table) {
            $table->string('no_lot')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pindah_stock_outs', function (Blueprint $table) {
            $table->string('no_lot')->nullable(false)->change();
        });
    }
};
