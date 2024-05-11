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
        @endif
    @endforeach
</section>
