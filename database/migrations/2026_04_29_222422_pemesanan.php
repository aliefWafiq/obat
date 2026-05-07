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
        Schema::create('pemesanan', function(Blueprint $table){
            $table->id();
            $table->string('kodePemesanan')->unique();
            $table->foreignId('idUser')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Lunas']);
            $table->bigInteger('totalHarga');
            $table->string('paymentLink')->nullable();
            $table->dateTime('estimasipembayaran');
            $table->dateTime('estimasiPengantaran');
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
