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
        Schema::create('grade_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_grade_id')->constrained('academic_grades')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->unsignedBigInteger('main_teacher_id')->nullable();
            $table->foreign('main_teacher_id')->references('id')->on('teachers')->onDelete('set null');
            $table->unique(['academic_grade_id', 'section_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_sections');
    }
};
