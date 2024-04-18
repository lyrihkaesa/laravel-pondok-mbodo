<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Biaya Pendidikan',
                'slug' => 'biaya-pendidikan',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket yang akan ditampilkan pada biaya pendidikan.',
                'is_active' => true,
                'type' => 'paket, produk',
            ],
            [
                'name' => 'Santri Reguler',
                'slug' => 'santri-reguler',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket atau jenis product mana yang akan direlasikan ke santri reguler.',
                'is_active' => true,
                'type' => 'paket, santri',
            ],
            [
                'name' => 'Santri Ndalem',
                'slug' => 'santri-ndalem',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket atau jenis product mana yang akan direlasikan ke santri ndalem.',
                'is_active' => true,
                'type' => 'paket, santri',
            ],
            [
                'name' => 'Santri Berprestasi',
                'slug' => 'santri-berprestasi',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket atau jenis product mana yang akan direlasikan ke santri berprestasi.',
                'is_active' => true,
                'type' => 'paket, santri',
            ],
            [
                'name' => 'PAUD/TK',
                'slug' => 'paud-tk',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket berdasarkan sekolah dari santri.',
                'is_active' => true,
                'type' => 'paket, santri, sekolah',
            ],
            [
                'name' => 'MI',
                'slug' => 'mi',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket berdasarkan sekolah dari santri.',
                'is_active' => true,
                'type' => 'paket, santri, sekolah',
            ],
            [
                'name' => 'SMP',
                'slug' => 'smp',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket berdasarkan sekolah dari santri.',
                'is_active' => true,
                'type' => 'paket, santri, sekolah',
            ],
            [
                'name' => 'MA',
                'slug' => 'ma',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket berdasarkan sekolah dari santri.',
                'is_active' => true,
                'type' => 'paket, santri, sekolah',
            ],
            [
                'name' => 'Takhasus',
                'slug' => 'takhasus',
                'description' => 'Jangan dihapus, ini digunakan untuk filter paket berdasarkan sekolah dari santri.',
                'is_active' => true,
                'type' => 'paket, santri, sekolah',
            ],
        ]);
    }
}
