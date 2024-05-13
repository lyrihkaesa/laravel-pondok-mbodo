<x-filament-panels::page>
    <x-filament-panels::form wire:submit="updateProfile">
        {{ $this->editProfileForm }}
        <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdateProfileFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updateProfile" class="h-5 w-5" />
        </div>
    </x-filament-panels::form>
    <x-filament-panels::form wire:submit="updatePassword">
        {{ $this->editPasswordForm }}
        <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdatePasswordFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updatePassword" class="h-5 w-5" />
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
