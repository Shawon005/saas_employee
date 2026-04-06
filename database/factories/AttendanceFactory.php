<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
            'check_in' => now()->setTime(8, fake()->numberBetween(0, 45)),
            'check_out' => now()->setTime(17, fake()->numberBetween(0, 45)),
            'status' => fake()->randomElement(['Present', 'Late', 'Absent', 'Holiday']),
            'is_night_shift' => false,
            'regular_hours' => fake()->randomFloat(2, 6, 8),
            'ot_hours' => fake()->randomFloat(2, 0, 4),
            'late_minutes' => fake()->numberBetween(0, 30),
            'synced_from_device' => false,
        ];
    }
}
