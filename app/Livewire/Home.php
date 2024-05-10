<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Home extends Component
{
    public $posts = [];

    public function mount()
    {
        $this->posts = Post::treeLastPublished()->get();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
