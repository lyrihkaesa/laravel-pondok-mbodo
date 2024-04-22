<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Organization;

class OrganizationShow extends Component
{
    public $slug;
    public $organization;

    public function mount($slug): void
    {
        $this->slug = $slug;
        $this->organization = Organization::where('slug', $this->slug)->first();
    }
    public function render()
    {
        if (!$this->organization) {
            abort(404);
        }

        return view('livewire.organization-show');
    }
}
