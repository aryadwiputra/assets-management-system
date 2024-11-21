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
        Schema::create('disposal_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disposal_id');
            $table->foreign('disposal_id')->references('id')->on('disposals')->onDelete('cascade')->onUpdate('cascade');
            $table->string('file_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposal_files');
    }
};
