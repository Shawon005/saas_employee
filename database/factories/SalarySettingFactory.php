<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalarySettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'house_rent_percent' => 50,
            'medical_allowance_fixed' => 1500,
            'attendance_bonus_amount' => 1000,
            'standard_hours_per_day' => 8,
            'ot_divisor' => 208,
            'ot_multiplier' => 2,
        ];
    }
}
