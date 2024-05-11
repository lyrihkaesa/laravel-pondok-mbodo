<?php

namespace App\Livewire;

use App\Models\PublicPage;
use Livewire\Component;

class Home extends Component
{
    public $publicPage;

    public function mount()
    {
        $this->publicPage = PublicPage::where('slug', 'home')->first();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
