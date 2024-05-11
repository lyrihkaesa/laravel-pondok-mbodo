@php
    // Tentukan warna latar belakang berdasarkan iterasi
    if ($iteration % 3 === 0) {
        $bgColorClass = 'bg-gray-50 dark:bg-gray-900';
    } elseif ($iteration % 2 === 0) {
        $bgColorClass = 'bg-gray-100 dark:bg-gray-800';
    } else {
        $bgColorClass = 'bg-gray-200 dark:bg-gray-700';
    }
@endphp

{{-- Contact --}}
<section class="{{ $bgColorClass }} mx-auto max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
    @isset($title)
        <!-- Title -->
        <div class="mx-auto mb-5 max-w-2xl text-center lg:mb-10">
            <h2 class="text-2xl font-bold dark:text-white md:text-4xl md:leading-tight">{{ $title }}</h2>
            @isset($description)
                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $description }}</p>
            @endisset
        </div>
        <!-- End Title -->
    @endisset

    @php
        $user = auth()->user();
    @endphp

    <!-- Grid -->
    <div class="grid grid-cols-2 gap-8 md:grid-cols-3 md:gap-12">
        @foreach ($members as $member)
            <div class="text-center">
                <img class="sm:size-48 lg:size-60 mx-auto rounded-xl"
                    src="{{ $member->profile_picture_1x1 ? asset('storage/' . $member->profile_picture_1x1) : asset('images\thumbnails\images-dark.webp') }}"
                    alt="{{ $member->name }}">
                <div class="mt-2 sm:mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
                        {{ $member->name }}
                    </h3>
                    @if (
                        $member->phone_visibility->value === 'public' ||
                            ($member->phone_visibility->value === 'member' && $user) ||
                            ($member->phone_visibility->value === 'private' && $user?->hasRole('pengurus')))
                        <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                            {{ $member->phone }}
                        </p>
                    @endif
                </div>
            </div>
            <!-- End Col -->
        @endforeach
    </div>
    <!-- End Grid -->
</section>
{{-- End-Contact --}}
