<?php

namespace Database\Factories;

use App\Models\Progenitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Progenitor>
 */
class ProgenitorFactory extends Factory
{
    protected $model = Progenitor::class;

    public function definition()
    {
        // Datos básicos comunes
        return [
            'name' => $this->faker->firstName(),
            'first_last_name' => $this->faker->lastName(),
            'second_last_name' => $this->faker->lastName(),
            'id_type' => $this->faker->randomElement(['national_id', 'passport']),
            'id_number' => $this->faker->unique()->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'home_phone' => $this->faker->optional()->phoneNumber(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'place_of_work' => $this->faker->optional()->country(),
            'work_phone' => $this->faker->optional()->phoneNumber(),
            'role' => 'father', // Valor por defecto
        ];
    }

    // Método específico para `father`
    public function father()
    {
        return $this->state([
            'name' => $this->faker->firstName('male'),
            'role' => 'father',
        ]);
    }

    // Método específico para `mother`
    public function mother()
    {
        return $this->state([
            'name' => $this->faker->firstName('female'),
            'role' => 'mother',
        ]);
    }
}
