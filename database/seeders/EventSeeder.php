<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Event::truncate();
        \App\Models\Event::factory(5)->create();
        \App\Models\Event::factory(5)->create(
            [
                'start' => now(),
                'end' => now()->addHours(3),
            ]
        );
    }
}
