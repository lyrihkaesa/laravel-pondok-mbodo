<x-slot name="header">
    <x-ppdb.header />
</x-slot>

<div class="min-h-[55vh]">
    <div class="mx-auto max-w-7xl">
        <div class="mt-12 flex flex-col px-5 2xl:px-0">
            <h1 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">Artikel terbaru</h1>
        </div>

        <div class="mt-12 grid grid-cols-12 gap-6">
            {{-- latest blog --}}
            <div class="col-span-12 px-5 xl:col-span-8">
                <div class="mb-5 flex flex-col">
                    @foreach ($this->posts as $post)
                        <div
                            class="mb-3 block w-full gap-3 rounded-lg bg-gray-50 p-5 duration-200 hover:bg-white hover:shadow dark:bg-gray-800 dark:hover:bg-gray-700 xl:flex xl:hover:scale-105">
                            <div class="flex xl:w-1/3">
                                <img src="{{ $post->thumbnail ? Storage::disk('minio_public')->url($post->thumbnail) : asset('images\thumbnails\images-dark.webp') }}"
                                    alt="{{ $post->title }}" class="h-48 w-full rounded-md object-cover xl:h-44">
                            </div>
                            <div class="flex xl:w-2/3">
                                <div class="w-full break-words pt-5">
                                    <div class="mb-2 mt-auto flex items-center gap-x-3">
                                        <img class="size-8 rounded-full"
                                            src="{{ $post->author->getFilamentAvatarUrl() ? $post->author->getFilamentAvatarUrl() : asset('images\thumbnails\images-dark.webp') }}"
                                            alt="{{ $post->author->name }}">
                                        <div>
                                            <h5 class="text-sm text-gray-800 dark:text-neutral-200">
                                                {{ $post->author->name }}
                                            </h5>
                                            <div class="text-xs font-semibold text-gray-500">
                                                {{ $post->published_at->translatedFormat('d F Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-xl font-bold">
                                        <a href="{{ route('posts.show', $post->slug) }}"
                                            class="text-xl font-semibold text-gray-800 hover:underline hover:underline-offset-1 group-hover:text-gray-600 dark:text-gray-200">{{ $post->title }}</a>
                                    </div>
                                    <div class="text-sm dark:text-gray-400">
                                        {{ str(strip_tags($post->content))->limit(140) }}
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('posts.show', $post->slug) }}"
                                            class="inline-flex items-center gap-x-1 text-sm font-semibold text-blue-600 decoration-2 hover:underline">
                                            {{ __('Read more') }}
                                            <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6" />
                                            </svg></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pb-6 md:pb-8 2xl:px-0">
                    {{ $this->posts->links() }}
                </div>
            </div>

            {{-- side menu --}}
            <aside class="col-span-12 pb-6 xl:col-span-4">
                <div class="px-5 pb-4 text-xl font-bold text-gray-800 dark:text-gray-200 xl:px-0">
                    Random artikel
                </div>
                <livewire:post.random />
            </aside>
        </div>
    </div>
</div>
