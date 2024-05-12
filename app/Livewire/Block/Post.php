<?php

namespace App\Livewire\Block;

use Livewire\Component;

class Post extends Component
{
    public $posts = [];
    public $take;
    public $title;
    public $description;
    public $bgColorClass;

    public function mount($take = 3, $title = null, $description = null, $iteration = 1)
    {
        $this->take = $take;
        $this->title = $title;
        $this->description = $description;
        $this->bgColorClass = \App\Utilities\TailwindUtility::getBackgroundClass($iteration);
        $this->posts = \App\Models\Post::isPublished()->inRandomOrder()
            ->take($this->take)->get();
    }
    public function render()
    {
        return view('livewire.block.post');
    }
}
