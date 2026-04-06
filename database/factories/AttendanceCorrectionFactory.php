<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceCorrectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'old_check_in' => now()->subHours(10),
            'new_check_in' => now()->subHours(9),
            'old_check_out' => now()->subHours(2),
            'new_check_out' => now()->subHour(),
            'reason' => fake()->sentence(),
        ];
    }
}
