<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Pendaftaran PAUD',
                'price' => 30000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'SPP PAUD',
                'price' => 30000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Seragam Olahraga PAUD Putra',
                'price' => 50000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Olahraga PAUD Putri',
                'price' => 80000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Putih Biru PAUD Putra',
                'price' => 150000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Putih Biru PAUD Putri',
                'price' => 175000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Batik PAUD Putra',
                'price' => 150000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Batik PAUD Putri',
                'price' => 175000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Pendaftaran MI',
                'price' => 50000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'SPP MI',
                'price' => 40000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Seragam Merah Putih MI Putra',
                'price' => 150000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Merah Putih MI Putri',
                'price' => 175000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Batik MI Putra/i',
                'price' => 175000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Pramuka MI Putra/i',
                'price' => 175000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam Olahraga MI Putra/i',
                'price' => 60000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Pendaftaran SMP/MA',
                'price' => 100000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Pelatihan Tradisi Pesantren',
                'price' => 100000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Seragam OSIS, Pramuka, Olah Raga, Batik, dan Atribut Sekolah',
                'price' => 800000,
                'payment_term' => 'once'
            ],
            [
                'name' => 'Catering',
                'price' => 300000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Laundry Seragam',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Syahriyyah SMP',
                'price' => 250000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Syahriyyah MA',
                'price' => 275000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Formal SMP',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Formal MA',
                'price' => 75000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Madin',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Extra',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Jurusan',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Pesantren',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Kitab',
                'price' => 200000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Pengadaan Almari',
                'price' => 150000,
                'payment_term' => 'yearly'
            ],
            [
                'name' => 'Field Trip Tiap Semester',
                'price' => 100000,
                'payment_term' => 'semester'
            ],
            [
                'name' => 'Makan 1 Kali',
                'price' => 50000,
                'payment_term' => 'monthly'
            ],
            [
                'name' => 'Transportasi',
                'price' => 60000,
                'payment_term' => 'monthly'
            ],
        ];

        foreach ($products as $productData) {
            $productData['slug'] = str()->slug($productData['name']); // Buat slug dari nama produk
            Product::create($productData); // Masukkan data ke dalam database
        }
    }
}
