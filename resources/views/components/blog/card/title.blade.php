<h3 {!! $attributes->merge([
    'class' => 'text-xl font-semibold text-gray-800 group-hover:text-gray-600 dark:text-gray-200',
]) !!}>
    {{ $slot }}
</h3>
