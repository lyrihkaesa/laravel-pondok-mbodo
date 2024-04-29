<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            'Pendaftaran PAUD/TK Putra Reguler' =>  [
                'product_names' => [
                    'Pendaftaran PAUD',
                    'SPP PAUD',
                    'Seragam Olahraga PAUD Putra',
                    'Seragam Putih Biru PAUD Putra',
                    'Seragam Batik PAUD Putra',
                ],
                'category_names' => [
                    'PAUD/TK',
                    'Santri Reguler',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Laki-Laki',
                ]
            ],
            'Pendaftaran PAUD/TK Putri Reguler' => [
                'product_names' => [
                    'Pendaftaran PAUD',
                    'SPP PAUD',
                    'Seragam Olahraga PAUD Putri',
                    'Seragam Putih Biru PAUD Putri',
                    'Seragam Batik PAUD Putri',
                ],
                'category_names' => [
                    'PAUD/TK',
                    'Santri Reguler',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Perempuan',
                ]
            ],
            'Pendaftaran MI Putra Reguler' => [
                'product_names' => [
                    'Pendaftaran MI',
                    'SPP MI',
                    'Seragam Merah Putih MI Putra',
                    'Seragam Batik MI Putra/i',
                    'Seragam Pramuka MI Putra/i',
                    'Seragam Olahraga MI Putra/i',
                    'Makan 1 Kali',
                    'Transportasi',
                ],
                'category_names' => [
                    'MI',
                    'Santri Reguler',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Laki-Laki',
                ]
            ],
            'Pendaftaran MI Putri Reguler' => [
                'product_names' => [
                    'Pendaftaran MI',
                    'SPP MI',
                    'Seragam Merah Putih MI Putri',
                    'Seragam Batik MI Putra/i',
                    'Seragam Pramuka MI Putra/i',
                    'Seragam Olahraga MI Putra/i',
                    'Makan 1 Kali',
                    'Transportasi',
                ],
                'category_names' => [
                    'MI',
                    'Santri Reguler',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Perempuan',
                ]
            ],
            'Pendaftaran SMP Reguler' => [
                'product_names' => [
                    'Pendaftaran SMP/MA',
                    'Pelatihan Tradisi Pesantren',
                    'Seragam OSIS, Pramuka, Olah Raga, Batik, dan Atribut Sekolah',
                    'Catering',
                    'Laundry Seragam',
                    'Syahriyyah SMP',
                    'Formal SMP',
                    'Madin',
                    'Extra',
                    'Jurusan',
                    'Pesantren',
                    'Kitab',
                    'Pengadaan Almari',
                    'Field Trip Tiap Semester',
                ],
                'category_names' => [
                    'SMP',
                    'Santri Reguler',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Laki-Laki',
                    'Perempuan',
                ]
            ],
            'Pendaftaran MA Reguler' => [
                'product_names' => [
                    'Pendaftaran SMP/MA',
                    'Pelatihan Tradisi Pesantren',
                    'Seragam OSIS, Pramuka, Olah Raga, Batik, dan Atribut Sekolah',
                    'Catering',
                    'Laundry Seragam',
                    'Syahriyyah MA',
                    'Formal MA',
                    'Madin',
                    'Extra',
                    'Jurusan',
                    'Pesantren',
                    'Kitab',
                    'Pengadaan Almari',
                    'Field Trip Tiap Semester',
                ],
                'category_names' => [
                    'MA',
                    'Santri Reguler',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Laki-Laki',
                    'Perempuan',
                ]
            ],
            // 'Pendaftaran PAUD/TK Putra Berprestasi' =>  [
            //     'product_names' => [
            //         'Pendaftaran PAUD',
            //         'SPP PAUD',
            //         'Seragam Olahraga PAUD Putra',
            //         'Seragam Putih Biru PAUD Putra',
            //         'Seragam Batik PAUD Putra',
            //     ],
            //     'category_names' => [
            //         'PAUD/TK',
            //         'Santri Berprestasi',
            //         'Biaya Pendidikan',
            //         'Biaya Pendaftaran',
            //         'Laki-Laki',
            //     ]
            // ],
            // 'Pendaftaran PAUD/TK Putri Berprestasi' => [
            //     'product_names' => [
            //         'Pendaftaran PAUD',
            //         'SPP PAUD',
            //         'Seragam Olahraga PAUD Putri',
            //         'Seragam Putih Biru PAUD Putri',
            //         'Seragam Batik PAUD Putri',
            //     ],
            //     'category_names' => [
            //         'PAUD/TK',
            //         'Santri Berprestasi',
            //         'Biaya Pendidikan',
            //         'Biaya Pendaftaran',
            //         'Perempuan',
            //     ]
            // ],
            // 'Pendaftaran MI Putra Berprestasi' => [
            //     'product_names' => [
            //         'Pendaftaran MI',
            //         'SPP MI',
            //         'Seragam Merah Putih MI Putra',
            //         'Seragam Batik MI Putra/i',
            //         'Seragam Pramuka MI Putra/i',
            //         'Seragam Olahraga MI Putra/i',
            //         'Makan 1 Kali',
            //         'Transportasi',
            //     ],
            //     'category_names' => [
            //         'MI',
            //         'Santri Berprestasi',
            //         'Biaya Pendidikan',
            //         'Biaya Pendaftaran',
            //         'Laki-Laki',
            //     ]
            // ],
            // 'Pendaftaran MI Putri Berprestasi' => [
            //     'product_names' => [
            //         'Pendaftaran MI',
            //         'SPP MI',
            //         'Seragam Merah Putih MI Putri',
            //         'Seragam Batik MI Putra/i',
            //         'Seragam Pramuka MI Putra/i',
            //         'Seragam Olahraga MI Putra/i',
            //         'Makan 1 Kali',
            //         'Transportasi',
            //     ],
            //     'category_names' => [
            //         'MI',
            //         'Santri Berprestasi',
            //         'Biaya Pendidikan',
            //         'Biaya Pendaftaran',
            //         'Perempuan',
            //     ]
            // ],
            'Pendaftaran SMP Berprestasi' => [
                'product_names' => [
                    'Pendaftaran SMP/MA',
                    'Pelatihan Tradisi Pesantren',
                    'Seragam OSIS, Pramuka, Olah Raga, Batik, dan Atribut Sekolah',
                    'Catering',
                    'Laundry Seragam',
                    'Madin',
                    'Extra',
                    'Jurusan',
                    'Pesantren',
                    'Kitab',
                    'Pengadaan Almari',
                    'Field Trip Tiap Semester',
                ],
                'category_names' => [
                    'SMP',
                    'Santri Berprestasi',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Laki-Laki',
                    'Perempuan',
                ]
            ],
            'Pendaftaran MA Berprestasi' => [
                'product_names' => [
                    'Pendaftaran SMP/MA',
                    'Pelatihan Tradisi Pesantren',
                    'Seragam OSIS, Pramuka, Olah Raga, Batik, dan Atribut Sekolah',
                    'Catering',
                    'Laundry Seragam',
                    'Madin',
                    'Extra',
                    'Jurusan',
                    'Pesantren',
                    'Kitab',
                    'Pengadaan Almari',
                    'Field Trip Tiap Semester',
                ],
                'category_names' => [
                    'MA',
                    'Santri Berprestasi',
                    'Biaya Pendidikan',
                    'Biaya Pendaftaran',
                    'Laki-Laki',
                    'Perempuan',
                ]
            ],
        ];

        // Insert the packages
        foreach ($packages as $packageName => $packageData) {
            $package = Package::create(['name' => $packageName, 'slug' => str()->slug($packageName)]);
            $categories = Category::whereIn('name', $packageData['category_names'])->get();
            $package->categories()->attach($categories);
            foreach ($packageData['product_names'] as $productName) {
                $product = Product::where('name', $productName)->first();
                if ($product) {
                    $package->products()->attach($product->id);
                }
            }
        }
    }
}
