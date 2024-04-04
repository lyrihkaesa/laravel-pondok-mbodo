<?php

namespace App\Livewire\Ppdb;

use App\Models\Package;
use Livewire\Component;

class Price extends Component
{
    public function render()
    {
        $packages = Package::with('products')->get();

        return view('livewire.ppdb.price', [
            'packages' => $packages,
        ]);
    }
}
