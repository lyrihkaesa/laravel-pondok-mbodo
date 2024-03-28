<x-slot name="header">
    {{-- Header --}}
    <header x-data="{ isScrolled: false }" x-init=" window.addEventListener('scroll', () => {
         isScrolled = window.pageYOffset > 50;
     });"
        class="sticky top-0 z-50 flex w-full flex-col text-sm sm:justify-start sm:pb-0">
        {{-- Topbar  --}}
        <div x-cloak x-show="!isScrolled" x-transition:enter.opacity.duration.200ms.origin.top
            x-transition:leave.opacity.duration.200ms.origin.bottom
            class="mx-auto w-full max-w-[85rem] border-b border-gray-200 bg-gray-100 px-4 dark:border-gray-800 dark:bg-gray-900 sm:px-6 lg:px-8">
            <div class="flex w-full items-center justify-end gap-x-5 py-2">
                <a class="inline-flex items-center justify-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300"
                    href="#">Alumni</a>
                <a class="inline-flex items-center justify-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300"
                    href="#">Orang Tua</a>
                <a class="inline-flex items-center justify-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-500 dark:text-slate-400 dark:hover:text-slate-300"
                    href="#">Pengurus</a>
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
        {{-- Navbar --}}
        <nav x-cloak x-data :class="{ 'backdrop-blur bg-white/75 dark:bg-gray-800/75 ': isScrolled }"
            class="mx-auto w-full max-w-[85rem] border-b-2 border-gray-100 bg-white px-4 py-2 transition-colors duration-500 dark:border-gray-700 dark:bg-gray-800 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8"
            aria-label="Global">
            <div class="flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-x-2 text-xl font-semibold dark:text-white"
                    wire:navigate>
                    <img class="h-auto w-10" src="/favicon-150x150.png" alt="Logo">
                    <span class="whitespace-nowrap">Pondok Mbodo</span>
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
                        <svg class="size-4 hidden flex-shrink-0 hs-collapse-open:block"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                    <x-dark-mode-button />
                    <x-ppdb-button class="inline-flex" />
                </div>
            </div>
            <div class="flex items-center justify-end gap-4">
                <div id="navbar-image-and-text-2"
                    class="hs-collapse hidden grow basis-full overflow-hidden transition-all duration-300 sm:block">
                    <div class="mt-5 flex flex-col gap-5 sm:mt-0 sm:flex-row sm:items-center sm:justify-end sm:ps-5">
                        <a class="font-medium text-gray-600 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            href="#">Profile Pondok</a>
                        <a class="font-medium text-gray-600 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                            href="#">Berita</a>
                        <div class="hs-dropdown [--adaptive:none] [--strategy:static] sm:[--strategy:fixed]">
                            <button id="hs-mega-menu-basic-dr" type="button"
                                class="flex w-full items-center font-medium text-gray-600 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500">
                                Program Pendidikan
                                <svg class="size-4 ms-1 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div class="hs-dropdown-menu top-full z-10 hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-top-5 before:start-0 before:h-5 before:w-full hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border"
                                style="">
                                <div
                                    class="hs-dropdown relative [--adaptive:none] [--strategy:static] sm:[--strategy:absolute]">
                                    <button type="button"
                                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                        Non Formal
                                        <svg class="size-4 ms-2 flex-shrink-0 text-gray-600 sm:-rotate-90"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>
                                    <div
                                        class="hs-dropdown-menu end-full top-0 z-10 !mx-[10px] hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-end-5 before:top-0 before:h-full before:w-5 hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:mt-2 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border">
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Pesantren Putra
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Pesantren Putri
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Pesantren Tahfidzul Quran Putri
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Jurusan Mahir Kitab
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Jurusan Tahsin Quran
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Jurusan Suwuk
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Madarasah Wustho Dan Ulya
                                        </a>
                                    </div>
                                </div>
                                <div
                                    class="hs-dropdown relative [--adaptive:none] [--strategy:static] sm:[--strategy:absolute]">
                                    <button type="button"
                                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                        Formal
                                        <svg class="size-4 ms-2 flex-shrink-0 text-gray-600 sm:-rotate-90"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>

                                    <div
                                        class="hs-dropdown-menu end-full top-0 z-10 !mx-[10px] hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-end-5 before:top-0 before:h-full before:w-5 hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:mt-2 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border">
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Paud Quran Al Hawi
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Madrasah Ibtidiyah (Sekolah Dasar)
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            SMP Islam Al Hawi
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Madrasah Aliyah Plus Islam Al Hawi
                                        </a>
                                    </div>
                                </div>
                                <div
                                    class="hs-dropdown relative [--adaptive:none] [--strategy:static] sm:[--strategy:absolute]">
                                    <button type="button"
                                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                        Extrakulikuler
                                        <svg class="size-4 ms-2 flex-shrink-0 text-gray-600 sm:-rotate-90"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>

                                    <div
                                        class="hs-dropdown-menu end-full top-0 z-10 !mx-[10px] hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-end-5 before:top-0 before:h-full before:w-5 hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:mt-2 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border">
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            About
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Downloads
                                        </a>
                                        <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                            href="#">
                                            Team Account
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hs-dropdown [--adaptive:none] [--strategy:static] sm:[--strategy:fixed]">
                            <button id="hs-mega-menu-basic-dr" type="button"
                                class="flex w-full items-center font-medium text-gray-600 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500">
                                Badan Lembaga
                                <svg class="size-4 ms-1 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div class="hs-dropdown-menu top-full z-10 hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-top-5 before:start-0 before:h-5 before:w-full hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border"
                                style="">
                                <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                    href="#">
                                    Majelis Lapanan Ahad Kliwon Jimad Sholawat
                                </a>
                                <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                    href="#">
                                    Jamiyah Thoriqoh Qodiriyah Al Jaelaniyah
                                </a>
                                <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                    href="#">
                                    Langit Tour
                                </a>
                                <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                    href="#">
                                    Taman Suwuk Nusantara
                                </a>
                                <a class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                    href="#">
                                    Padepokan Satrio Mbodo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <x-dark-mode-button class="hidden sm:block" />
                <x-ppdb-button class="hidden" />
            </div>
        </nav>
        {{-- End Navbar --}}
    </header>
    {{-- End Header --}}
</x-slot>


<div>
    <!-- Slider -->
    <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "isAutoPlay": true
  }'
        class="relative mx-auto w-full max-w-[85rem]">
        <div class="hs-carousel relative min-h-[275px] w-full overflow-hidden bg-white md:min-h-[500px]">
            <div
                class="hs-carousel-body absolute bottom-0 start-0 top-0 flex flex-nowrap opacity-0 transition-transform duration-700">
                <div class="hs-carousel-slide">
                    <div class="flex h-full justify-center bg-gray-100 p-6">
                        <img class="self-center object-cover text-4xl transition duration-700"
                            src="/images/carousel/carousel-01.jpg" alt="Caraousel 01">
                    </div>
                </div>
                <div class="hs-carousel-slide">
                    <div class="flex h-full justify-center bg-gray-200 p-6">
                        <img class="self-center object-cover text-4xl transition duration-700"
                            src="/images/carousel/carousel-02.jpg" alt="Caraousel 02">
                    </div>
                </div>
                <div class="hs-carousel-slide">
                    <div class="flex h-full justify-center bg-gray-300 p-6">
                        <img class="self-center object-cover text-4xl transition duration-700"
                            src="/images/carousel/carousel-03.jpg" alt="Caraousel 03">
                    </div>
                </div>
                <div class="hs-carousel-slide">
                    <div class="flex h-full justify-center bg-gray-300 p-6">
                        <img class="self-center object-cover text-4xl transition duration-700"
                            src="/images/carousel/carousel-04.jpg" alt="Caraousel 04">
                    </div>
                </div>
            </div>
        </div>

        <button type="button"
            class="hs-carousel-prev hs-carousel:disabled:opacity-50 absolute inset-y-0 start-0 inline-flex h-full w-[46px] items-center justify-center text-gray-800 hover:bg-gray-800/[.1] disabled:pointer-events-none">
            <span class="text-2xl" aria-hidden="true">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                </svg>
            </span>
            <span class="sr-only">Previous</span>
        </button>
        <button type="button"
            class="hs-carousel-next hs-carousel:disabled:opacity-50 absolute inset-y-0 end-0 inline-flex h-full w-[46px] items-center justify-center text-gray-800 hover:bg-gray-800/[.1] disabled:pointer-events-none">
            <span class="sr-only">Next</span>
            <span class="text-2xl" aria-hidden="true">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </span>
        </button>

        <div class="hs-carousel-pagination absolute bottom-3 end-0 start-0 flex justify-center space-x-2">
            <span
                class="size-3 cursor-pointer rounded-full border-4 border-gray-400 hs-carousel-active:border-blue-700 hs-carousel-active:bg-blue-700"></span>
            <span
                class="size-3 cursor-pointer rounded-full border-4 border-gray-400 hs-carousel-active:border-blue-700 hs-carousel-active:bg-blue-700"></span>
            <span
                class="size-3 cursor-pointer rounded-full border-4 border-gray-400 hs-carousel-active:border-blue-700 hs-carousel-active:bg-blue-700"></span>
            <span
                class="size-3 cursor-pointer rounded-full border-4 border-gray-400 hs-carousel-active:border-blue-700 hs-carousel-active:bg-blue-700"></span>
        </div>
    </div>
    <!-- End Slider -->

    <!-- Team -->
    <div class="mx-auto max-w-[85rem] bg-gray-200 px-4 py-10 dark:bg-gray-700 sm:px-6 lg:px-8 lg:py-14">
        <!-- Title -->
        <div class="mx-auto mb-10 max-w-2xl text-center lg:mb-14">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">Masyayikh Penasehat & Pengasuh
            </h2>
        </div>
        <!-- End Title -->

        <!-- Grid -->
        <div class="grid grid-cols-2 gap-8 md:grid-cols-3 md:gap-12">
            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl" src="/images/pengurus/pengurus-01.jpg"
                    alt="K.H. Ahmad Basyir Kudus">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        K.H. Ahmad Basyir Kudus
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                        Penasehat
                    </p>
                </div>
            </div>
            <!-- End Col -->

            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl" src="/images/pengurus/pengurus-02.jpg"
                    alt="Simbah Mulyadi Bin Kardi Ronodikromo">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        Simbah Mulyadi Bin Kardi Ronodikromo
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                        Pembina
                    </p>
                </div>
            </div>
            <!-- End Col -->

            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl" src="/images/pengurus/pengurus-03.jpg"
                    alt="Abah K.H. Muhammad Ghufron Mulyadi">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        Abah K.H. Muhammad Ghufron Mulyadi
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                        Pegasuh
                    </p>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Team -->

    <!-- Card Blog -->
    <div class="mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <!-- Title -->
        <div class="mx-auto mb-10 max-w-2xl text-center lg:mb-14">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">Blog</h2>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Ikuti terus perkembangan dengan wawasan dari Pondok Mbodo.
            </p>
        </div>
        <!-- End Title -->

        <!-- Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card -->
            <a class="group dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                <div class="relative overflow-hidden rounded-xl pt-[50%] sm:pt-[70%]">
                    <img class="size-full absolute start-0 top-0 rounded-xl object-cover transition-transform duration-500 ease-in-out group-hover:scale-105"
                        src="https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1035&q=80"
                        alt="Image Description">
                    <span
                        class="absolute end-0 top-0 rounded-es-xl rounded-se-xl bg-gray-800 px-3 py-1.5 text-xs font-medium text-white dark:bg-gray-900">
                        Sponsored
                    </span>
                </div>

                <div class="mt-7">
                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-gray-600 dark:text-gray-200">
                        Studio by Preline
                    </h3>
                    <p class="mt-3 text-gray-800 dark:text-gray-200">
                        Produce professional, reliable streams easily leveraging Preline's innovative broadcast studio
                    </p>
                    <p
                        class="mt-5 inline-flex items-center gap-x-1 font-medium text-blue-600 decoration-2 group-hover:underline">
                        Read more
                        <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </p>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                <div class="relative overflow-hidden rounded-xl pt-[50%] sm:pt-[70%]">
                    <img class="size-full absolute start-0 top-0 rounded-xl object-cover transition-transform duration-500 ease-in-out group-hover:scale-105"
                        src="https://images.unsplash.com/photo-1542125387-c71274d94f0a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80"
                        alt="Image Description">
                </div>

                <div class="mt-7">
                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-gray-600 dark:text-gray-200">
                        Onsite
                    </h3>
                    <p class="mt-3 text-gray-800 dark:text-gray-200">
                        Optimize your in-person experience with best-in-class capabilities like badge printing and lead
                        retrieval
                    </p>
                    <p
                        class="mt-5 inline-flex items-center gap-x-1 font-medium text-blue-600 decoration-2 group-hover:underline">
                        Read more
                        <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </p>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="min-h-60 group relative flex w-full flex-col rounded-xl bg-[url('https://images.unsplash.com/photo-1634017839464-5c339ebe3cb4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3000&q=80')] bg-cover bg-center transition hover:shadow-lg dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="#">
                <div class="flex-auto p-4 md:p-6">
                    <h3 class="text-xl text-white/[.9] group-hover:text-white"><span class="font-bold">Preline</span>
                        Press publishes books about economic and technological advancement.</h3>
                </div>
                <div class="p-4 pt-0 md:p-6">
                    <div
                        class="inline-flex items-center gap-2 text-sm font-medium text-white group-hover:text-white/[.7]">
                        Visit the site
                        <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </div>
                </div>
            </a>
            <!-- End Card -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Blog -->
    <x-footer />
</div>
