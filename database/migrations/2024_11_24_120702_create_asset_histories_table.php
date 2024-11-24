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
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->unsignedBigInteger('from_location_id')->nullable();
            $table->foreign('from_location_id')->references('id')->on('locations')->onDelete('set null');
            $table->unsignedBigInteger('to_location_id')->nullable();
            $table->foreign('to_location_id')->references('id')->on('locations')->onDelete('set null');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('pic_id')->nullable();
            $table->foreign('pic_id')->references('id')->on('person_in_charges')->onDelete('set null');
            $table->string('transaction_type');
            $table->string('status_before');
            $table->string('status_after');
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};
