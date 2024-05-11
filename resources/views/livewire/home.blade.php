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
        @elseif ($block['type'] === 'team')
            {{-- @dd($block) --}}
            <x-block.team.index>
                <x-block.team.header>
                    <x-block.team.title>{{ $block['data']['title'] }}</x-block.team.title>
                </x-block.team.header>
                <x-block.team.grid>
                    @foreach ($block['data']['teams'] as $member)
                        <x-block.team.item imageUrl="{{ asset('storage/' . $member['url']) }}"
                            imageAlt="{{ $member['alt'] }}"
                            role="{{ $member['role'] }}">{{ $member['name'] }}</x-block.team.item>
                    @endforeach
                </x-block.team.grid>
            </x-block.team.index>
        @endif
    @endforeach

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
