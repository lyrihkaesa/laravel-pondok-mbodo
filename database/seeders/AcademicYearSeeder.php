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
            $startYear = 2019;
            $endYear = 2024;

            $data = [];

            for ($year = $startYear; $year < $endYear; $year++) {
                $academicYear = $year . '/' . ($year + 1);
                $data[] = ['name' => $academicYear];
            }

            AcademicYear::insert($data);
        });
    }
}
