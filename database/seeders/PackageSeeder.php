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
            [
                'name' => 'Pendaftaran PAUD/TK Putra (Reguler)',
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
                ]
            ],
            [
                'name' => 'Pendaftaran PAUD/TK Putri (Reguler)',
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
                ]
            ],
            [
                'name' => 'Pendaftaran MI Putra (Reguler)',
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
                ]
            ],
            [
                'name' => 'Pendaftaran MI Putri (Reguler)',
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
                ]
            ],
            [
                'name' => 'Pendaftaran SMP (Reguler)',
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
                ]
            ],
            [
                'name' => 'Pendaftaran MA (Reguler)',
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
                ]
            ],
        ];

        // Insert the packages
        foreach ($packages as $packageData) {
            $package = Package::create(['name' => $packageData['name'], 'slug' => str()->slug($packageData['name'])]);
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
