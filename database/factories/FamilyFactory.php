<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\Progenitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Family>
 */
class FamilyFactory extends Factory
{
    protected $model = Family::class;

    public function definition()
    {
        // Seleccionar un father y una mother únicos
        $father = Progenitor::where('role', 'father')->inRandomOrder()->first();
        $mother = Progenitor::where('role', 'mother')->inRandomOrder()->first();

        // Garantizar que los progenitores sean distintos
        if (!$father || !$mother || $father->id === $mother->id) {
            throw new \Exception("Debe haber al menos un father y una mother distintos en la base de datos.");
        }

        // Generar last_name de la familia
        $lastNameFather = $father->first_last_name ?? 'SinApellido';
        $lastNameMother = $mother->second_last_name ?? 'SinApellido';
        $familyLastName = "{$lastNameFather} {$lastNameMother}";

        // Generar datos del tutor opcionales si está habilitado
        $tutorEnabled = $this->faker->boolean(20); // 20% de probabilidades de que haya un tutor
        $tutorData = $tutorEnabled ? [
            't_name' => $this->faker->firstName(),
            't_last_name' => $this->faker->lastName(),
            't_address' => $this->faker->address(),
            't_telephone' => $this->faker->phoneNumber(),
            'kinship' => $this->faker->randomElement(['Uncle', 'Aunt', 'Grandparent', 'Other']),
        ] : [
            't_name' => null,
            't_last_name' => null,
            't_address' => null,
            't_telephone' => null,
            'kinship' => null,
        ];

        return array_merge([
            'father_id' => $father->id,
            'mother_id' => $mother->id,
            'last_name' => $familyLastName,
            'is_separated_parents' => $this->faker->boolean(10), // 10% de probabilidades de estar separados
            'no_father_data' => false, // Por defecto, asumimos que hay datos del father
            'tutor_enabled' => $tutorEnabled,
        ], $tutorData);
    }
}
