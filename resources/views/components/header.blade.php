{{-- Header --}}
<header x-data="{ isScrolled: false }" x-init=" window.addEventListener('scroll', () => {
     isScrolled = window.pageYOffset > 50;
 });"
    class="sticky top-0 z-50 flex w-full flex-col text-sm sm:justify-start sm:pb-0">
    {{-- Topbar  --}}
    <div x-cloak x-show="!isScrolled" x-transition:enter.opacity.duration.200ms.origin.top
        x-transition:leave.opacity.duration.200ms.origin.bottom
        class="mx-auto w-full max-w-[85rem] border-b border-gray-200 bg-gray-100 px-4 dark:border-gray-800 dark:bg-gray-900 sm:px-6 lg:px-8">
        <div class="flex w-full items-center justify-end gap-x-3 py-2 sm:gap-x-5">
            <a class="inline-flex items-center justify-center gap-2 text-xs font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300 sm:text-sm"
                href="#">Alumni</a>
            <a class="inline-flex items-center justify-center gap-2 text-xs font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300 sm:text-sm"
                href="#">Orang Tua</a>
            <a class="inline-flex items-center justify-center gap-2 text-xs font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300 sm:text-sm"
                href="{{ route('filament.admin.pages.dashboard') }}">Pengurus</a>
            <span
                class="inline-flex items-center justify-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300">|</span>
            <a class="inline-flex w-5 items-center justify-center gap-2 fill-slate-600 hover:fill-slate-500 dark:fill-slate-400 dark:hover:fill-slate-300"
                href="#">@svg('icon-facebook')</a>
            <a class="inline-flex w-5 items-center justify-center gap-2 fill-slate-600 hover:fill-slate-500 dark:fill-slate-400 dark:hover:fill-slate-300"
                href="#">@svg('icon-instagram')</a>
            <a class="inline-flex w-6 items-center justify-center gap-2 fill-slate-600 hover:fill-slate-500 dark:fill-slate-400 dark:hover:fill-slate-300"
                href="#">@svg('icon-youtube')</a>
        </div>
    </div>
    {{-- End Topbar --}}
    <x-navbar />
</header>
{{-- End Header --}}
