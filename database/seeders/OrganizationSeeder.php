<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::where('name', '2023/2024')->first();
        $categories = [
            'Sekolah Formal' => [
                'Paud/TK' => ['Paud Besar', 'Paud Kecil', 'TK Kecil', 'TK Besar'],
                'MI/SD' => [
                    'SD Kelas' => 6,
                ],
                'SMP Islam Al Hawi' => [
                    'SMP Kelas' => 3,
                ],
                'SMK Islam Al Hawi' => [
                    'SMK Kelas' => 3,
                ],
            ],
            'Sekolah Madarasah' => [
                'Takhasus Athfal' => [
                    'Takhasus Athfal Kelas' => 6,
                ],
                'Kelas Wusthu' => [
                    'Wusthu Kelas' => 3,
                ],
                'Kelas Ulya' => [
                    'Ulya Kelas' => 3,
                ],
            ],
            'Program Jurusan' => [
                'Jurusan Persiapan' => [
                    'J.P. Kelas' => 3,
                ],
                'Jurusan Quran Tahsin' => [
                    'J.Tahsin Kelas' => 3,
                ],
                'Jurusan Kitap' => [
                    'J.Kitap Kelas' => 3,
                ],
                'Jurusan Suwuk' => [
                    'J.Suwuk Kelas' => 3,
                ],
                'Jurusan Tahfidz' => [
                    'J.Tahfidz Kelas' => 3,
                ],
            ],
        ];

        foreach ($categories as $category => $schools) {
            foreach ($schools as $schoolName => $classrooms) {
                $organization = Organization::create(['name' => $schoolName, 'category' => $category, 'slug' => str()->slug($schoolName)]);

                // foreach ($classrooms as $className => $count) {
                //     for ($i = 1; $i <= $count; $i++) {
                //         $organization->classrooms()->create([
                //             'name' => $className . ' ' . $i . ' Putra',
                //             'slug' => str()->slug($className . ' ' . $i . ' Putra'),
                //             'combined_name' => $className . ' ' . $i . ' Putra - ' . $academicYear->name,
                //             'academic_year_id' => $academicYear->id,
                //             'homeroom_teacher_id' => 8 + $i,
                //         ]);
                //         $organization->classrooms()->create([
                //             'name' => $className . ' ' . $i . ' Putri',
                //             'slug' => str()->slug($className . ' ' . $i . ' Putri'),
                //             'combined_name' => $className . ' ' . $i . ' Putri - ' . $academicYear->name,
                //             'academic_year_id' => $academicYear->id,
                //             'homeroom_teacher_id' => 8 + $i,
                //         ]);
                //     }
                // }
            }
        }
    }
}
