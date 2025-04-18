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
        Schema::create('academic_years', function (Blueprint $table) {
                $table->id(); // Creates an auto-incrementing id column
                $table->string('name'); // Column for the academic year “2024-2025”
                $table->string('short_name'); //  Short name for the academic year “2024”
                $table->boolean('is_registration_active')->default(0);
                $table->date('start_date')->nullable(); // Column for start date
                $table->date('end_date')->nullable(); // Column for end date
                $table->boolean('status')->nullable();
                $table->timestamps(); // Creates created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
