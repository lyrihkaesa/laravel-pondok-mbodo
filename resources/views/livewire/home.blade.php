<x-slot name="header">
    <x-header />
</x-slot>
<section>
    @foreach ($publicPage->content as $block)
        {{-- @dd($block['type']) --}}
        @if ($block['type'] === 'slider')
            <x-block.slider.index>
                <x-block.slider.main>
                    @foreach ($block['data']['slides'] as $slide)
                        <x-block.slider.item src="{{ asset('storage/' . $slide['url']) }}" alt="{{ $slide['alt'] }}" />
                    @endforeach
                </x-block.slider.main>
                <x-block.slider.button-prev />
                <x-block.slider.button-next />
                <x-block.slider.pagination>
                    @foreach ($block['data']['slides'] as $slide)
                        <x-block.slider.pointer />
                    @endforeach
                </x-block.slider.pagination>
            </x-block.slider.index>
        @endif
    @endforeach

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
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">Pawarto</h2>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Ikuti terus perkembangan dengan wawasan dari Pondok Mbodo.
            </p>
        </div>
        <!-- End Title -->

        <!-- Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <x-blog.card.index href="{{ route('posts.show', $post->slug) }}">
                    <x-blog.card.header>
                        <x-blog.card.image
                            src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('images\thumbnails\images-dark.webp') }}"
                            alt="{{ $post->title }}" />
                    </x-blog.card.header>

                    <div class="mt-7">
                        <x-blog.card.title>{{ $post->title }}</x-blog.card.title>
                        <x-blog.card.description>{{ str($post->content)->limit(140) }}</x-blog.card.description>
                        <x-blog.card.read-more />
                    </div>
                </x-blog.card.index>
            @endforeach
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Blog -->
</section>
