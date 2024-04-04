@props(['product'])

<tr>
    <td class="h-px w-72 whitespace-nowrap text-start">
        <div class="px-6 py-3">
            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</span>
            <span x-data="{ term: '{{ $product->payment_term }}' }"
                x-bind:class="{
                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-500': term === 'Bulanan',
                    'bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500': term === 'Sekali',
                    'bg-pink-100 text-pink-800 dark:bg-pink-500/10 dark:text-pink-500': term !== 'Bulanan' &&
                        term !== 'Sekali'
                }"
                class="inline-flex items-center gap-x-1 rounded-full px-1.5 py-1 text-xs font-medium" x-text="term">
            </span>


        </div>
    </td>
    <td class="h-px w-72 whitespace-nowrap text-end">
        <div class="px-6 py-3">
            <span
                class="block text-sm font-semibold text-gray-800 dark:text-gray-200">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
    </td>
</tr>
