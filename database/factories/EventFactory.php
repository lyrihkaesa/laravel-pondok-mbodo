<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'location' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
            'start' => now()->startOfMonth()->addDays(random_int(1, now()->endOfMonth()->day))->startOfDay(),
            'end' => now()->startOfMonth()->addDays(random_int(1, now()->endOfMonth()->day))->addHour(),
        ];
    }
}
