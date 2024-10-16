<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\Student;
use App\Enums\StudentStatus;
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
        $academicYear = AcademicYear::where('name', '2024/2025')->first();

        $categories = [
            'Yayasan' => [
                "Yayasan Pondok Pesantren Ki Ageng Mbodo" => [
                    'code' => '00',
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
                    'socialMediaLinks' => [
                        [
                            'name' => 'Pondok Pesantren Ki Ageng Mbodo',
                            'platform' => 'facebook',
                            'url' => 'https://www.facebook.com/profile.php?id=100010159720610',
                            'visibility' => 'public',
                        ],
                        [
                            'name' => 'Pondok Pesantren Ki Ageng Mbodo',
                            'platform' => 'instagram',
                            'url' => 'https://www.instagram.com/pondokmbodo/',
                            'visibility' => 'public',
                        ],
                        [
                            'name' => 'Pondok Pesantren Ki Ageng Mbodo',
                            'platform' => 'youtube',
                            'url' => 'https://www.youtube.com/@pondokmbodochannel1385',
                            'visibility' => 'public',
                        ],
                    ]
                ],
            ],
            'Pondok Pesantren' => [
                "Pesantren Putra" => [
                    'code' => '11',
                    'description' => null,
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [],
                ],
                "Pesantren Putri" => [
                    'code' => '12',
                    'description' => null,
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [],
                ],
                "Pesantren Tahfidzul Quran Putri" => [
                    'code' => '13',
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
                'Paud/TK Al-Hawi' => [
                    'code' => '21',
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
                'Madrasah Ibtidaiyyah Al-Hawi' => [
                    'code' => '22',
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
                'SMP Islam Al-Hawi' => [
                    'code' => '23',
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
                'Madrasah Aliyah Plus Islam Al-Hawi' => [
                    'code' => '24',
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
                    'code' => '31',
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Takhasus Athfal Kelas' => 6,
                    ],
                ],
                'Madrasah Wustho' => [
                    'code' => '32',
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Wusthu Kelas' => 3,
                    ],
                ],
                'Madrasah Ulya' => [
                    'code' => '33',
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
                    'code' => '41',
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Persiapan Kelas' => 3,
                    ],
                ],
                'Jurusan Tahsin Quran' => [
                    'code' => '42',
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Quran Tahsin Kelas' => 3,
                    ],
                ],
                'Jurusan Mahir Kitab' => [
                    'code' => '43',
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Kitap Kelas' => 3,
                    ],
                ],
                'Jurusan Suwuk' => [
                    'code' => '44',
                    'description' => 'Tempat belajar untuk anak-anak asik dan menyenangkan.',
                    'vision' => 'Terwujudnya tempat belajar menjadi Madrasah Idaman yang memiliki keunggulan barakhlakulkarimah dan berilmu pengetahuan.',
                    'mission' => "Untuk mewujudkan Visi Sekolah, maka ditetapkan Misi sebagai berikut: \n 1. Menanamkan akhlakul karimah di lingkungan madrasah. \n 2. Meningkatkan KBM yang berkualitas \n 3. Meningkatnya profesionalisme lembaga pendidikan dan administrasi. \n 4. Meningkatnya lingkungan madrasah aman, tertib, dan indah. \n 5. Meningkatnya optimalisasi sarana prasarana serta sumber daya pendidikan yang baik secara berkualitas maupun kuantitas.",
                    'classrooms' => [
                        'Suwuk Kelas' => 3,
                    ],
                ],
                'Jurusan Tahfidz' => [
                    'code' => '45',
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
                    'code' => '51',
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
                    'code' => '52',
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
                    'code' => '53',
                    'description' => null,
                    'vision' => null,
                    'mission' => null,
                    'classrooms' => [],
                ],
                'Taman Suwuk Nusantara' => [
                    'code' => '54',
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
                    'code' => '55',
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

        $homeroom_teacher_last_id = 3;
        $studentint = 5;
        $counter = 1;
        $studentCounter = 0;
        $startTime = microtime(true);
        foreach ($categories as $category => $organizations) {
            foreach ($organizations as $organizationName => $organization) {
                $organizationModel = Organization::create([
                    'code' => $organization['code'],
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
                            'wallet_code' => $key,
                            'name' => $value['name'],
                            'balance' => $value['balance'],
                            'policy' => $value['policy'] ?? null,
                        ]);
                    };
                } else {
                    $organizationModel->wallets()->create([
                        'wallet_code' => str($organizationModel->name)->upper()->replace(' ', '_'),
                        'name' => 'Dompet Utama',
                        'balance' => 0,
                    ]);
                }

                if (isset($organization['socialMediaLinks'])) {
                    foreach ($organization['socialMediaLinks'] as $key => $value) {
                        $organizationModel->socialMediaLinks()->create([
                            'name' => $value['name'],
                            // 'username' => $value['username'],
                            'url' => $value['url'],
                            'visibility' => $value['visibility'],
                            'platform' => $value['platform'],
                        ]);
                    }
                }

                foreach ($organization['classrooms'] as $className => $count) {
                    for ($i = 1; $i <= $count; $i++) {
                        if ($homeroom_teacher_last_id == 51) {
                            $homeroom_teacher_last_id = 3;
                        }

                        // Kelas Putra
                        $classroomName = $className . ' ' . $i . ' Putra';
                        $classroomMale = $organizationModel->classrooms()->create([
                            'name' => $classroomName,
                            'combined_name' => $classroomName . ' - ' . $academicYear->name,
                            'academic_year_id' => $academicYear->id,
                            'homeroom_teacher_id' => $homeroom_teacher_last_id,
                        ]);

                        // Info Command
                        $seconds = number_format((microtime(true) - $startTime), 2);
                        $this->command->info($counter . ' ' . $organizationModel->name . ' ' . 'Classroom created: ' . $classroomName . ' ....... ' . $seconds . ' seconds.');

                        // Create Student
                        $classroomMale->students()->createMany(Student::factory($studentint)->make([
                            'gender' => Gender::MALE,
                            'status' => StudentStatus::ACTIVE,
                        ])->toArray());

                        // Info Command
                        $studentCounter += $studentint;
                        $seconds = number_format((microtime(true) - $startTime), 2);
                        $this->command->line('   ->  [' . $studentCounter . ']  -->  ' . $studentint . ' Student created. (' . $seconds . ') seconds.',);

                        // Create Homeroom Teacher
                        $organizationModel->users()->attach($homeroom_teacher_last_id, ['role' => 'Wali Kelas ' . $classroomName]);
                        $homeroom_teacher_last_id++;
                        $counter++;

                        // Kelas Putri
                        $classroomName = $className . ' ' . $i . ' Putri';
                        $classroomFemale = $organizationModel->classrooms()->create([
                            'name' => $classroomName,
                            'combined_name' => $classroomName . ' - ' . $academicYear->name,
                            'academic_year_id' => $academicYear->id,
                            'homeroom_teacher_id' => $homeroom_teacher_last_id,
                        ]);

                        // Info Command
                        $seconds = number_format((microtime(true) - $startTime), 2);
                        $this->command->warn($counter . ' ' . $organizationModel->name . ' ' . 'Classroom created: ' . $classroomName . ' ....... ' . $seconds . ' seconds.');

                        // Create Student
                        $classroomFemale->students()->createMany(Student::factory($studentint)->make([
                            'gender' => Gender::FEMALE,
                            'status' => StudentStatus::ACTIVE,
                        ])->toArray());

                        // Info Command
                        $studentCounter += $studentint;
                        $seconds = number_format((microtime(true) - $startTime), 2);
                        $this->command->line('   ->  [' . $studentCounter . ']  -->  ' . $studentint . ' Student created. (' . $seconds . ') seconds.',);

                        // Create Homeroom Teacher
                        $organizationModel->users()->attach($homeroom_teacher_last_id, ['role' => 'Wali Kelas ' . $classroomName]);
                        $homeroom_teacher_last_id++;
                        $counter++;
                    }
                }
            }
        }
    }
}
