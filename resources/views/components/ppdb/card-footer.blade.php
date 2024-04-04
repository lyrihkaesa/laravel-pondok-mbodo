@props(['total', 'count'])

<!-- Footer -->
<div
    class="grid gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-700 md:flex md:items-center md:justify-between">
    <div>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $count }}</span> results
        </p>
    </div>

    <div class="font-semibold text-gray-800 dark:text-gray-200">
        Total: Rp{{ number_format($total, 0, ',', '.') }},-
    </div>
</div>
<!-- End Footer -->
