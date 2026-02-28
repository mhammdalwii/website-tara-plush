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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama kegiatan, cth: "Posyandu Melati"
            $table->text('description')->nullable(); // Deskripsi lengkap kegiatan
            $table->string('location'); // Lokasi, cth: "Balai Desa Kampung Baru"
            $table->dateTime('schedule_date'); // Tanggal dan waktu pelaksanaan
            $table->string('target_audience')->nullable(); // Sasaran, cth: "Balita & Ibu Hamil"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
