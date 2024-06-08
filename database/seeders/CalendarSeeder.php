<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Calendar;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calendarKaesa = Calendar::create([
            'user_id' => 1,
            'name' => 'Primary - Kaesa Lyrih',
            'timezone' => 'Asia/Jakarta',
            'google_calendar_id' => 'kesalyrih@gmail.com',
            'description' => 'Primary Calendar',
            'color' => '#ffffff',
        ]);

        // Create 5 events for the created calendar
        Event::factory(5)->create([
            'calendar_id' => $calendarKaesa->id,
        ]);

        $calendarUser2 = Calendar::create([
            'user_id' => 2,
            'name' => 'Primary - User 2',
            'timezone' => 'Asia/Jakarta',
            'google_calendar_id' => 'puser2',
            'description' => 'Primary Calendar',
            'color' => '#ffffff',
            'visibility' => 'public',
        ]);

        // Create 5 events for the created calendar
        Event::factory(5)->create([
            'calendar_id' => $calendarUser2->id,
        ]);
    }
}
