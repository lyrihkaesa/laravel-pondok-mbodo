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

            <!-- Buttons -->
            <div class="mt-8 flex justify-center gap-3">
                <a class="inline-flex items-center justify-center gap-x-2 rounded-lg border border-transparent bg-teal-600 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-700 disabled:pointer-events-none disabled:opacity-50"
                    href="#">
                    Pendaftaran Online
                    <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </a>
            </div>
            <!-- End Buttons -->
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
                    {{-- @dd($user->employee) --}}
                    <div class="grid gap-x-4 gap-y-3 sm:flex sm:items-center">
                        @if (!$user->hasRole('Santri'))
                            <img class="size-20 rounded-lg"
                                src="{{ (isset($user->employee->profile_picture_1x1) ? asset('storage/' . $user->employee->profile_picture_1x1) : $user->employee->gender === 'FAMALE') ? asset('images/profile-picture/famale.jpg') : asset('images/profile-picture/male.jpg') }}"
                                alt="{{ $user->name }}">
                        @else
                            <img class="size-20 rounded-lg"
                                src="{{ (isset($user->student->profile_picture_1x1) ? asset('storage/' . $user->student->profile_picture_1x1) : $user->student->gender === 'Perempuan') ? asset('images/profile-picture/famale.jpg') : asset('images/profile-picture/male.jpg') }}"
                                alt="{{ $user->name }}">
                        @endif


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
                                <a class="inline-flex items-center justify-center rounded-full text-gray-500 hover:text-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <svg class="size-3.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                    </svg>
                                </a>
                                <a class="inline-flex items-center justify-center rounded-full text-gray-500 hover:text-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <svg class="size-3.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                                    </svg>
                                </a>
                                <a class="inline-flex items-center justify-center rounded-full text-gray-500 hover:text-gray-800 dark:hover:text-gray-200"
                                    href="#">
                                    <svg class="size-3.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M3.362 10.11c0 .926-.756 1.681-1.681 1.681S0 11.036 0 10.111C0 9.186.756 8.43 1.68 8.43h1.682v1.68zm.846 0c0-.924.756-1.68 1.681-1.68s1.681.756 1.681 1.68v4.21c0 .924-.756 1.68-1.68 1.68a1.685 1.685 0 0 1-1.682-1.68v-4.21zM5.89 3.362c-.926 0-1.682-.756-1.682-1.681S4.964 0 5.89 0s1.68.756 1.68 1.68v1.682H5.89zm0 .846c.924 0 1.68.756 1.68 1.681S6.814 7.57 5.89 7.57H1.68C.757 7.57 0 6.814 0 5.89c0-.926.756-1.682 1.68-1.682h4.21zm6.749 1.682c0-.926.755-1.682 1.68-1.682.925 0 1.681.756 1.681 1.681s-.756 1.681-1.68 1.681h-1.681V5.89zm-.848 0c0 .924-.755 1.68-1.68 1.68A1.685 1.685 0 0 1 8.43 5.89V1.68C8.43.757 9.186 0 10.11 0c.926 0 1.681.756 1.681 1.68v4.21zm-1.681 6.748c.926 0 1.682.756 1.682 1.681S11.036 16 10.11 16s-1.681-.756-1.681-1.68v-1.682h1.68zm0-.847c-.924 0-1.68-.755-1.68-1.68 0-.925.756-1.681 1.68-1.681h4.21c.924 0 1.68.756 1.68 1.68 0 .926-.756 1.681-1.68 1.681h-4.21z" />
                                    </svg>
                                </a>
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
