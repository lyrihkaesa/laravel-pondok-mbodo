@props(['isScrolled' => false])

{{-- Header --}}
<header
    @if ($isScrolled) x-data="{ isScrolled: false }" x-init=" window.addEventListener('scroll', () => {
    isScrolled = window.pageYOffset > 50;
});"
   class="sticky top-0 z-50 flex w-full flex-col text-sm sm:justify-start sm:pb-0"
   @else
   class="flex w-full flex-col text-sm sm:justify-start sm:pb-0" @endif>
    {{-- Topbar  --}}
    <div @if ($isScrolled) x-cloak x-show="!isScrolled" x-transition:enter.opacity.duration.200ms.origin.top
    x-transition:leave.opacity.duration.200ms.origin.bottom @endif
        class="mx-auto w-full max-w-[85rem] border-b border-gray-200 bg-gray-100 px-4 dark:border-gray-800 dark:bg-gray-900 sm:px-6 lg:px-8">
        <x-topbar-list />
    </div>
    {{-- End Topbar --}}
    <x-navbar />
</header>
{{-- End Header --}}
