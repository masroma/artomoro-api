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
        Schema::create('stok_produk', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('stok');
            $table->integer('harga_modal')->nullable();
            $table->integer('harga_reseller')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_exp')->nullable();
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
        //
    }
};
