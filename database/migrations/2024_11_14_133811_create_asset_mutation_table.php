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
        Schema::create('asset_mutation', function (Blueprint $table) {
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->unsignedBigInteger('mutation_id');
            $table->foreign('mutation_id')->references('id')->on('mutations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_mutation');
    }
};
