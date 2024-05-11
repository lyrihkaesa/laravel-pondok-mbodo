<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PublicPage;
use Livewire\Component;

class Home extends Component
{
    public $posts = [];
    public $publicPage;

    public function mount()
    {
        $this->posts = Post::treeLastPublished()->get();
        $this->publicPage = PublicPage::where('slug', 'home')->first();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
