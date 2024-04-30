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

        <x-filament::section aside collapsible class="my-4 lg:my-6">
            <x-slot name="heading">
                {{ __('Other') }}
            </x-slot>
            <h1 class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                {{ __('Registration Requirement') }}</h1>
            <ul class="mt-1 list-decimal px-4 text-sm text-gray-500 dark:text-gray-400">
                <li>Tiga lembar Fotocopy Kartu Keluarga</li>
                <li>Tiga lembar Fotocopy Akta Kelahiran</li>
                <li>Tiga lembar Fotocopy SKHUN Terlegalisir</li>
                <li>Tiga lembar Fotocopy Ijazah Terlegalisir</li>
                <li>Tiga lembar Fotocopy KTP Orang Tua/Wali</li>
                <li>Tiga lembar Pass Foto Berwarna 3x4</li>
                <li>Tiga lembar Pass Foto Berwarna 2x3</li>
            </ul>
            <hr class="my-4 border-gray-200 dark:border-gray-700">
            <h1 class="text-base font-medium leading-6 text-gray-950 dark:text-white">
                {{ __('Registration Contact') }}
            </h1>
            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                <p>Syarat pendaftaran bisa dibawa saat mengantar santri ke pesantren. Setelah mengisi formulir
                    pendaftaran online, harap konfirmasi ke salah satu nomor: </p>
                <x-item-wa-copy-button name="Mbak Yani" phone="6282136687558"
                    message="Assalamualaikum Wr. Wb. Mbak Yani. Saya ingin konsultasi pendaftaran santri baru." />
                <x-item-wa-copy-button name="Mbak Ulfa" phone="6282134125855"
                    message="Assalamualaikum Wr. Wb. Mbak Ulfa. Saya ingin konsultasi pendaftaran santri baru." />
            </div>
        </x-filament::section>

        <x-filament::section aside class="my-4 lg:my-6">
            <x-slot name="heading">

            </x-slot>
            <x-filament::button type="submit" class="w-full" size="lg" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('Register') }}</span>
                <x-filament::loading-indicator wire:loading class="h-5 w-5" />
                <span wire:loading>{{ __('Registering...') }}</span>
            </x-filament::button>
        </x-filament::section>

    </form>

    <x-filament-actions::modals />

    <x-filament::modal alignment="center"
        icon="{{ $this->isSuccessful ? 'heroicon-o-check-badge' : 'heroicon-o-exclamation-triangle' }}"
        icon-color="{{ $this->isSuccessful ? 'success' : 'danger' }}" id="final-create-student">
        <x-slot name="heading">
            {{ $this->isSuccessful ? __('Student Register Success') : __('Student Register Failed') }}
        </x-slot>
        <x-slot name="description">
            {{ $this->isSuccessful ? __('Student Register Success Message') : __('Student Register Failed Message') }}
        </x-slot>
        {{-- Modal content --}}
        <span class="yb-4"></span>
    </x-filament::modal>
</div>
