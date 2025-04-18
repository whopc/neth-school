<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = [];
        $startYear = 2010; // Año inicial
        $endYear = 2024; // Último año académico

        for ($year = $startYear; $year <= $endYear; $year++) {
            $nextYear = $year + 1;

            $academicYears[] = [
                'name' => "{$year}-{$nextYear}", // Ejemplo: "2010-2011"
                'short_name' => (string) $year, // Ejemplo: "2010"
                'start_date' => "{$year}-08-01", // Fecha de inicio (ajustable)
                'end_date' => "{$nextYear}-06-30", // Fecha de fin (ajustable)
                'status' => $year === $endYear, // Solo el último año (2024-2025) está activo
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertar en la tabla academic_years
        DB::table('academic_years')->insert($academicYears);
    }
}
