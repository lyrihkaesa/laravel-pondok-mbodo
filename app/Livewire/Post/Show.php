<?php

namespace App\Livewire\Post;

use Livewire\Component;

class Show extends Component
{
    public $slug;
    public $post;

    public function mount($slug): void
    {
        $this->slug = $slug;
        $this->post = \App\Models\Post::query()->where('slug', $this->slug)->first();
    }
    public function render()
    {
        return view('livewire.post.show');
    }
}
