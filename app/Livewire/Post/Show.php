<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Computed;

class Show extends Component
{
    public $slug;

    public function mount($slug): void
    {
        $this->slug = $slug;
    }

    #[Computed()]
    public function post()
    {
        return  \App\Models\Post::query()->with(['author', 'editor'])->where('slug', $this->slug)->first();
    }

    public function render()
    {
        return view('livewire.post.show');
    }
}
