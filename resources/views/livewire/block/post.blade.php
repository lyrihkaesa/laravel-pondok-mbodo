<!-- Card Blog -->
<div class='{{ $bgColorClass }} mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14'>
    @isset($title)
        <!-- Title -->
        <div class="mx-auto mb-10 max-w-2xl text-center lg:mb-14">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">{{ $title }}</h2>
            @isset($description)
                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $description }}</p>
            @endisset
        </div>
        <!-- End Title -->
    @endisset

    <!-- Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($this->posts as $post)
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
