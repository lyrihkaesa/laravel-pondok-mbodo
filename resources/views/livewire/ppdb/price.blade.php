<x-slot name="header">
    <x-ppdb.header />
</x-slot>

<div class="mx-auto max-w-[85rem]">
    <div class="px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Biaya Pendidikan</h3>
    </div>
    <div class="grid grid-cols-1 px-4 sm:px-6 md:grid-cols-4 md:gap-4 lg:px-8">
        <div class="md:col-span-3">
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

        <div class="hidden pt-2 md:col-span-1 md:block">
            <ul class="flex max-w-xs flex-col">
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
</div>
