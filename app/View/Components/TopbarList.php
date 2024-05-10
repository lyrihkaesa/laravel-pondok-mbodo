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
                'href' => '#',
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
                'href' => '#',
                'slot' => 'icon-facebook',
            ],
            [
                'type' => 'icon',
                'href' => '#',
                'slot' => 'icon-instagram',
            ],
            [
                'type' => 'icon',
                'href' => '#',
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
