@props(['iteration' => 1])

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

<section {!! $attributes->merge([
    'class' => 'mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14' . $bgColorClass,
]) !!}>
    {{ $slot }}
</section>
