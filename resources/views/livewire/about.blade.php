<x-slot name="header">
    <x-header />
</x-slot>

<section>
    @foreach ($publicPage->content as $block)
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
            <livewire:block.post :take="$block['data']['take']" :title="$block['data']['title']" :description="$block['data']['description']" :iteration="$loop->iteration" />
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
        @endif
    @endforeach
</section>
