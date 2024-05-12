<?php

namespace App\Livewire\Block;

use Livewire\Component;

class TeamB extends Component
{
    protected $membersIds;
    public $members = [];
    public $title;
    public $description;
    public $bgColorClass;

    public function mount($memberIds = [], $title = null, $description = null, $iteration = 1)
    {
        $this->membersIds = $memberIds;
        $this->title = $title;
        $this->description = $description;
        $this->bgColorClass = \App\Utilities\TailwindUtility::getBackgroundClass($iteration);
        $this->members = \App\Models\User::query()
            ->whereIn('id', $this->membersIds)
            ->select('name', 'phone', 'phone_visibility', 'profile_picture_1x1',)
            ->orderByRaw("array_position(ARRAY[" . implode(',', $this->membersIds) . "], id)")
            ->get();
    }
    public function render()
    {
        return view('livewire.block.team-b');
    }
}
