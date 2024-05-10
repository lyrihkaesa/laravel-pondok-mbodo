<div class="hs-dropdown relative [--adaptive:none] [--strategy:static] sm:[--strategy:absolute]">
    <button type="button"
        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
        {{ $label }}
        <svg class="size-4 ms-2 flex-shrink-0 text-gray-600 sm:-rotate-90" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>
    <div
        class="hs-dropdown-menu end-full top-0 z-10 !mx-[10px] hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-end-5 before:top-0 before:h-full before:w-5 hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:mt-2 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border">
        {{ $slot }}
    </div>
</div>
