<?php

namespace App\Livewire\Block;

use Livewire\Component;

class TeamB extends Component
{
    protected $membersIds;
    public $members = [];
    public $title;
    public $description;
    public $iteration;

    public function mount($memberIds = [], $title = null, $description = null, $iteration = 1)
    {
        $this->membersIds = $memberIds;
        $this->title = $title;
        $this->description = $description;
        $this->iteration = $iteration;
        $this->members = \App\Models\User::query()
            ->whereIn('id', $this->membersIds)
            ->select('name', 'phone', 'phone_visibility')
            ->get();
    }
    public function render()
    {
        return view('livewire.block.team-b');
    }
}
