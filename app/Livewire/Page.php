<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PublicPage;
use Illuminate\Http\Request;

class Page extends Component
{
    public $publicPage;

    public function mount(Request $request)
    {
        $this->publicPage = PublicPage::where('path', $request->path())->first();
    }
    public function render()
    {
        if (!$this->publicPage) {
            abort(404);
        }
        return view('livewire.page');
    }
}
