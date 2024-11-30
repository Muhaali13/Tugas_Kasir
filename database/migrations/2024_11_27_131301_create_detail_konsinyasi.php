<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_konsinyasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_konsinyasi');
            $table->string('kode_konsinyasi_detail');
            $table->string('produk');
            $table->integer('harga');
            $table->integer('harga_jual');
            $table->integer('qty');
            $table->date('tgl_masuk');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_konsinyasi');
    }
};
