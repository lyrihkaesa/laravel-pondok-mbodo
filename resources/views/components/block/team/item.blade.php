@props(['role', 'imageAlt', 'imageUrl'])

<div class="text-center">
    <img class="sm:size-48 lg:size-60 mx-auto rounded-xl" src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
    <div class="mt-2 sm:mt-4">
        <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 sm:text-base lg:text-lg">
            {{ $slot }}
        </h3>
        @isset($role)
            <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm lg:text-base">
                {{ $role }}
            </p>
        @endisset
    </div>
</div>
<!-- End Col -->
