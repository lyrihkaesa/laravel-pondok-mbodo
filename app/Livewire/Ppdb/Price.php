<?php

namespace App\Livewire\Ppdb;

use App\Models\Package;
use Livewire\Component;

class Price extends Component
{
    public $packages;
    public function mount()
    {
        $this->packages = Package::with('products')->get();
    }
    public function render()
    {
        return view('livewire.ppdb.price');
    }
}
