<div class="mx-auto max-w-[85rem]">

    <div class="mx-auto flex items-center justify-center pb-5 pt-10">
        <x-application-logo />
    </div>

    <!-- Title -->
    <div class="mx-auto pb-5 text-center md:pb-10">
        <h1 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">TATA TERTIB</h1>
        <h2 class="text-lg font-bold dark:text-gray-400 md:text-xl">Yayasan Pondok Pesantren Darul Falah Ki Ageng Mbodo
        </h2>
    </div>
    <!-- End Title -->
    {{-- @dd($laws) --}}
    @foreach ($laws as $chapterLaw)
        <!-- ChapterLaw -->
        <section id="{{ $chapterLaw['chapter'] }}" class="px-4 py-2 sm:px-6 lg:px-8 lg:py-3">
            <!-- Title -->
            <div class="mx-auto mb-3 max-w-2xl text-center lg:mb-6">
                <h2 class="text-xl font-bold dark:text-white md:text-2xl md:leading-tight">
                    {{ $chapterLaw['chapter_converted'] }}</h2>
                <h2 class="text-xl font-bold dark:text-white md:text-2xl md:leading-tight">
                    {{ $chapterLaw['chapter_title'] }}</h2>
            </div>
            <!-- End Title -->
            @foreach ($chapterLaw['section'] as $sectionLaw)
                {{-- Card --}}
                <x-card.index>
                    <x-card.header>{{ $sectionLaw['section_converted'] . ' ' . $sectionLaw['section_title'] }}</x-card.header>
                    <x-table.index>
                        <x-table.thead>
                            <x-table.th class="text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        Ayat
                                    </span>
                                </div>
                            </x-table.th>
                            <x-table.th class="text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Keterangan
                                    </span>
                                </div>
                            </x-table.th>
                            <x-table.th>
                                <div class="flex items-center justify-end gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        Poin
                                    </span>
                                </div>
                            </x-table.th>
                        </x-table.thead>
                        <x-table.tbody>
                            @foreach ($sectionLaw['article'] as $articleLaw)
                                <tr>
                                    <x-table.td class="max-w-fit whitespace-nowrap text-start">
                                        <div class="px-4 py-2 md:px-6 md:py-3">
                                            <span
                                                class="text-xs font-semibold text-gray-800 dark:text-gray-200 md:text-sm">{{ $articleLaw['article_converted'] }}</span>
                                        </div>
                                    </x-table.td>
                                    <x-table.td class="text-start">
                                        <div class="px-2 py-2 md:px-4 md:py-3">
                                            <span
                                                class="text-xs text-gray-800 dark:text-gray-200 md:text-sm">{{ $articleLaw['content'] }}</span>
                                        </div>
                                    </x-table.td>
                                    <x-table.td class="text-end">
                                        <div class="px-4 py-2 md:px-6 md:py-3">
                                            <span x-data="{ poin: '{{ $articleLaw['point'] }}' }"
                                                x-bind:class="{
                                                    'bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500': poin === '10',
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-500': poin === '5',
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-500/10 dark:text-blue-500': poin === '2',
                                                    'bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500': poin === '1',
                                                    'bg-pink-100 text-pink-800 dark:bg-pink-500/10 dark:text-pink-500': poin === '3',
                                                    'bg-gray-100 text-gray-800 dark:bg-gray-500/10 dark:text-gray-500': poin === '0',
                                                }"
                                                class="inline-flex items-center gap-x-1 rounded-full px-1.5 py-1 text-xs font-medium leading-3 md:leading-4"
                                                x-text="poin">
                                            </span>
                                        </div>
                                    </x-table.td>
                                </tr>
                            @endforeach
                        </x-table.tbody>
                    </x-table.index>
                </x-card.index>
                {{-- End Card --}}
            @endforeach
        </section>
        <!-- End ChapterLaw -->
    @endforeach

</div>
