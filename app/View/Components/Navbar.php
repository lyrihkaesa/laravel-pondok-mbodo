<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $organizations;
    /**
     * Create a new component instance.
     */
    public function __construct($organizations = null)
    {
        $this->organizations = $organizations ?? [
            "formals" => [
                [
                    'href' => route('organizations.show', ['slug' => 'paudtk']),
                    'slot' => 'Paud Quran Al Hawi'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'misd']),
                    'slot' => 'Madrasah Ibtidiyah (SD)'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'smp-islam-al-hawi']),
                    'slot' => 'SMP Islam Al Hawi'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'madrasah-aliyah-plus-islam-al-hawi']),
                    'slot' => 'Madrasah Aliyah Plus Islam Al Hawi'
                ],
            ],
            "non_formals" => [
                [
                    'href' => route('organizations.show', ['slug' => 'pesantren-putra']),
                    'slot' => 'Pesantren Putra'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'pesantren-putri']),
                    'slot' => 'Pesantren Putri'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'pesantren-tahfidzul-quran-putri']),
                    'slot' => 'Pesantren Tahfidzul Quran Putri'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'jurusan-mahir-kitab']),
                    'slot' => 'Jurusan Mahir Kitab'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'jurusan-tahsin-quran']),
                    'slot' => 'Jurusan Tahsin Quran'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'jurusan-suwuk']),
                    'slot' => 'Jurusan Suwuk'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'madarasah-wustho']),
                    'slot' => 'Madarasah Wustho'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'madarasah-ulya']),
                    'slot' => 'Madarasah Ulya'
                ],
            ],
            "lembagas" => [
                [
                    'href' => route('organizations.show', ['slug' => 'majelis-lapanan-ahad-kliwon-jimad-sholawat']),
                    'slot' => 'Majelis Lapanan Ahad Kliwon Jimad Sholawat'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'jamiyah-thoriqoh-qodiriyah-al-jaelaniyah']),
                    'slot' => 'Jamiyah Thoriqoh Qodiriyah Al Jaelaniyah'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'langit-tour']),
                    'slot' => 'Langit Tour'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'taman-suwuk-nusantara']),
                    'slot' => 'Taman Suwuk Nusantara'
                ],
                [
                    'href' => route('organizations.show', ['slug' => 'padepokan-satrio-mbodo']),
                    'slot' => 'Padepokan Satrio Mbodo'
                ],
            ]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar.index');
    }
}
