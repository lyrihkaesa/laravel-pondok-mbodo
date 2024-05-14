<x-slot name="header">
    <x-header />
</x-slot>

<x-slot name="css">
    @vite('resources/css/markdown.css')
</x-slot>

<div class="mx-auto max-w-[85rem]">
    <!-- Hero -->
    <div
        class="before:size-full relative overflow-hidden before:absolute before:start-1/2 before:top-0 before:-z-[1] before:-translate-x-1/2 before:transform before:bg-[url('https://preline.co/assets/svg/examples/squared-bg-element.svg')] before:bg-top before:bg-no-repeat dark:before:bg-[url('https://preline.co/assets/svg/examples-dark/squared-bg-element.svg')]">
        <div class="px-4 pb-10 pt-24 sm:px-6 lg:px-8">
            <!-- Announcement Banner -->
            {{-- <div class="flex justify-center">
                <a class="inline-flex items-center gap-x-2 rounded-full border border-gray-200 bg-white p-2 px-3 text-xs text-gray-600 transition hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600"
                    href="#">
                    Explore the Capital Product
                    <span class="flex items-center gap-x-1">
                        <span
                            class="border-s border-gray-200 ps-2 text-blue-600 dark:border-gray-700 dark:text-blue-500">Explore</span>
                        <svg class="size-4 flex-shrink-0 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </span>
                </a>
            </div> --}}
            <!-- End Announcement Banner -->

            <!-- Title -->
            <div class="mx-auto mt-5 max-w-3xl text-center">
                <h1
                    class="block text-2xl font-bold text-gray-800 dark:text-gray-200 sm:text-4xl md:text-5xl lg:text-6xl">
                    {{ $organization->name }}
                </h1>
            </div>
            <!-- End Title -->

            @isset($organization->description)
                <div class="mx-auto mt-5 max-w-3xl text-center">
                    <p class="text-lg text-gray-600 dark:text-gray-400">{{ $organization->description }}</p>
                </div>
            @endisset

            @if ($organization->category === 'Sekolah Formal')
                <!-- Buttons -->
                <div class="mt-8 flex justify-center gap-3">
                    <a class="inline-flex items-center justify-center gap-x-2 rounded-lg border border-transparent bg-teal-600 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-700 disabled:pointer-events-none disabled:opacity-50"
                        href="{{ route('student-registration') }}">
                        Pendaftaran Online
                        <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </a>
                </div>
                <!-- End Buttons -->
            @endif
        </div>
    </div>
    <!-- End Hero -->

    {{-- Visi dan Misi --}}
    @if (isset($organization->vision) || isset($organization->mission))
        <div class="bg-white px-4 py-10 dark:bg-gray-950 sm:px-6 lg:px-8 lg:py-14">
            <div class="">
                <div class="mx-auto max-w-5xl">
                    <!-- Grid -->
                    <div class="grid gap-6 sm:grid-cols-2 md:gap-12">
                        @isset($organization->vision)
                            <div>
                                <h3
                                    class="text-2xl font-bold text-gray-800 dark:text-gray-200 md:text-3xl md:leading-tight">
                                    Visi
                                </h3>
                                <div class="markdown">{!! str($organization->vision)->markdown() !!}</div>
                            </div>
                        @endisset
                        <!-- End Col -->

                        @isset($organization->mission)
                            <div>
                                <h3
                                    class="text-2xl font-bold text-gray-800 dark:text-gray-200 md:text-3xl md:leading-tight">
                                    Misi
                                </h3>
                                <div class="markdown">{!! str($organization->mission)->markdown() !!}</div>
                            </div>
                        @endisset
                        <!-- End Col -->
                    </div>
                    <!-- End Grid -->
                </div>
            </div>
        </div>
    @endif
    {{-- End Visi dan Misi --}}

    <!-- Program -->
    @if (!$organization->programs->isEmpty())
        <div class="bg-gray-100 px-4 py-10 dark:bg-gray-900 sm:px-6 lg:px-8 lg:py-14">
            <div class="px-4 py-4 text-center sm:px-6 lg:px-8 lg:py-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 md:text-3xl md:leading-tight">
                    Program
                </h3>
            </div>
            <!-- Flex -->
            <div class="flex items-center gap-4 overflow-x-auto py-3">
                @foreach ($organization->programs as $program)
                    <x-extracurricular.card :extracurricular="$program" />
                @endforeach
            </div>
            <!-- End Flex -->
        </div>
    @endif
    <!-- End Program -->

    <!-- Facility -->
    @if (!$organization->facilities->isEmpty())
        <div class="bg-gray-100 px-4 py-10 dark:bg-gray-900 sm:px-6 lg:px-8 lg:py-14">
            <div class="px-4 py-4 text-center sm:px-6 lg:px-8 lg:py-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 md:text-3xl md:leading-tight">
                    Fasilitas
                </h3>
            </div>
            <!-- Flex -->
            <div class="flex items-center gap-4 overflow-x-auto py-3">
                @foreach ($organization->facilities as $facility)
                    <x-extracurricular.card :extracurricular="$facility" />
                @endforeach
            </div>
            <!-- End Flex -->
        </div>
    @endif
    <!-- End Facility -->

    <!-- Extracurricular -->
    @if (!$organization->extracurriculars->isEmpty())
        <div class="bg-gray-100 px-4 py-10 dark:bg-gray-900 sm:px-6 lg:px-8 lg:py-14">
            <div class="px-4 py-4 text-center sm:px-6 lg:px-8 lg:py-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 md:text-3xl md:leading-tight">
                    Extrakurikuler
                </h3>
            </div>
            <!-- Flex -->
            <div class="flex items-center gap-4 overflow-x-auto py-3">
                @foreach ($organization->extracurriculars as $extracurricular)
                    <x-extracurricular.card :extracurricular="$extracurricular" />
                @endforeach
            </div>
            <!-- End Flex -->
        </div>
    @endif
    <!-- End Extracurricular -->

    {{-- Biaya Pendidikan --}}
    @if (!$organization->packages->isEmpty())
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="px-4 py-4 text-center sm:px-6 lg:px-8 lg:py-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 md:text-3xl md:leading-tight">Biaya
                    Pendidikan</h3>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach ($organization->packages as $package)
                    <x-ppdb.card packageId="$package->id">
                        <x-ppdb.card-header>{{ $package->name }}</x-ppdb.card-header>
                        <x-ppdb.table>
                            @foreach ($package->products as $product)
                                <x-ppdb.table-tr :product="$product" />
                            @endforeach
                        </x-ppdb.table>
                        <x-ppdb.card-footer :total="$package->products->sum('price')" :count="$package->products->count()" />
                    </x-ppdb.card>
                @endforeach
            </div>
        </div>
    @endif
    {{-- End Biaya Pendidikan --}}

    <!-- Team -->
    @if (!$organization->users->isEmpty())
        <div class="bg-white px-4 py-10 dark:bg-gray-950 sm:px-6 lg:px-8 lg:py-14">
            <!-- Title -->
            <div class="mx-auto mb-10 max-w-2xl text-center lg:mb-14">
                <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">Struktur Organisasi</h2>
                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $organization->name }}</p>
            </div>
            <!-- End Title -->

            <!-- Grid -->
            <div class="grid grid-cols-2 gap-8 md:gap-12 lg:grid-cols-3">
                @foreach ($organization->users as $user)
                    <div class="grid gap-x-4 gap-y-3 sm:flex sm:items-center">
                        <img class="size-20 rounded-lg"
                            src="{{ $user->profile_picture_1x1 ? asset('storage/' . $user->profile_picture_1x1) : asset('images\thumbnails\images-dark.webp') }}"
                            alt="{{ $user->name }}">


                        <div class="sm:flex sm:h-full sm:flex-col">
                            <div>
                                <h3 class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $user->name }}
                                </h3>
                                <p class="mt-1 text-xs uppercase text-gray-500">
                                    {{ $user->pivot->role }}
                                </p>
                            </div>

                            <!-- Social Brands -->
                            <div class="mt-2 space-x-2.5 sm:mt-auto">
                                <a class="inline-flex items-center justify-center rounded-full fill-gray-500 hover:fill-gray-800 dark:hover:fill-gray-200"
                                    target="_blank" href="https://wa.me/{{ $user->phone }}">@svg('icon-whatsapp', ['class' => 'size-3.5 flex-shrink-0'])</a>
                                <a class="inline-flex items-center justify-center rounded-full fill-gray-500 hover:fill-gray-800 dark:hover:fill-gray-200"
                                    target="_blank" href="#">@svg('icon-facebook', ['class' => 'size-3.5 flex-shrink-0'])</a>
                                <a class="inline-flex items-center justify-center rounded-full fill-gray-500 hover:fill-gray-800 dark:hover:fill-gray-200"
                                    target="_blank" href="#">@svg('icon-instagram', ['class' => 'size-3.5 flex-shrink-0'])</a>
                            </div>
                            <!-- End Social Brands -->
                        </div>
                    </div>
                    <!-- End Col -->
                @endforeach
            </div>
            <!-- End Grid -->
        </div>
    @endif
    <!-- End Team -->
</div>
