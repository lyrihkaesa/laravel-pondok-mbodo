<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Index extends Component
{
    public function getPostsProperty()
    {
        return Post::with('author', 'editor')->isPublished()->orderBy('published_at', 'desc')->paginate(10); // default 15
    }
    public function render()
    {
        return view('livewire.post.index')->title(__('Blog'));
    }
}
