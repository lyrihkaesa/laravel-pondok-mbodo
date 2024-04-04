<?php

namespace Database\Seeders;

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
            ['name' => 'Pendaftaran PAUD Putra', 'product_names' => [
                'Pendaftaran PAUD',
                'SPP PAUD',
                'Seragam Olahraga PAUD Putra',
                'Seragam Putih Biru PAUD Putra',
                'Seragam Batik PAUD Putra',
            ]],
            ['name' => 'Pendaftaran PAUD Putri', 'product_names' => [
                'Pendaftaran PAUD',
                'SPP PAUD',
                'Seragam Olahraga PAUD Putri',
                'Seragam Putih Biru PAUD Putri',
                'Seragam Batik PAUD Putri',
            ]],
            ['name' => 'Pendaftaran MI Putra', 'product_names' => [
                'Pendaftaran MI',
                'SPP MI',
                'Seragam Merah Putih MI Putra',
                'Seragam Batik MI Putra/i',
                'Seragam Pramuka MI Putra/i',
                'Seragam Olahraga MI Putra/i',
            ]],
            ['name' => 'Pendaftaran MI Putri', 'product_names' => [
                'Pendaftaran MI',
                'SPP MI',
                'Seragam Merah Putih MI Putri',
                'Seragam Batik MI Putra/i',
                'Seragam Pramuka MI Putra/i',
                'Seragam Olahraga MI Putra/i',
            ]],
            ['name' => 'Pendaftaran SMP', 'product_names' => [
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
            ]],
            ['name' => 'Pendaftaran MA', 'product_names' => [
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
            ]],
        ];

        // Insert the packages
        foreach ($packages as $packageData) {
            $package = Package::create(['name' => $packageData['name']]);
            foreach ($packageData['product_names'] as $productName) {
                $product = Product::where('name', $productName)->first();
                if ($product) {
                    $package->products()->attach($product->id);
                }
            }
        }
    }
}
