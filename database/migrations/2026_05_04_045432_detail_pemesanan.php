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
        Schema::create('detailPemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPemesanan')->constrained('pemesanan')->onDelete('cascade');
            $table->foreignId('idProduk')->constrained('produk');
            $table->integer('jumlahBeli');
            $table->bigInteger('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
