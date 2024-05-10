<a {!! $attributes->merge([
    'class' =>
        'font-medium text-gray-600 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600',
]) !!}>{{ $slot }}</a>
