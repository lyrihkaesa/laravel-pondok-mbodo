<div class="space-y-5 px-4 sm:px-6 lg:px-0 lg:pe-8">
    @foreach ($this->randomPosts as $post)
        <!-- Media -->
        <a class="group flex items-center gap-x-6 rounded-md bg-gray-50 p-3 dark:bg-gray-800"
            href="{{ route('posts.show', $post->slug) }}">
            <div class="flex grow flex-col">
                <span
                    class="text-sm font-bold text-gray-800 group-hover:text-blue-600 dark:text-neutral-200 dark:group-hover:text-blue-500">
                    {{ $post->title }}
                </span>
                <span
                    class="text-xs font-bold text-gray-500 group-hover:text-blue-300 dark:text-neutral-500 dark:group-hover:text-blue-800">
                    {{ $post->published_at->translatedFormat('l, d F Y H:i') }}
                </span>
            </div>

            <div class="size-20 relative flex-shrink-0 overflow-hidden rounded-lg">
                <img class="size-full absolute start-0 top-0 rounded-lg object-cover"
                    src="{{ $post->thumbnail ? Storage::disk('minio_public')->url($post->thumbnail) : asset('images\thumbnails\images-dark.webp') }}"
                    alt="{{ $post->title }}">
            </div>
        </a>
        <!-- End Media -->
    @endforeach
</div>
