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
        Schema::create('balita_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained()->onDelete('cascade');
            $table->date('measurement_date');
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->decimal('arm_circumference', 5, 2);
            $table->decimal('head_circumference', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balita_measurements');
    }
};
