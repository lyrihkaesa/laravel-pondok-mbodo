{{-- Many Table Package --}}
<section class="py-4 md:py-6">
    @isset($title)
        <!-- Title -->
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">{{ $title }}</h2>
            @isset($description)
                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $description }}</p>
            @endisset
        </div>
        <!-- End Title -->
    @endisset

    <div class="grid gap-y-4 px-4 md:grid-cols-3 md:gap-y-0 md:space-x-8 lg:px-8">
        <!-- Sidebar -->
        <div
            class="from-gray-50 dark:from-gray-950 md:col-span-1 md:h-full md:w-full md:bg-gradient-to-r md:via-transparent md:to-transparent">
            <div class="sticky start-0 top-0 pt-4 md:pt-6">
                <ul class="flex flex-col">
                    @foreach ($this->packages as $package)
                        <a class="-mt-px inline-flex items-center gap-x-2 border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-800 first:mt-0 first:rounded-t-lg last:rounded-b-lg hover:bg-gray-200 dark:border-gray-700 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800"
                            href="#{{ $package->slug }}">
                            <li class="">
                                {{ $package->name }}
                            </li>
                        </a>
                    @endforeach

                </ul>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Content -->
        <div class="md:col-span-2">
            @foreach ($this->packages as $package)
                <x-ppdb.card :slug="$package->slug">
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
        <!-- End Content -->
    </div>

</section>
{{-- End Many Table Package --}}

@push('scripts')
    {{-- Modal --}}
    <div id="modal-slidebar"
        class="hs-overlay size-full pointer-events-none fixed start-0 top-0 z-[80] hidden overflow-y-auto overflow-x-hidden"
        role="dialog" tabindex="-1" aria-labelledby="modal-slidebar-label">
        <div
            class="hs-overlay-animation-target m-3 flex min-h-[calc(100%-3.5rem)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out hs-overlay-open:scale-100 hs-overlay-open:opacity-100 sm:mx-auto sm:w-full sm:max-w-3xl">
            <div
                class="pointer-events-auto flex w-full flex-col overflow-hidden rounded-xl border bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-800 dark:shadow-neutral-700/70">
                {{-- Carousel --}}
                <div class="relative">
                    <div id="carousel-body" class="flex transition-transform duration-700">
                        <!-- Slides will be dynamically inserted here -->
                    </div>

                    <!-- Controls for Carousel -->
                    <button id="prev-slide" type="button"
                        class="absolute inset-y-0 start-0 inline-flex h-full w-[46px] items-center justify-center rounded-s-lg text-gray-800 hover:bg-gray-800/10 focus:bg-gray-800/10 focus:outline-none disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="next-slide" type="button"
                        class="absolute inset-y-0 end-0 inline-flex h-full w-[46px] items-center justify-center rounded-e-lg text-gray-800 hover:bg-gray-800/10 focus:bg-gray-800/10 focus:outline-none disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19l7-7-7-7" />
                        </svg>
                    </button>

                    {{-- Pagination Dots --}}
                    <div id="carousel-pagination" class="absolute bottom-3 left-0 right-0 flex justify-center space-x-2">
                        {{-- Dots will be dynamically inserted here --}}
                    </div>

                    {{-- Close Button --}}
                    <button type="button"
                        class="size-7 absolute right-3 top-3 z-10 inline-flex items-center justify-center rounded-full bg-white text-gray-800 shadow-sm hover:bg-gray-200 focus:outline-none dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600"
                        data-hs-overlay="#modal-slidebar">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselBody = document.getElementById('carousel-body');
            const prevSlide = document.getElementById('prev-slide');
            const nextSlide = document.getElementById('next-slide');
            const pagination = document.getElementById('carousel-pagination');
            let currentIndex = 0;
            let images = [];

            // Function to render the carousel slides and pagination
            function renderCarousel() {
                carouselBody.innerHTML = ''; // Clear existing slides
                pagination.innerHTML = ''; // Clear pagination dots

                images.forEach((image, index) => {
                    // Create a slide
                    const slide = document.createElement('div');
                    slide.classList.add('min-w-full', 'flex', 'justify-center', 'bg-gray-100');
                    slide.innerHTML =
                        `<img class="h-auto w-auto rounded-lg" src="${image}" alt="Slide ${index + 1}">`;
                    carouselBody.appendChild(slide);

                    // Create pagination dot
                    const dot = document.createElement('span');
                    dot.classList.add('w-3', 'h-3', 'rounded-full', 'bg-gray-400', 'cursor-pointer');
                    dot.addEventListener('click', () => setSlide(index));
                    pagination.appendChild(dot);
                });

                // Reset current index and update carousel view
                currentIndex = 0;
                updateCarousel();
            }

            // Update carousel slide and pagination dots
            function updateCarousel() {
                carouselBody.style.transform = `translateX(-${currentIndex * 100}%)`;
                Array.from(pagination.children).forEach((dot, index) => {
                    dot.classList.toggle('bg-gray-800', index === currentIndex);
                    dot.classList.toggle('bg-gray-400', index !== currentIndex);
                });
            }

            // Set specific slide (by index)
            function setSlide(index) {
                currentIndex = index;
                updateCarousel();
            }

            // Navigation controls
            function setupNavigationControls() {
                prevSlide.addEventListener('click', () => {
                    currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
                    updateCarousel();
                });

                nextSlide.addEventListener('click', () => {
                    currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
                    updateCarousel();
                });
            }

            // Listen for clicks on the buttons inside the table
            const buttons = document.querySelectorAll('button[aria-controls="modal-slidebar"]');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Parse the JSON from the data-image-attatchments attribute
                    const imageAttachments = JSON.parse(button.getAttribute(
                        'data-image-attatchments'));

                    // Update the images array dynamically
                    images = imageAttachments.length > 0 ? imageAttachments : [];

                    // Render the carousel with updated images
                    renderCarousel();
                });
            });

            // Initialize carousel once a button is clicked
            setupNavigationControls();
        });
    </script>
@endpush
