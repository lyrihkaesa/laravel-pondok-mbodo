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
        Product::create(['name' => 'Pendaftaran', 'price' => 100000]);
        Product::create(['name' => 'Pelatihan Tradisi Pesantren', 'price' => 100000]);
        Product::create(['name' => 'Seragam', 'price' => 800000]);
        Product::create(['name' => 'Catering', 'price' => 300000]);
        Product::create(['name' => 'Laundry Seragam', 'price' => 50000]);
        Product::create(['name' => 'Syahriyyah SMP', 'price' => 250000]);
        Product::create(['name' => 'Syahriyyah SMK', 'price' => 275000]);
        Product::create(['name' => 'Formal SMP', 'price' => 50000]);
        Product::create(['name' => 'Formal SMK', 'price' => 75000]);
        Product::create(['name' => 'Madin', 'price' => 50000]);
        Product::create(['name' => 'Extra', 'price' => 50000]);
        Product::create(['name' => 'Jurusan', 'price' => 50000]);
        Product::create(['name' => 'Pesantren', 'price' => 50000]);
        Product::create(['name' => 'Kitab', 'price' => 200000]);
        Product::create(['name' => 'Pengadaan Almari', 'price' => 150000]);
        Product::create(['name' => 'Field Trip Tiap Semester', 'price' => 100000]);
    }
}
