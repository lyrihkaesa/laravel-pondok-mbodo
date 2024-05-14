<x-slot name="header">
    <x-header :isScrolled="!(request()->is('ppdb*') || request()->is('blog/*'))" />
</x-slot>

@push('styles')
    @vite('resources/css/markdown.css')
@endpush

<section>
    @foreach ($this->publicPage->content as $block)
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
            <x-block.team.index :iteration="$loop->iteration">
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
        @elseif ($block['type'] === 'post')
            <livewire:block.post :iteration="$loop->iteration" :title="$block['data']['title']" :description="$block['data']['description']" :take="$block['data']['take']" />
        @elseif ($block['type'] === 'article')
            <x-block.article.index :iteration="$loop->iteration">
                <x-block.article.header>
                    @isset($block['data']['title'])
                        <x-block.article.title>{{ $block['data']['title'] }}</x-block.article.title>
                    @endisset
                    @if ($block['data']['url'] || $block['data']['sub_title'])
                        <x-block.article.sub-title>
                            @isset($block['data']['sub_title'])
                                {{ $block['data']['sub_title'] }}
                            @endisset
                            @isset($block['data']['url'])
                                <img src="{{ asset('storage/' . $block['data']['url']) }}" alt="{{ $block['data']['alt'] }}">
                            @endisset
                        </x-block.article.sub-title>
                    @endif
                </x-block.article.header>
                @isset($block['data']['body'])
                    <x-block.article.body>
                        {!! str($block['data']['body'])->markdown() !!}
                    </x-block.article.body>
                @endisset
            </x-block.article.index>
        @elseif ($block['type'] === 'hero')
            <x-block.hero.index :iteration="$loop->iteration">
                <x-block.hero.left>
                    <x-block.hero.title>{{ $block['data']['title'] }}<span
                            class="text-blue-600">{{ $block['data']['span_title'] }}</span>
                    </x-block.hero.title>
                    <x-block.hero.description>{{ $block['data']['description'] }}</x-block.hero.description>
                    <x-block.hero.button-layout>
                        <x-block.hero.button-primary
                            href="{{ $block['data']['primary_button_url'] }}">{{ $block['data']['primary_button'] }}</x-block.hero.button-primary>
                        <x-block.hero.button-secondary
                            href="{{ $block['data']['secondary_button_url'] }}">{{ $block['data']['secondary_button'] }}</x-block.hero.button-secondary>
                    </x-block.hero.button-layout>
                </x-block.hero.left>
                <x-block.hero.right>
                    <img class="w-full rounded-md" src="{{ asset('storage/' . $block['data']['image']) }}"
                        alt="{{ $block['data']['image_alt'] }}">
                </x-block.hero.right>
            </x-block.hero.index>
        @elseif ($block['type'] === 'article-a')
            <x-block.article-a.index :iteration="$loop->iteration">
                <div>
                    <x-block.article-a.title>
                        <span class="text-blue-600">{{ explode(' ', $block['data']['title_left'])[0] }}</span>
                        {{ implode(' ', array_slice(explode(' ', $block['data']['title_left']), 1)) }}
                    </x-block.article-a.title>
                    <div class="markdown article-a">
                        {!! str($block['data']['body_left'])->markdown() !!}
                    </div>
                </div>
                <!-- End Col -->

                <div>
                    <x-block.article-a.title>
                        <x-block.article-a.title>
                            <span class="text-blue-600">{{ explode(' ', $block['data']['title_right'])[0] }}</span>
                            {{ implode(' ', array_slice(explode(' ', $block['data']['title_right']), 1)) }}
                        </x-block.article-a.title>
                    </x-block.article-a.title>
                    <div class="markdown article-a">
                        {!! str($block['data']['body_right'])->markdown() !!}
                    </div>
                </div>
                <!-- End Col -->
            </x-block.article-a.index>
        @elseif ($block['type'] === 'team-b')
            {{-- @dd($block) --}}
            <livewire:block.team-b :iteration="$loop->iteration" :title="$block['data']['title']" :description="$block['data']['description']" :memberIds="$block['data']['member_id']" />
        @endif
    @endforeach

</section>
