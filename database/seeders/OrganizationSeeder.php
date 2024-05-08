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
            'Yayasan' => [
                "Yayasan Pondok Pesantren Ki Ageng Mbodo" => [
                    'description' => null,
                    'email' => 'pondokmbodo@gmail.com',
                    'phone' => '6281234567890',
                    'address' => 'Dusun Sendangsari RT05 RW07, Desa Tambirejo, Kec. Toroh, Kab. Grobogan, Prov. Jawa Tengah 58171',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [],
                    'wallets' => [
                        "YAYASAN" => [
                            'name' => 'Dompet Yayasan',
                            'balance' => 0,
                        ],
                        "SYSTEM" => [
                            'name' => 'Dompet Sistem',
                            'balance' => 0,
                            'policy' => ['ALLOW_NEGATIVE_BALANCE'],
                        ],
                        "DONATUR" => [
                            'name' => 'Dompet Donatur',
                            'balance' => 0,
                            'policy' => ['ALLOW_NEGATIVE_BALANCE'],
                        ],
                        "DANA_BOS" => [
                            'name' => 'Dompet Dana BOS',
                            'balance' => 0,
                            'policy' => ['ALLOW_NEGATIVE_BALANCE'],
                        ],
                        "INCOME" => [
                            'name' => 'Dompet Pemasukan',
                            'balance' => 0,
                            'policy' => ['ALLOW_NEGATIVE_BALANCE'],
                        ],
                        "EXPENSE" => [
                            'name' => 'Dompet Pengeluaran',
                            'balance' => 0,
                        ],
                    ],
                ],
            ],
            'Pondok Pesantren' => [
                "Pesantren Putra" => [
                    'description' => null,
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [],
                ],
                "Pesantren Putri" => [
                    'description' => null,
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [],
                ],
                "Pesantren Tahfidzul Quran Putri" => [
                    'description' => null,
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [],
                    'wallets' => [
                        "TAHFIDZUL" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
            ],
            'Sekolah Formal' => [
                'Paud/TK' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Paud Kecil' => 1,
                        'Paud Besar' => 1,
                        'TK Kecil' => 1,
                        'TK Besar' => 1,
                    ],
                    'wallets' => [
                        "PAUD_TK" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
                'MI/SD' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'MI Kelas' => 6
                    ],
                    'wallets' => [
                        "MI_SD" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
                'SMP Islam Al Hawi' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'SMP Kelas' => 3,
                    ],
                    'wallets' => [
                        "SMP" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
                'Madrasah Aliyah Plus Islam Al Hawi' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'MA Kelas' => 3,
                    ],
                    'wallets' => [
                        "MA" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
            ],
            'Sekolah Madrasah' => [
                'Takhasus Athfal' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Takhasus Athfal Kelas' => 6,
                    ],
                ],
                'Madrasah Wustho' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Wusthu Kelas' => 3,
                    ],
                ],
                'Madrasah Ulya' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Ulya Kelas' => 3,
                    ],
                ],
            ],
            'Program Jurusan' => [
                'Jurusan Persiapan' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Persiapan Kelas' => 3,
                    ],
                ],
                'Jurusan Tahsin Quran' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Quran Tahsin Kelas' => 3,
                    ],
                ],
                'Jurusan Mahir Kitab' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Kitap Kelas' => 3,
                    ],
                ],
                'Jurusan Suwuk' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Suwuk Kelas' => 3,
                    ],
                ],
                'Jurusan Tahfidz' => [
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Tahfidz Kelas' => 3,
                    ],
                ],
            ],
            'Badan Lembaga' => [
                'Majelis Lapanan Ahad Kliwon Jimad Sholawat' => [
                    'description' => null,
                    'vision' => null,
                    'mission' => null,
                    'classrooms' => [],
                    'wallets' => [
                        "MLAKJS" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
                'Jamiyah Thoriqoh Qodiriyah Al Jaelaniyah' => [
                    'description' => null,
                    'vision' => null,
                    'mission' => null,
                    'classrooms' => [],
                    'wallets' => [
                        "JTQAJ" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
                'Langit Tour' => [
                    'description' => null,
                    'vision' => null,
                    'mission' => null,
                    'classrooms' => [],
                ],
                'Taman Suwuk Nusantara' => [
                    'description' => null,
                    'vision' => null,
                    'mission' => null,
                    'classrooms' => [],
                    'wallets' => [
                        "TSN" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],
                'Padepokan Satrio Mbodo' => [
                    'description' => null,
                    'vision' => null,
                    'mission' => null,
                    'classrooms' => [],
                    'wallets' => [
                        "PSM" => [
                            'name' => 'Dompet Utama',
                            'balance' => 0,
                        ],
                    ],
                ],

            ],
        ];

        $homeroom_teacher_last_id = 2;
        foreach ($categories as $category => $organizations) {
            foreach ($organizations as $organizationName => $organization) {
                $organizationModel = Organization::create([
                    'name' => $organizationName,
                    'slug' => str()->slug($organizationName),
                    'category' => $category,
                    'description' => $organization['description'],
                    'vision' => $organization['vision'],
                    'mission' => $organization['mission'],
                    'email' => $organization['email'] ?? null,
                    'phone' => $organization['phone'] ?? null,
                    'address' => $organization['address'] ?? null,
                ]);

                if (isset($organization['wallets'])) {
                    foreach ($organization['wallets'] as $key => $value) {
                        $organizationModel->wallets()->create([
                            'id' => $key,
                            'name' => $value['name'],
                            'balance' => $value['balance'],
                            'policy' => $value['policy'] ?? null,
                        ]);
                    };
                } else {
                    $organizationModel->wallets()->create([
                        'id' => str($organizationModel->name)->upper()->replace(' ', '_'),
                        'name' => 'Dompet Utama',
                        'balance' => 0,
                    ]);
                }


                foreach ($organization['classrooms'] as $className => $count) {
                    for ($i = 1; $i <= $count; $i++) {
                        if ($homeroom_teacher_last_id == 100) {
                            $homeroom_teacher_last_id = 2;
                        }
                        $classroomName = $className . ' ' . $i . ' Putra';
                        $organizationModel->classrooms()->create([
                            'name' => $classroomName,
                            'combined_name' => $classroomName . ' - ' . $academicYear->name,
                            'academic_year_id' => $academicYear->id,
                            'homeroom_teacher_id' => $homeroom_teacher_last_id,
                        ]);
                        $organizationModel->users()->attach($homeroom_teacher_last_id, ['role' => 'Wali Kelas ' . $classroomName]);
                        $homeroom_teacher_last_id++;
                        $classroomName = $className . ' ' . $i . ' Putri';
                        $organizationModel->classrooms()->create([
                            'name' => $classroomName,
                            'combined_name' => $classroomName . ' - ' . $academicYear->name,
                            'academic_year_id' => $academicYear->id,
                            'homeroom_teacher_id' => $homeroom_teacher_last_id,
                        ]);
                        $organizationModel->users()->attach($homeroom_teacher_last_id, ['role' => 'Wali Kelas ' . $classroomName]);
                        $homeroom_teacher_last_id++;
                    }
                }
            }
        }
    }
}
