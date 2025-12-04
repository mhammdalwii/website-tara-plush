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
        Schema::table('recipes', function (Blueprint $table) {
            // Menambahkan kolom foreign key setelah 'id'
            // onDelete('set null') berarti jika kategori dihapus, resepnya tidak ikut terhapus
            $table->foreignId('recipe_category_id')->nullable()->after('id')->constrained('recipe_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            //
        });
    }
};
