<x-filament-panels::page>
    <x-filament-panels::form wire:submit="updateStudent">
        {{ $this->editStudentForm }}
        <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdateStudentFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updateStudent" class="h-5 w-5" />
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
