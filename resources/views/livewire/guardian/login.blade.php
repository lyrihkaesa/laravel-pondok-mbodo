@push('styles')
    @filamentStyles
    @vite('resources/css/filament/app/theme.css')
@endpush

@push('scripts')
    @filamentScripts
@endpush

<section class="mx-auto max-w-[85rem] px-4 py-4 sm:flex sm:justify-center sm:px-6 sm:py-6 lg:px-8 lg:py-8">
    <div class="sm:min-w-96 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Portal Orang Tua</h1>
            </div>

            <div class="mt-4 md:mt-6">
                <form wire:submit="viewProfileStudent">
                    {{ $this->form }}

                    <x-filament::button type="submit" class="mt-4 w-full md:mt-6 lg:mt-8" size="lg"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __('View Profile Student') }}</span>
                        <x-filament::loading-indicator wire:loading class="h-5 w-5" />
                        <span wire:loading>{{ __('View Profile Student...') }}</span>
                    </x-filament::button>
                </form>
            </div>
        </div>
    </div>
</section>
