<?php

namespace App\Livewire\Law;

use App\Models\Law;
use Livewire\Component;

class Index extends Component
{

    public $laws;

    public function mount()
    {
        $this->formatLawsData();
    }

    public function render()
    {
        return view('livewire.law.index')->title(__('Peraturan & Tata Tertib'));
    }

    private function formatLawsData()
    {
        // Ambil semua data hukum dari database, diurutkan berdasarkan bab, pasal, dan ayat
        $laws = Law::orderBy('chapter')
            ->orderBy('section')
            ->orderBy('article')
            ->get();

        // Inisialisasi array untuk menyimpan data hukum dalam format yang diinginkan
        $formattedLaws = [];

        // Variabel untuk menyimpan data bab, pasal, dan ayat saat iterasi
        $currentChapter = null;
        $currentSection = null;
        $currentArticle = null;

        // Looping melalui setiap data hukum
        foreach ($laws as $law) {
            // Jika bab (chapter) berbeda dari bab saat ini, tambahkan bab baru ke dalam array hasil
            if ($law->chapter != $currentChapter) {
                $currentChapter = $law->chapter;
                $formattedLaws[$currentChapter] = [
                    'chapter' => $currentChapter,
                    'chapter_converted' => $law->chapter_converted,
                    'chapter_title' => $law->chapter_title,
                    'section' => [],
                ];
                $currentSection = null; // Reset section saat berganti chapter
            }

            // Jika pasal (section) berbeda dari pasal saat ini, tambahkan pasal baru ke dalam array hasil
            if ($law->section != $currentSection) {
                $currentSection = $law->section;
                $formattedLaws[$currentChapter]['section'][$currentSection] = [
                    'section' => $law->section,
                    'section_converted' => "PASAL " . $law->section,
                    'section_title' => $law->section_title,
                    'article' => [],
                ];
                $currentArticle = null; // Reset article saat berganti section
            }

            // Format data ayat dan tambahkan ke dalam array hasil
            $formattedLaws[$currentChapter]['section'][$currentSection]['article'][] = [
                'article' => $law->article,
                'article_converted' => "Ayat " . $law->article,
                'content' => $law->content,
                'point' => $law->point,
            ];
        }

        $this->laws = $formattedLaws;
    }
}
