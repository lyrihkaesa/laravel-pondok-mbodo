<div class="flex w-full items-center justify-end gap-x-3 py-2 sm:gap-x-5">
    {{-- <x-topbar.link href="">Alumni</x-topbar.link> --}}
    @foreach ($items as $item)
        @if ($item['type'] === 'link')
            <x-topbar.link href="{{ $item['href'] }}">{{ $item['slot'] }}</x-topbar.link>
        @elseif ($item['type'] === 'icon')
            <x-topbar.link-icon target="_blank" href="{{ $item['href'] }}">@svg($item['slot'])</x-topbar.link-icon>
        @elseif ($item['type'] === 'h-divinder')
            <x-topbar.h-divinder />
        @endif
    @endforeach
</div>
