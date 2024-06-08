<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Form;
use Livewire\Attributes\Computed;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;

class Calendar extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calendarIds')
                    ->label(__('Calendar'))
                    ->options(
                        $this->calendars
                            ->mapWithKeys(function ($calendar) {
                                return [$calendar->id => $calendar->name . ' - ' . str($calendar->visibility->value)->upper()];
                            })
                            ->toArray()
                    )
                    ->multiple()
                    ->default($this->calendars->where('visibility', \App\Enums\SocialMediaVisibility::PUBLIC)->pluck('id')->toArray()),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $this->data = $this->form->getState();
    }

    #[Computed()]
    public function calendars(): Collection
    {
        return \App\Models\Calendar::where('user_id', auth()->id())
            ->orWhere('visibility', \App\Enums\SocialMediaVisibility::PUBLIC)
            ->get();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
