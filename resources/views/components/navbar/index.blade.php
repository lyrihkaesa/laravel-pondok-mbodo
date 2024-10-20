@php
    $user = auth('web')->user();
@endphp

{{-- Navbar --}}
<nav @if (!(request()->is('ppdb*') || request()->is('blog/*'))) x-cloak x-data :class="{ 'backdrop-blur bg-white/75 dark:bg-gray-800/75 ': isScrolled }" @endif
    class="mx-auto w-full max-w-[85rem] border-b-2 border-gray-100 bg-white px-4 py-2 transition-colors duration-500 dark:border-gray-700 dark:bg-gray-800 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8"
    aria-label="Global">
    <div class="flex items-center justify-between">
        <a href="/" class="inline-flex items-center gap-x-2 font-semibold dark:text-white">
            <img class="h-auto w-10" src="/favicon-150x150.png" alt="Logo">
            <span class="whitespace-nowrap text-base sm:text-xl">Pondok Mbodo</span>
        </a>
        <div class="flex items-center justify-end gap-4 sm:hidden">
            <button type="button"
                class="hs-collapse-toggle inline-flex items-center justify-center gap-x-2 rounded-lg border border-gray-200 bg-white p-2 text-gray-800 shadow-sm hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-transparent dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                data-hs-collapse="#navbar-image-and-text-2" aria-controls="navbar-image-and-text-2"
                aria-label="Toggle navigation">
                <svg class="size-4 flex-shrink-0 hs-collapse-open:hidden" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg class="size-4 hidden flex-shrink-0 hs-collapse-open:block" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
            <x-dark-mode-button />
            @if (!request()->is('ppdb'))
                @auth
                    <a href="{{ route('filament.app.pages.dashboard') }}">
                        <x-filament::avatar src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" />
                    </a>
                @else
                    <x-ppdb-button class="inline-flex" />
                @endauth
            @endif
        </div>
    </div>
    <div class="flex items-center justify-end gap-4">
        <div id="navbar-image-and-text-2"
            class="hs-collapse hidden grow basis-full overflow-hidden transition-all duration-300 sm:block">
            <div class="mt-5 flex flex-col gap-5 sm:mt-0 sm:flex-row sm:items-center sm:justify-end sm:ps-5">
                @if (!request()->is('ppdb/*') && !request()->is('ppdb'))
                    <x-navbar-link href="{{ route('about') }}">Profile Pondok</x-navbar-link>
                @endif
                @if (request()->is('ppdb/*') || request()->is('ppdb'))
                    <x-navbar-link href="{{ route('ppdb.price') }}">Biaya Pendidikan</x-navbar-link>
                @endif
                <x-navbar-dropdown label="Informasi">
                    <x-navbar-dropdown-item href="{{ route('posts.index') }}">Pawarto</x-navbar-dropdown-item>
                    <x-navbar-dropdown-item href="{{ route('law.index') }}">Peraturan (Tata
                        Tertib)</x-navbar-dropdown-item>
                </x-navbar-dropdown>
                <x-navbar-dropdown label="Program Pendidikan">
                    <x-navbar-dropdown-child label="Formal">
                        @foreach ($organizations['Sekolah Formal'] as $organization)
                            <x-navbar-dropdown-item
                                href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-navbar-dropdown-item>
                        @endforeach
                    </x-navbar-dropdown-child>
                    <x-navbar-dropdown-child label="Non Formal">
                        @foreach ($organizations['Program Jurusan'] as $organization)
                            <x-navbar-dropdown-item
                                href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-navbar-dropdown-item>
                        @endforeach
                        @foreach ($organizations['Sekolah Madrasah'] as $organization)
                            <x-navbar-dropdown-item
                                href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-navbar-dropdown-item>
                        @endforeach
                    </x-navbar-dropdown-child>
                    <x-navbar-dropdown-item href="#">Ekstrakurikuler</x-navbar-dropdown-item>
                </x-navbar-dropdown>
                @if (!request()->is('ppdb/*') && !request()->is('ppdb'))
                    <x-navbar-dropdown label='Badan Lembaga'>
                        @foreach ($organizations['Badan Lembaga'] as $organization)
                            <x-navbar-dropdown-item
                                href="{{ route('organizations.show', ['slug' => $organization->slug]) }}">{{ $organization->name }}</x-navbar-dropdown-item>
                        @endforeach
                    </x-navbar-dropdown>
                @endif
                @if (request()->is('ppdb'))
                    <x-ppdb.form-button class="inline-flex sm:hidden" />
                @endif
            </div>
        </div>
        <x-dark-mode-button class="hidden sm:block" />
        @if (!request()->is('ppdb'))
            @auth
                <a class="hidden sm:block" href="{{ route('filament.app.pages.dashboard') }}">
                    <x-filament::avatar class="h-auto" src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" />
                </a>
            @else
                <x-ppdb-button class="hidden" />
            @endauth
        @else
            <x-ppdb.form-button class="hidden" />
        @endif
    </div>
</nav>
{{-- End Navbar --}}
