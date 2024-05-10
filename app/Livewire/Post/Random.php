<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Random extends Component
{
    public function getRandomPostsProperty()
    {
        return Post::query()->isPublished()->inRandomOrder()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.post.random');
    }
}
