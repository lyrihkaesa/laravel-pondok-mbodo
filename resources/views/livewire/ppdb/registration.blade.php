@push('styles')
    @filamentStyles
    @vite('resources/css/filament/admin/theme.css')
    @vite('resources/css/markdown.css')
@endpush

@push('scripts')
    @filamentScripts
@endpush

<div class="mx-auto max-w-[85rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-4">
    <h1 class="mb-4 text-lg font-semibold">Pendaftaran Santri</h1>
    <form wire:submit="create">
        {{ $this->form }}
        @isset($publicPage)
            @foreach ($publicPage->content as $block)
                @if ($block['type'] === 'filament-section')
                    <x-filament::section :aside="$block['data']['aside']" :collapsible="$block['data']['collapsible']" class="my-4 lg:my-6">
                        @isset($block['data']['section_heading'])
                            <x-slot name="heading">
                                {{ $block['data']['section_heading'] }}
                            </x-slot>
                        @endisset
                        @isset($block['data']['body'])
                            @foreach ($block['data']['body'] as $blockBody)
                                @if ($blockBody['type'] === 'markdown')
                                    <div class="markdown filament-section-body">
                                        {!! str($blockBody['data']['content'])->markdown() !!}
                                    </div>
                                @elseif ($blockBody['type'] === 'team-c')
                                    <livewire:block.team-c :title="$blockBody['data']['title']" :description="$blockBody['data']['description']" :memberIds="$blockBody['data']['member_id']"
                                        :whatsappMessage="$blockBody['data']['whatsapp_message']" />
                                @endif

                                @if (!$loop->last && $block['data']['divinder'])
                                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="my-4"></div>
                                @endif
                            @endforeach
                        @endisset
                    </x-filament::section>
                @endif
            @endforeach
        @endisset
        <x-filament::section aside class="my-4 lg:my-6" id="section-submit">
            <x-slot name="heading">{{ __('Register') }}</x-slot>
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
