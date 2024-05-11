<a {!! $attributes->merge([
    'class' =>
        'inline-flex items-center justify-center gap-x-2 rounded-lg border border-transparent bg-teal-600 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-700 disabled:pointer-events-none disabled:opacity-50',
]) !!}>
    {{ $slot }}
    <svg class="size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6" />
    </svg>
</a>
