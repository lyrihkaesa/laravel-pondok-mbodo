<?php

namespace App\Livewire\Block;

use Livewire\Component;

class TeamC extends Component
{
    protected $membersIds;
    public $members = [];
    public $title;
    public $description;
    public $whatsappMessage;

    public function mount($memberIds = [], $title = null, $description = null, $whatsappMessage = '')
    {
        $this->membersIds = $memberIds;
        $this->title = $title;
        $this->description = $description;
        $this->whatsappMessage = $whatsappMessage;
        $this->members = \App\Models\User::query()
            ->whereIn('id', $this->membersIds)
            ->select('id', 'name', 'phone', 'phone_visibility', 'profile_picture_1x1',)
            ->orderByRaw("array_position(ARRAY[" . implode(',', $this->membersIds) . "], id)")
            ->get();
    }
    public function render()
    {
        return view('livewire.block.team-c');
    }
}
