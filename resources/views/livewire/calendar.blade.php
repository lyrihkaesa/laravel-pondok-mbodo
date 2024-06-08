<div>
    <form wire:submit="submit">
        {{ $this->form }}

        <div class="flex items-center justify-end pt-4">
            <x-filament::button type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('Save') }}</span>
                <x-filament::loading-indicator wire:loading class="h-5 w-5" />
                <span wire:loading>{{ __('Save...') }}</span>
            </x-filament::button>
        </div>
    </form>
    <div class="mt-6">
        @livewire(
            \App\Filament\Pages\Calendar\Widgets\CalendarWidget::class,
            [
                'selectedCalendarIds' => $this->data['calendarIds'],
            ],
            key(str()->random())
        )
    </div>
</div>
