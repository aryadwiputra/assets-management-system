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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');$table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id')->references('id')->on('person_in_charges')->onDelete('cascade');
            $table->unsignedBigInteger('unit_of_measurement_id');
            $table->foreign('unit_of_measurement_id')->references('id')->on('unit_of_measurements')->onDelete('cascade');
            $table->unsignedBigInteger('warranty_id')->nullable();
            $table->foreign('warranty_id')->references('id')->on('warranties')->onDelete('cascade');
            $table->string('erp_number')->nullable();
            $table->string('number')->nullable();
            $table->string('name');
            $table->string('serial_number')->nullable();
            $table->string('slug')->unique();
            $table->integer('price');
            $table->date('purchase_date');
            $table->string('origin_of_purchase')->nullable();
            $table->string('purchase_number')->nullable();
            $table->text('description')->nullable();
            $table->text('status_information')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->boolean('is_sale')->default(0);
            $table->boolean('is_disposal')->default(0);
            $table->boolean('is_borrow')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};