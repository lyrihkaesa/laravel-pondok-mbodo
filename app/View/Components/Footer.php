<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $organizations;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->organizations = cache()->remember('navbar_footer_organizations', 3600, function () {
            return \App\Models\Organization::query()
                ->select(['name', 'slug', 'category'])
                ->whereIn('category', ['Sekolah Formal', 'Program Jurusan', 'Sekolah Madrasah', 'Badan Lembaga'])
                ->get()
                ->groupBy('category');
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer.index');
    }
}
