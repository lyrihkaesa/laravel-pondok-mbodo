<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create(['name' => 'Paud/TK', 'category' => 'Sekolah Formal'])
            ->classrooms()->createMany([
                ['name' => 'Paud Besar', 'combined_name' => 'Paud Besar - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'Paud Kecil', 'combined_name' => 'Paud Kecil - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'TK Kecil', 'combined_name' => 'TK Kecil - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'TK Besar', 'combined_name' => 'TK Besar - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ]);
        School::create(['name' => 'MI/SD', 'category' => 'Sekolah Formal'])
            ->classrooms()->createMany([
                ['name' => 'SD Kelas 1 Putra', 'combined_name' => 'SD Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 1 Putri', 'combined_name' => 'SD Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 2 Putra', 'combined_name' => 'SD Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 2 Putri', 'combined_name' => 'SD Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 3 Putra', 'combined_name' => 'SD Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 3 Putri', 'combined_name' => 'SD Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 4 Putra', 'combined_name' => 'SD Kelas 4 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 4 Putri', 'combined_name' => 'SD Kelas 4 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 5 Putra', 'combined_name' => 'SD Kelas 5 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 5 Putri', 'combined_name' => 'SD Kelas 5 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 6 Putra', 'combined_name' => 'SD Kelas 6 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SD Kelas 6 Putri', 'combined_name' => 'SD Kelas 6 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ]);
        School::create(['name' => 'SMP Islam Al Hawi', 'category' => 'Sekolah Formal'])
            ->classrooms()->createMany([
                ['name' => 'SMP Kelas 1 Putra', 'combined_name' => 'SMP Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMP Kelas 1 Putri', 'combined_name' => 'SMP Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMP Kelas 2 Putra', 'combined_name' => 'SMP Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMP Kelas 2 Putri', 'combined_name' => 'SMP Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMP Kelas 3 Putra', 'combined_name' => 'SMP Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMP Kelas 3 Putri', 'combined_name' => 'SMP Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ]);
        School::create(['name' => 'SMK Islam Al Hawi', 'category' => 'Sekolah Formal'])
            ->classrooms()->createMany([
                ['name' => 'SMK Kelas 1 Putra', 'combined_name' => 'SMK Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMK Kelas 1 Putri', 'combined_name' => 'SMK Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMK Kelas 2 Putra', 'combined_name' => 'SMK Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMK Kelas 2 Putri', 'combined_name' => 'SMK Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMK Kelas 3 Putra', 'combined_name' => 'SMK Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
                ['name' => 'SMK Kelas 3 Putri', 'combined_name' => 'SMK Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ]);

        School::create(['name' => 'Takhasus Athfal', 'category' => 'Sekolah Madarasah'])->classrooms()->createMany([
            ['name' => 'Takhasus Athfal Kelas 1 Putra', 'combined_name' => 'Takhasus Athfal Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 1 Putri', 'combined_name' => 'Takhasus Athfal Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 2 Putra', 'combined_name' => 'Takhasus Athfal Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 2 Putri', 'combined_name' => 'Takhasus Athfal Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 3 Putra', 'combined_name' => 'Takhasus Athfal Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 3 Putri', 'combined_name' => 'Takhasus Athfal Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 4 Putra', 'combined_name' => 'Takhasus Athfal Kelas 4 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 4 Putri', 'combined_name' => 'Takhasus Athfal Kelas 4 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 5 Putra', 'combined_name' => 'Takhasus Athfal Kelas 5 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 5 Putri', 'combined_name' => 'Takhasus Athfal Kelas 5 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 6 Putra', 'combined_name' => 'Takhasus Athfal Kelas 6 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Takhasus Athfal Kelas 6 Putri', 'combined_name' => 'Takhasus Athfal Kelas 6 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Kelas Wusthu', 'category' => 'Sekolah Madarasah'])->classrooms()->createMany([
            ['name' => 'Wusthu Kelas 1 Putra', 'combined_name' => 'Wusthu Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Wusthu Kelas 1 Putri', 'combined_name' => 'Wusthu Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Wusthu Kelas 2 Putra', 'combined_name' => 'Wusthu Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Wusthu Kelas 2 Putri', 'combined_name' => 'Wusthu Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Wusthu Kelas 3 Putra', 'combined_name' => 'Wusthu Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Wusthu Kelas 3 Putri', 'combined_name' => 'Wusthu Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Kelas Ulya', 'category' => 'Sekolah Madarasah'])->classrooms()->createMany([
            ['name' => 'Ulya Kelas 1 Putra', 'combined_name' => 'Ulya Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Ulya Kelas 1 Putri', 'combined_name' => 'Ulya Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Ulya Kelas 2 Putra', 'combined_name' => 'Ulya Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Ulya Kelas 2 Putri', 'combined_name' => 'Ulya Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Ulya Kelas 3 Putra', 'combined_name' => 'Ulya Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'Ulya Kelas 3 Putri', 'combined_name' => 'Ulya Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Jurusan Persiapan', 'category' => 'Program Jurusan'])->classrooms()->createMany([
            ['name' => 'J.P. Kelas 1 Putra', 'combined_name' => 'J.P. Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.P. Kelas 1 Putri', 'combined_name' => 'J.P. Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.P. Kelas 2 Putra', 'combined_name' => 'J.P. Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.P. Kelas 2 Putri', 'combined_name' => 'J.P. Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.P. Kelas 3 Putra', 'combined_name' => 'J.P. Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.P. Kelas 3 Putri', 'combined_name' => 'J.P. Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Jurusan Quran Tahsin', 'category' => 'Program Jurusan'])->classrooms()->createMany([
            ['name' => 'J.Tahsin Kelas 1 Putra', 'combined_name' => 'J.Tahsin Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahsin Kelas 1 Putri', 'combined_name' => 'J.Tahsin Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahsin Kelas 2 Putra', 'combined_name' => 'J.Tahsin Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahsin Kelas 2 Putri', 'combined_name' => 'J.Tahsin Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahsin Kelas 3 Putra', 'combined_name' => 'J.Tahsin Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahsin Kelas 3 Putri', 'combined_name' => 'J.Tahsin Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Jurusan Kitap', 'category' => 'Program Jurusan'])->classrooms()->createMany([
            ['name' => 'J.Kitap Kelas 1 Putra', 'combined_name' => 'J.Kitap Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Kitap Kelas 1 Putri', 'combined_name' => 'J.Kitap Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Kitap Kelas 2 Putra', 'combined_name' => 'J.Kitap Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Kitap Kelas 2 Putri', 'combined_name' => 'J.Kitap Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Kitap Kelas 3 Putra', 'combined_name' => 'J.Kitap Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Kitap Kelas 3 Putri', 'combined_name' => 'J.Kitap Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Jurusan Suwuk', 'category' => 'Program Jurusan'])->classrooms()->createMany([
            ['name' => 'J.Suwuk Kelas 1 Putra', 'combined_name' => 'J.Suwuk Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Suwuk Kelas 1 Putri', 'combined_name' => 'J.Suwuk Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Suwuk Kelas 2 Putra', 'combined_name' => 'J.Suwuk Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Suwuk Kelas 2 Putri', 'combined_name' => 'J.Suwuk Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Suwuk Kelas 3 Putra', 'combined_name' => 'J.Suwuk Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Suwuk Kelas 3 Putri', 'combined_name' => 'J.Suwuk Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
        School::create(['name' => 'Jurusan Tahfidz', 'category' => 'Program Jurusan'])->classrooms()->createMany([
            ['name' => 'J.Tahfidz Kelas 1 Putra', 'combined_name' => 'J.Tahfidz Kelas 1 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahfidz Kelas 1 Putri', 'combined_name' => 'J.Tahfidz Kelas 1 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahfidz Kelas 2 Putra', 'combined_name' => 'J.Tahfidz Kelas 2 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahfidz Kelas 2 Putri', 'combined_name' => 'J.Tahfidz Kelas 2 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahfidz Kelas 3 Putra', 'combined_name' => 'J.Tahfidz Kelas 3 Putra - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
            ['name' => 'J.Tahfidz Kelas 3 Putri', 'combined_name' => 'J.Tahfidz Kelas 3 Putri - 2022/2023', 'academic_year_id' => 4, 'homeroom_teacher_id' => 8],
        ]);
    }
}
