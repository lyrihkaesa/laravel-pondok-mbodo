<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PublicPage;

class About extends Component
{
    public $publicPage;

    public function mount()
    {
        $this->publicPage = PublicPage::where('slug', 'about')->first();
    }
    public function render()
    {
        return view('livewire.about');
    }
}
