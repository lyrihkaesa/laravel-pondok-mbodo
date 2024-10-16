<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PublicPage;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;

class Page extends Component
{
    public $path;

    public function mount(Request $request)
    {
        $this->path = $request->path();
    }

    #[Computed()]
    public function publicPage()
    {
        return PublicPage::where('path', $this->path)->first();
    }

    public function render()
    {
        if (!$this->publicPage) {
            abort(404);
        }

        return view('livewire.page')->title($this->publicPage->title);
    }
}
