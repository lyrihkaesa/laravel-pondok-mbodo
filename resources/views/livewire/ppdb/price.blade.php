<div class="mx-auto max-w-[85rem]">
    <div class="px-4 pt-4 lg:px-8 lg:pt-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Biaya Pendidikan</h3>
    </div>

    <div class="grid gap-y-4 px-4 py-4 md:grid-cols-3 md:gap-y-0 md:space-x-8 lg:px-8">
        <!-- Sidebar -->
        <div
            class="from-gray-50 dark:from-gray-950 md:col-span-1 md:h-full md:w-full md:bg-gradient-to-r md:via-transparent md:to-transparent">
            <div class="sticky start-0 top-0 pt-4 md:pt-6">
                <ul class="flex flex-col">
                    @foreach ($packages as $package)
                        <a class="-mt-px inline-flex items-center gap-x-2 border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-800 first:mt-0 first:rounded-t-lg last:rounded-b-lg hover:bg-gray-200 dark:border-gray-700 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800"
                            href="#{{ $package->id }}">
                            <li class="">
                                {{ $package->name }}
                            </li>
                        </a>
                    @endforeach

                </ul>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Content -->
        <div class="md:col-span-2">
            @foreach ($packages as $package)
                <x-ppdb.card :packageId="$package->id">
                    <x-ppdb.card-header>{{ $package->name }}</x-ppdb.card-header>
                    <x-ppdb.table>
                        @foreach ($package->products as $product)
                            <x-ppdb.table-tr :product="$product" />
                        @endforeach
                    </x-ppdb.table>
                    <x-ppdb.card-footer :total="$package->products->sum('price')" :count="$package->products->count()" />
                </x-ppdb.card>
            @endforeach
        </div>
        <!-- End Content -->
    </div>
</div>
