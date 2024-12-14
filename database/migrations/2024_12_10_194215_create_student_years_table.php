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
        Schema::create('student_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('classroom')->nullable();
            $table->string('order_no')->comment('Número de orden del estudiante en la sección');
            $table->unique(['section_id', 'order_no'], 'unique_section_order');
            $table->string('notes')->nullable();
            $table->decimal('registration_discount', 8, 2)->nullable(); // Descuento para inscripción
            $table->enum('registration_discount_type', ['percentage', 'fixed'])->default('percentage'); // Tipo de descuento (porcentaje o monto fijo)
            $table->decimal('monthly_discount', 8, 2)->nullable(); // Descuento para mensualidad
            $table->enum('monthly_discount_type', ['percentage', 'fixed'])->default('percentage'); // Tipo de descuento (porcentaje o monto fijo)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_years');
    }
};
