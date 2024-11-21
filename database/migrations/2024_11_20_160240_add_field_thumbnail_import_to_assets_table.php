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
        Schema::table('assets', function (Blueprint $table) {
            $table->string('thumbnail_extension')->nullable(); // Menyimpan ekstensi file gambar
            $table->string('thumbnail_path')->nullable(); // Menyimpan path ke file gambar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('thumbnail_extension');
            $table->dropColumn('thumbnail_path');
        });
    }
};
