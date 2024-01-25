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
        Schema::create('metode_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_metode');
            $table->string('no_rekening')->nullable();
            $table->string('nama_pemilik_rekening')->nullable();
            $table->enum('type',['transfer','cash','virtual_account'])->nullable();
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
        Schema::dropIfExists('metode_pembayarans');
    }
};
