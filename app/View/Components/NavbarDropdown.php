<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavbarDropdown extends Component
{
    public $label;
    /**
     * Create a new component instance.
     */
    public function __construct($label = null)
    {
        $this->label = $label ?? 'Navbar Dropdown';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar.dropdown.index');
    }
}
