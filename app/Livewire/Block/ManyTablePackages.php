<?php

namespace App\Livewire\Block;

use Livewire\Component;
use Livewire\Attributes\Computed;

class ManyTablePackages extends Component
{
    protected $packageIds;
    public $bgColorClass;
    public $title;
    public $description;

    public function mount($iteration = 1, $packageIds = [], $title = null, $description = null)
    {
        $this->packageIds = $packageIds;
        $this->title = $title;
        $this->description = $description;
        $this->bgColorClass = \App\Utilities\TailwindUtility::getBackgroundClass($iteration);
    }

    #[Computed()]
    public function packages()
    {
        return \App\Models\Package::query()
            ->whereIn('id', $this->packageIds)
            ->orderByRaw("array_position(ARRAY[" . implode(',', $this->packageIds) . "], id)")
            ->get();
    }

    public function render()
    {
        return view('livewire.block.many-table-packages');
    }
}
