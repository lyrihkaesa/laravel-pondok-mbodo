{{-- Navbar Item Dropdown --}}
<div class="hs-dropdown [--adaptive:none] [--strategy:static] sm:[--strategy:fixed]">
    <button id="hs-mega-menu-basic-dr" type="button"
        class="flex w-full items-center font-medium text-gray-600 hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-500">
        {{ $label }}
        <svg class="size-4 ms-1 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div class="hs-dropdown-menu top-full z-10 hidden rounded-lg bg-white p-2 opacity-0 transition-[opacity,margin] duration-[0.1ms] before:absolute before:-top-5 before:start-0 before:h-5 before:w-full hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-800 sm:w-48 sm:border sm:shadow-md sm:duration-[150ms] sm:dark:border"
        style="">
        {{ $slot }}
    </div>
</div>
{{-- End Navbar Item Dropdown --}}
