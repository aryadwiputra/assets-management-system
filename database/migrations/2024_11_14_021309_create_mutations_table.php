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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('from_location');
            $table->foreign('from_location')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('to_location');
            $table->foreign('to_location')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('from_pic');
            $table->foreign('from_pic')->references('id')->on('person_in_charges')->onDelete('cascade');
            $table->unsignedBigInteger('to_pic');
            $table->foreign('to_pic')->references('id')->on('person_in_charges')->onDelete('cascade');
            $table->unsignedBigInteger('from_employee');
            $table->foreign('from_employee')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('to_employee');
            $table->foreign('to_employee')->references('id')->on('employees')->onDelete('cascade');
            $table->string('status');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};