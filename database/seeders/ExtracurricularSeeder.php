<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $extracurriculars = [
            [
                'name' => 'Keputrian',
                'slug' => 'keputrian',
                'category' => null,
                'description' => 'Deskripsi keputrian.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi keputrian.',
                'mission' => 'Misi keputrian.',
            ],
            [
                'name' => 'Pramuka',
                'slug' => 'pramuka',
                'category' => null,
                'description' => 'Deskripsi pramuka.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi pramuka.',
                'mission' => 'Misi pramuka.',
            ],
            [
                'name' => 'Baca Kitab Kuning (Syafinah dan Jurmiyah)',
                'slug' => 'baca-kitab-kuning',
                'category' => null,
                'description' => 'Deskripsi baca kitab kuning.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi baca kitab kuning.',
                'mission' => 'Misi baca kitab kuning.',
            ],
            [
                'name' => 'Tata Busana',
                'slug' => 'tata-busana',
                'category' => null,
                'description' => 'Deskripsi tata busana.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi tata busana.',
                'mission' => 'Misi tata busana.',
            ],
            [
                'name' => 'Belajar Al-Barjanji',
                'slug' => 'belajar-al-barjanji',
                'category' => null,
                'description' => 'Deskripsi belajar al-barjanji.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi belajar al-barjanji.',
                'mission' => 'Misi belajar al-barjanji.',
            ],
            [
                'name' => 'Tashrifan (Sharaf)',
                'slug' => 'tashrifan',
                'category' => null,
                'description' => 'Deskripsi tashrifan (sharaf).',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi tashrifan (sharaf).',
                'mission' => 'Misi tashrifan (sharaf).',
            ],
            [
                'name' => 'Volly Ball (Olahraga)',
                'slug' => 'volly-ball',
                'category' => 'Olahraga',
                'description' => 'Deskripsi volly ball.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi volly ball.',
                'mission' => 'Misi volly ball.',
            ],
            [
                'name' => 'Bulu Tangkis (Olahraga)',
                'slug' => 'bulu-tangkis',
                'category' => 'Olahraga',
                'description' => 'Deskripsi bulu tangkis.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi bulu tangkis.',
                'mission' => 'Misi bulu tangkis.',
            ],
            [
                'name' => 'Senam (Olahraga)',
                'slug' => 'senam',
                'category' => 'Olahraga',
                'description' => 'Deskripsi senam.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi senam.',
                'mission' => 'Misi senam.',
            ],
            [
                'name' => 'Desain Grafis',
                'slug' => 'desain-grafis',
                'category' => 'Seni',
                'description' => 'Deskripsi desain grafis.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi desain grafis.',
                'mission' => 'Misi desain grafis.',
            ],
            [
                'name' => 'Edit Video',
                'slug' => 'edit-video',
                'category' => 'Seni',
                'description' => 'Deskripsi edit video.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi edit video.',
                'mission' => 'Misi edit video.',
            ],
            [
                'name' => 'Holtikultura',
                'slug' => 'holtikultura',
                'category' => 'Pertanian',
                'description' => 'Deskripsi holtikultura.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi holtikultura.',
                'mission' => 'Misi holtikultura.',
            ],
            [
                'name' => 'Tari Sufi',
                'slug' => 'tari-sufi',
                'category' => 'Seni',
                'description' => 'Deskripsi tari sufi.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi tari sufi.',
                'mission' => 'Misi tari sufi.',
            ],
            [
                'name' => 'Pencak Silat',
                'slug' => 'pencak-silat',
                'category' => 'Olahraga',
                'description' => 'Deskripsi pencak silat.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi pencak silat.',
                'mission' => 'Misi pencak silat.',
            ],
            [
                'name' => 'Musik Modern',
                'slug' => 'musik-modern',
                'category' => 'Seni',
                'description' => 'Deskripsi musik modern.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi musik modern.',
                'mission' => 'Misi musik modern.',
            ],
            [
                'name' => 'Tata Boga',
                'slug' => 'tata-boga',
                'category' => 'Seni',
                'description' => 'Deskripsi tata boga.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi tata boga.',
                'mission' => 'Misi tata boga.',
            ],
            [
                'name' => 'Kaligrafi',
                'slug' => 'kaligrafi',
                'category' => 'Seni',
                'description' => 'Deskripsi kaligrafi.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi kaligrafi.',
                'mission' => 'Misi kaligrafi.',
            ],
            [
                'name' => 'Membatik',
                'slug' => 'memebatik',
                'category' => 'Seni',
                'description' => 'Deskripsi membatik.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi membatik.',
                'mission' => 'Misi membatik.',
            ],
            [
                'name' => 'Drumband',
                'slug' => 'drumband',
                'category' => 'Seni',
                'description' => 'Deskripsi drumband.',
                'thumbnail' => 'extracurriculars/thumbnails/default.jpg',
                'vision' => 'Visi drumband.',
                'mission' => 'Misi drumband.',
            ],
        ];

        Extracurricular::insert($extracurriculars);
    }
}
