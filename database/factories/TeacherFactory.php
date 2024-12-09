<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'id_number' => $this->faker->unique()->numerify('#########'),
            'dob' => $this->faker->date('Y-m-d', '-25 years'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'specialization' => $this->faker->optional()->word(),
            'academic_degree' => $this->faker->optional()->word(),
            'hire_date' => $this->faker->date('Y-m-d', '-5 years'),
            'status' => $this->faker->boolean(),
            'contract_type' => $this->faker->randomElement(['Private', 'MINERD']),
            'salary' => $this->faker->optional()->numberBetween(20000, 80000),
        ];
    }
}
