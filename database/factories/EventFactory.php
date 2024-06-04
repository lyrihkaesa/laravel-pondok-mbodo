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
        $start = now()->startOfMonth()->addDays(random_int(1, now()->endOfMonth()->day));
        return [
            'title' => $this->faker->sentence(),
            'location' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
            'start' => $start->copy()->addHours(random_int(1, 11)),
            'end' => $start->copy()->addDays(random_int(0, 7))->addHours(random_int(11, 24)),
            'color' => $this->faker->hexColor(),
        ];
    }
}
