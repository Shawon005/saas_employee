<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Eid Holiday', 'Weekly Friday Off', 'Victory Day']),
            'date' => fake()->dateTimeBetween('-60 days', '+60 days')->format('Y-m-d'),
            'type' => fake()->randomElement(['PublicHoliday', 'WeeklyOff']),
            'is_double_pay' => fake()->boolean(20),
        ];
    }
}
