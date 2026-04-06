<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    public function definition(): array
    {
        return [
            'month' => fake()->numberBetween(1, 12),
            'year' => (int) now()->format('Y'),
            'total_days_present' => fake()->numberBetween(20, 26),
            'total_late_count' => fake()->numberBetween(0, 4),
            'total_ot_hours' => fake()->randomFloat(2, 0, 40),
            'basic_salary' => fake()->randomFloat(2, 8500, 18000),
            'house_rent' => fake()->randomFloat(2, 4000, 9000),
            'medical_allowance' => 1500,
            'attendance_bonus' => fake()->randomFloat(2, 0, 1000),
            'ot_amount' => fake()->randomFloat(2, 0, 5000),
            'friday_holiday_allowance' => fake()->randomFloat(2, 0, 2000),
            'total_deductions' => fake()->randomFloat(2, 0, 500),
            'net_payable' => fake()->randomFloat(2, 12000, 26000),
            'status' => fake()->randomElement(['Draft', 'Finalized']),
            'finalized_at' => now(),
        ];
    }
}
