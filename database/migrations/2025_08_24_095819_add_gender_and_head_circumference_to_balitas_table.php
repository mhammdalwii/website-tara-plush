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
        Schema::table('balitas', function (Blueprint $table) {
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->after('date_of_birth');
            $table->decimal('head_circumference', 5, 2)->after('arm_circumference'); // Lingkar Kepala (LK)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            //
        });
    }
};
