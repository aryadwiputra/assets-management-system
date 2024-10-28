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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('description');
            $table->boolean('set_prefix_asset');
            $table->string('prefix_asset')->nullable();
            $table->boolean('set_prefix_document_asset');
            $table->string('prefix_document_asset')->nullable();
            $table->boolean('set_prefix_mutation_asset');
            $table->string('prefix_mutation_asset')->nullable();
            $table->boolean('set_prefix_disposal_asset');
            $table->string('prefix_disposal_asset')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};