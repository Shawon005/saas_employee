<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WorkerFactory extends Factory
{
    public function definition(): array
    {
        $basic = fake()->randomFloat(2, 8500, 18000);

        return [
            'emp_id' => 'EMP-' . fake()->unique()->numberBetween(10000, 99999),
            'name' => fake()->name(),
            'grade' => fake()->randomElement(['Grade-1', 'Grade-2', 'Grade-3']),
            'basic_salary' => $basic,
            'house_rent' => round($basic * 0.5, 2),
            'medical_allowance' => 1500,
            'attendance_bonus_eligible' => true,
            'qr_code_token' => (string) Str::uuid(),
            'join_date' => fake()->dateTimeBetween('-3 years', '-3 months')->format('Y-m-d'),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']),
        ];
    }
}
