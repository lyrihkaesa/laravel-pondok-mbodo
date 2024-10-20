<div>
    <h1 class="text-base font-medium leading-6 text-gray-950 dark:text-white">
        {{ $title }}
    </h1>
    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        <p>{{ $description }}</p>
        @php
            $user = auth('web')->user();
        @endphp

        @foreach ($this->members as $member)
            @php
                $phone =
                    $member->phone_visibility->value === 'public' ||
                    ($member->phone_visibility->value === 'member' && $user) ||
                    ($member->phone_visibility->value === 'private' && $user?->hasRole('pengurus'))
                        ? $member->phone
                        : '';
            @endphp
            <x-item-wa-copy-button name="{{ $member->name }}" phone="{{ $phone }}"
                message="{{ str($whatsappMessage)->replace(':name', $member->name) }}" />
        @endforeach
    </div>
</div>
