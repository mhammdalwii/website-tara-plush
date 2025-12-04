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
        Schema::create('balitas', function (Blueprint $table) {
            $table->id();
            // Setiap data balita dimiliki oleh seorang user (ibu)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->date('date_of_birth');
            $table->text('address');
            $table->decimal('height', 5, 2); // Tinggi Badan (TB), misal: 85.50 cm
            $table->decimal('weight', 5, 2); // Berat Badan (BB), misal: 10.25 kg
            $table->decimal('arm_circumference', 5, 2); // Lingkar Lengan Atas (LiLa)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balitas');
    }
};
