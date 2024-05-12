@props(['iteration' => 1])

@php
    $bgColorClass = App\Utilities\TailwindUtility::getBackgroundClass($iteration);
@endphp
{{-- Hero --}}
<section {!! $attributes->merge([
    'class' => 'mx-auto max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 lg:py-6' . $bgColorClass,
]) !!}>
    <div class="grid gap-4 md:grid-cols-2 md:items-center md:gap-8 xl:gap-20">
        {{ $slot }}
    </div>
</section>
{{-- End Hero --}}
