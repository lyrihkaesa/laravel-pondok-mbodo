<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Organization;

class OrganizationShow extends Component
{
    public $slug;

    public function mount($slug): void
    {
        $this->slug = $slug;
    }
    public function render()
    {
        $organization = Organization::where('slug', $this->slug)->first();
        if (!$organization) {
            abort(404);
        }

        return view('livewire.organization-show', [
            'organization' => $organization,
        ]);
    }
}
