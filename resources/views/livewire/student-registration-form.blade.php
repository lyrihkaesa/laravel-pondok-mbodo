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

        <x-filament::section aside class="my-4 lg:my-6">
            <x-slot name="heading">

            </x-slot>
            <x-filament::button type="submit" class="w-full" size="lg" wire:loading.attr="disabled">
                <span wire:loading.remove>Daftar</span>
                <span wire:loading>Proses Mendaftar...</span>
            </x-filament::button>
        </x-filament::section>

    </form>

    <x-filament-actions::modals />

    <x-filament::modal alignment="center"
        icon="{{ $this->isSuccessful ? 'heroicon-o-check-badge' : 'heroicon-o-exclamation-triangle' }}"
        icon-color="{{ $this->isSuccessful ? 'success' : 'danger' }}" id="final-create-student">
        <x-slot name="heading">
            {{ $this->isSuccessful ? 'Pendaftaran Berhasil' : 'Pendaftaran Gagal' }}
        </x-slot>
        <x-slot name="description">
            {{ $this->isSuccessful ? 'Tunggu konfirmasi dari petugas pendaftaran, yaa. 😊' : 'Pastikan data yang dimasukan benar dan daftar lagi nanti, jika masih gagal silahkan kosultasikan ke petugas pendaftaran. 😢' }}
        </x-slot>
        {{-- Modal content --}}
        <span class="yb-4"></span>
    </x-filament::modal>
</div>
