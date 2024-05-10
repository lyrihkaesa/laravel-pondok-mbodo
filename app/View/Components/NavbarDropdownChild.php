<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavbarDropdownChild extends Component
{
    public $label;
    /**
     * Create a new component instance.
     */
    public function __construct($label = null)
    {
        $this->label = $label ?? 'Navbar Dropdown Child';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar.dropdown.child');
    }
}
