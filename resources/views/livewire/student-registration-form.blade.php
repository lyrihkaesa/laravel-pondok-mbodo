<x-slot name="header">
    <x-ppdb.header />
</x-slot>

<x-slot name="css">
    @filamentStyles()
    @vite('resources/css/filament/admin/theme.css')
</x-slot>

<x-slot name="script">
    @filamentScripts()
</x-slot>

<div class="mx-auto max-w-[85rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-4">
    <h1 class="mb-4 text-lg font-semibold">Pendaftaran Santri</h1>
    <form wire:submit="create">
        {{ $this->form }}

        <div class="my-4">
            <x-filament::button type="submit" class="w-full" size="lg">
                Daftar
            </x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
