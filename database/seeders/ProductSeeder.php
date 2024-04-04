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
        Product::insert([
            ['name' => 'Pendaftaran PAUD', 'price' => 30000, 'payment_term' => 'Sekali'],
            ['name' => 'SPP PAUD', 'price' => 30000, 'payment_term' => 'Bulanan'],
            ['name' => 'Seragam Olahraga PAUD Putra', 'price' => 50000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Olahraga PAUD Putri', 'price' => 80000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Putih Biru PAUD Putra', 'price' => 150000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Putih Biru PAUD Putri', 'price' => 175000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Batik PAUD Putra', 'price' => 150000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Batik PAUD Putri', 'price' => 175000, 'payment_term' => 'Sekali'],
            ['name' => 'Pendaftaran MI', 'price' => 50000, 'payment_term' => 'Sekali'],
            ['name' => 'SPP MI', 'price' => 40000, 'payment_term' => 'Bulanan'],
            ['name' => 'Seragam Merah Putih MI Putra', 'price' => 150000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Merah Putih MI Putri', 'price' => 175000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Batik MI Putra/i', 'price' => 175000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Pramuka MI Putra/i', 'price' => 175000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam Olahraga MI Putra/i', 'price' => 60000, 'payment_term' => 'Sekali'],
            ['name' => 'Pendaftaran SMP/MA', 'price' => 100000, 'payment_term' => 'Sekali'],
            ['name' => 'Pelatihan Tradisi Pesantren', 'price' => 100000, 'payment_term' => 'Sekali'],
            ['name' => 'Seragam OSIS, Pramuka, Olah Raga, Batik, dan Atribut Sekolah', 'price' => 800000, 'payment_term' => 'Sekali'],
            ['name' => 'Catering', 'price' => 300000, 'payment_term' => 'Bulanan'],
            ['name' => 'Laundry Seragam', 'price' => 50000, 'payment_term' => 'Bulanan'],
            ['name' => 'Syahriyyah SMP', 'price' => 250000, 'payment_term' => 'Bulanan'],
            ['name' => 'Syahriyyah MA', 'price' => 275000, 'payment_term' => 'Bulanan'],
            ['name' => 'Formal SMP', 'price' => 50000, 'payment_term' => 'Bulanan'],
            ['name' => 'Formal MA', 'price' => 75000, 'payment_term' => 'Bulanan'],
            ['name' => 'Madin', 'price' => 50000, 'payment_term' => 'Bulanan'],
            ['name' => 'Extra', 'price' => 50000, 'payment_term' => 'Bulanan'],
            ['name' => 'Jurusan', 'price' => 50000, 'payment_term' => 'Bulanan'],
            ['name' => 'Pesantren', 'price' => 50000, 'payment_term' => 'Bulanan'],
            ['name' => 'Kitab', 'price' => 200000, 'payment_term' => 'Bulanan'],
            ['name' => 'Pengadaan Almari', 'price' => 150000, 'payment_term' => 'Semester'],
            ['name' => 'Field Trip Tiap Semester', 'price' => 100000, 'payment_term' => 'Semester']
        ]);
    }
}
