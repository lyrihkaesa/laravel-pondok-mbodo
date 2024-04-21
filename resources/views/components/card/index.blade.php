@props(['id'])

<div>
    @isset($id)
        <div id="{{ $id }}" class="pt-2"></div>
    @endisset
    <!-- Table Section -->
    <div class="pb-4">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="inline-block min-w-full p-1.5 align-middle">
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-slate-900">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->
</div>
