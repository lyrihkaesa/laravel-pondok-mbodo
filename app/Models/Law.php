<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter',
        'chapter_title',
        'section',
        'section_title',
        'article',
        'content',
        'point',
    ];

    // Atribut gabungan untuk bab
    public function getChapterDetailsAttribute()
    {
        return "BAB {$this->convertToRoman($this->chapter)} {$this->chapter_title}";
    }

    public function getChapterConvertedAttribute()
    {
        return "BAB {$this->convertToRoman($this->chapter)}";
    }

    public function getSectionDetailsAttribute()
    {
        return "Pasal {$this->section} {$this->section_title}";
    }

    public function getArticleDetailsAttribute()
    {
        return "Ayat {$this->article}";
    }

    public function getLawShortDetailsAttribute()
    {
        return "BAB {$this->convertToRoman($this->chapter)} Pasal {$this->section} Ayat {$this->article}";
    }

    public function getLawDetailsAttribute()
    {
        return [
            $this->getChapterDetailsAttribute(),
            $this->getSectionDetailsAttribute(),
            $this->getArticleDetailsAttribute(),
        ];
    }

    // Fungsi untuk mengonversi angka Arab menjadi angka Romawi
    private function convertToRoman($number)
    {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];
        $result = '';

        foreach ($map as $roman => $arabic) {
            $matches = intval($number / $arabic);
            $result .= str_repeat($roman, $matches);
            $number %= $arabic;
        }

        return $result;
    }
}
