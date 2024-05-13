<x-filament-panels::page>
    <x-filament-panels::form wire:submit="updateEmployee">
        {{ $this->editEmployeeForm }}
        <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdateEmployeeFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updateEmployee" class="h-5 w-5" />
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
