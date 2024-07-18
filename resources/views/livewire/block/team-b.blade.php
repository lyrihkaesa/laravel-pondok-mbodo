{{-- Contact --}}
<section class="{{ $bgColorClass }} mx-auto max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
    @isset($title)
        <!-- Title -->
        <div class="mx-auto mb-5 max-w-2xl text-center lg:mb-10">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">{{ $title }}</h2>
            @isset($description)
                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $description }}</p>
            @endisset
        </div>
        <!-- End Title -->
    @endisset

    @php
        $user = auth()->user();
    @endphp

    <!-- Grid -->
    <div class="grid grid-cols-2 gap-8 md:grid-cols-3 md:gap-12">
        @foreach ($this->members as $member)
            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl"
                    src="{{ $member->profile_picture_1x1 ? Storage::disk(config('filament.default_filesystem_disk'))->url($member->profile_picture_1x1) : asset('images\thumbnails\images-dark.webp') }}"
                    alt="{{ $member->name }}">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        {{ $member->name }}
                    </h3>
                    @if (
                        $member->phone_visibility->value === 'public' ||
                            ($member->phone_visibility->value === 'member' && $user) ||
                            ($member->phone_visibility->value === 'private' && $user?->hasRole('pengurus')))
                        <div class="flex justify-center gap-3" x-data="{
                            isCopy: false,
                            copy: function() {
                                navigator.clipboard.writeText({{ $member->phone }});
                                this.isCopy = true;
                            },
                        }">
                            <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                                {{ $member->phone }}
                            </p>
                            @if ($member->phone !== '')
                                <div class="flex items-center justify-end gap-1 text-amber-400">
                                    <x-filament::icon-button icon="icon-whatsapp" tooltip="Whatsapp" size="lg"
                                        href="https://wa.me/{{ $member->phone }}?text={{ rawurlencode('Asslaualaikum') }}"
                                        tag="a" target="_blank" />
                                    <x-filament::icon-button x-cloak x-show="!isCopy" tooltip="Salin Nomor"
                                        size="lg" icon="heroicon-m-clipboard-document" x-data
                                        x-on:click="copy();" />
                                    <x-filament::icon-button x-cloak x-show="isCopy" tooltip="Nomor Tersalin"
                                        size="lg" icon="heroicon-m-clipboard-document-check" x-data
                                        x-on:click="copy();" />
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <!-- End Col -->
        @endforeach
    </div>
    <!-- End Grid -->
</section>
{{-- End-Contact --}}
