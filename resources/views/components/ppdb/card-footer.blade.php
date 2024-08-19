@props(['total', 'count'])

<!-- Footer -->
<div class="flex items-center justify-between border-t border-gray-200 px-4 py-2 dark:border-gray-700 md:px-6 md:py-4">
    <div>
        <p class="text-xs text-gray-600 dark:text-gray-400 md:text-sm">
            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $count }}</span> results
        </p>
    </div>

    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200 md:text-base">
        Total: Rp {{ number_format($total, 0, ',', '.') }}
    </div>
</div>
<!-- End Footer -->
