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
        Schema::create('address_customers', function (Blueprint $table) {
            $table->id();
            $table->integer('id_customer');
            $table->string('no_whatsapp');
            $table->text('alamat_lengkap');
            $table->integer('provinsi_id');
            $table->integer('kota_id');
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
        Schema::dropIfExists('address_customers');
    }
};
