<a wire:navigate
    {{ $attributes->twMerge(['class' => 'flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300']) }}>
    {{ $slot }}
</a>
