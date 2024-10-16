<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopbarList extends Component
{
    public $items;
    public $yayasan;

    /**
     * Create a new component instance.
     */
    public function __construct($items = null)
    {
        $this->yayasan = cache()->remember('yayasan_pondok_mbodo', 3600, function () {
            return \App\Models\Organization::query()
                ->with('socialMediaLinks')
                ->where('category', 'Yayasan')
                ->get()
                ->first();
        });
        $this->items = $items ?? [
            [
                'type' => 'link',
                'href' => route('guardian.login'),
                'slot' => 'Orang Tua',
            ],
            [
                'type' => 'link',
                'href' => route('filament.app.pages.dashboard'),
                'slot' => 'Pengurus',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (isset($this->yayasan)) {
            if ($this->yayasan->socialMediaLinks->isNotEmpty()) {
                $this->items[] = [
                    'type' => 'h-divinder',
                    'slot' => '|',
                ];

                foreach ($this->yayasan->socialMediaLinks as $socialMediaLink) {
                    $this->items[] = [
                        'type' => 'icon',
                        'href' => $socialMediaLink->url,
                        'slot' => $socialMediaLink->platform->getIcon(),
                    ];
                }
            }
        }
        return view('components.topbar.list');
    }
}
