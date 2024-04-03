<x-slot name="header">
    <x-header />
</x-slot>
<section>
    <!-- Slider -->
    <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "isAutoPlay": true
  }'
        class="relative mx-auto w-full max-w-[85rem]">
        <div class="hs-carousel relative min-h-[200px] w-full overflow-hidden bg-white md:min-h-[500px]">
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
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
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
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
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
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
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
</section>
