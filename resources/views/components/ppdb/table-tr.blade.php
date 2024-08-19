@props(['product'])

@php
    $modalId = 'product-modal-' . \Illuminate\Support\Str::random(10);
@endphp

<tr class="hover:bg-gray-200 dark:hover:bg-gray-800">
    <td class="h-px min-w-fit text-start">
        <div class="flex items-center gap-x-2 px-4 py-2 md:px-6 md:py-3">
            <button type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="{{ $modalId }}"
                data-hs-overlay="#{{ $modalId }}">
                <img class="min-w-10 h-10 w-10 cursor-pointer rounded-lg object-cover"
                    src="{{ $product->image_attachments ? Storage::disk(config('filament.default_filesystem_disk'))->url($product->image_attachments[0]) : asset('images/thumbnails/images-dark-500x500.jpg') }}"
                    alt="Product Image">
            </button>
            <div>
                <span
                    class="text-xs font-semibold text-gray-800 dark:text-gray-200 md:text-sm">{{ $product->name }}</span>
                <span x-data="{ term: '{{ $product->payment_term->getLabel() }}' }"
                    x-bind:class="{
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-500': term === 'Bulanan',
                        'bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500': term === 'Sekali',
                        'bg-pink-100 text-pink-800 dark:bg-pink-500/10 dark:text-pink-500': term !== 'Bulanan' &&
                            term !== 'Sekali'
                    }"
                    class="inline-flex items-center gap-x-1 rounded-full px-1.5 py-1 text-[0.6rem] font-medium leading-3 md:text-xs md:leading-4"
                    x-text="term">
                </span>
            </div>
        </div>

        {{-- Modal --}}
        <div id="{{ $modalId }}"
            class="hs-overlay size-full pointer-events-none fixed start-0 top-0 z-[80] hidden overflow-y-auto overflow-x-hidden"
            role="dialog" tabindex="-1" aria-labelledby="{{ $modalId }}-label">
            <div
                class="hs-overlay-animation-target flex m-3 min-h-[calc(100%-3.5rem)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out hs-overlay-open:scale-100 hs-overlay-open:opacity-100 sm:mx-auto sm:w-full sm:max-w-3xl">
                <div
                    class="flex pointer-events-auto w-full flex-col rounded-xl border bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-800 dark:shadow-neutral-700/70">
                    {{-- Carousel --}}
                    <div class="w-full rounded-lg bg-white shadow-md dark:bg-neutral-800">
                        <div data-hs-carousel='{"loadingClasses": "opacity-0"}' class="relative">
                            <div
                                class="hs-carousel relative min-h-[90vw] w-full overflow-hidden rounded-lg bg-white md:min-h-[90vh]">
                                <div
                                    class="hs-carousel-body flex absolute bottom-0 start-0 top-0 flex-nowrap opacity-0 transition-transform duration-700">
                                    @if ($product->image_attachments === null)
                                        <div class="hs-carousel-slide">
                                            <div class="flex h-full justify-center bg-gray-100 dark:bg-neutral-900">
                                                <img class="h-auto w-auto rounded-lg"
                                                    src="{{ asset('images/thumbnails/images-dark-500x500.jpg') }}"
                                                    alt="Tidak ada gambar">
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($product->image_attachments as $image)
                                            <div class="hs-carousel-slide">
                                                <div class="flex h-full justify-center bg-gray-100 dark:bg-neutral-900">
                                                    <img class="h-auto w-auto rounded-lg"
                                                        src="{{ Storage::disk(config('filament.default_filesystem_disk'))->url($image) }}"
                                                        alt="{{ $product->name . $loop->iteration }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            @if (is_array($product->image_attachments) && count($product->image_attachments) > 1)
                                {{-- Previous --}}
                                <button type="button"
                                    class="hs-carousel-prev hs-carousel:disabled:opacity-50 absolute inset-y-0 start-0 inline-flex h-full w-[46px] items-center justify-center rounded-s-lg text-gray-800 hover:bg-gray-800/10 focus:bg-gray-800/10 focus:outline-none disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                    <span class="text-2xl" aria-hidden="true">
                                        <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m15 18-6-6 6-6"></path>
                                        </svg>
                                    </span>
                                    <span class="sr-only">Previous</span>
                                </button>

                                {{-- Next --}}
                                <button type="button"
                                    class="hs-carousel-next hs-carousel:disabled:opacity-50 absolute inset-y-0 end-0 inline-flex h-full w-[46px] items-center justify-center rounded-e-lg text-gray-800 hover:bg-gray-800/10 focus:bg-gray-800/10 focus:outline-none disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                    <span class="sr-only">Next</span>
                                    <span class="text-2xl" aria-hidden="true">
                                        <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </span>
                                </button>

                                {{-- Pagination Icon Circle Bottom --}}
                                <div
                                    class="hs-carousel-pagination flex absolute bottom-3 end-0 start-0 justify-center space-x-2">
                                    @foreach ($product->image_attachments as $image)
                                        <span
                                            class="size-3 cursor-pointer rounded-full border border-gray-400 hs-carousel-active:border-blue-700 hs-carousel-active:bg-blue-700 dark:border-neutral-600 dark:hs-carousel-active:border-blue-500 dark:hs-carousel-active:bg-blue-500"></span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Close Button --}}
                            <button type="button"
                                class="size-7 absolute right-3 top-3 z-10 inline-flex items-center justify-center rounded-full bg-white text-gray-800 shadow-sm hover:bg-gray-200 focus:outline-none dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600"
                                data-hs-overlay="#{{ $modalId }}">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                    </div>
                    {{-- End Carousel --}}
                </div>
            </div>
        </div>
        {{-- End Modal --}}

    </td>
    <td class="h-px min-w-fit whitespace-nowrap text-end">
        <div class="px-4 py-2 md:px-6 md:py-3">
            <span class="block text-xs font-semibold text-gray-800 dark:text-gray-200 md:text-sm">Rp
                {{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
    </td>
</tr>
