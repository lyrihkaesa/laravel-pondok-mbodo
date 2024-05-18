<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopbarList extends Component
{
    public $items;

    /**
     * Create a new component instance.
     */
    public function __construct($items = null)
    {
        $this->items = $items ?? [
            [
                'type' => 'link',
                'href' => route('guardian.login'),
                'slot' => 'Orang Tua',
            ],
            [
                'type' => 'link',
                'href' => route('filament.admin.pages.dashboard'),
                'slot' => 'Pengurus',
            ],
            [
                'type' => 'h-divinder',
                'slot' => '|',
            ],
            [
                'type' => 'icon',
                'href' => 'https://www.facebook.com/profile.php?id=100010159720610',
                'slot' => 'icon-facebook',
            ],
            [
                'type' => 'icon',
                'href' => 'https://www.instagram.com/pondokmbodo/',
                'slot' => 'icon-instagram',
            ],
            [
                'type' => 'icon',
                'href' => 'https://www.youtube.com/@pondokmbodochannel1385',
                'slot' => 'icon-youtube',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.topbar.list');
    }
}
