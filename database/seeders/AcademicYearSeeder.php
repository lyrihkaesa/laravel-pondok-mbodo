<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicYear::withoutEvents(function () {
            $startYear = 2018;
            $endYear = 2025;

            $data = [];

            for ($year = $startYear; $year < $endYear; $year++) {
                $academicYear = $year . '/' . ($year + 1);
                $data[] = [
                    'name' => $academicYear,
                    'slug' => str_replace('/', '-', $academicYear),
                    'is_active' => $year >= 2023 ? true : false,
                ];
            }

            AcademicYear::insert($data);
        });
    }
}
