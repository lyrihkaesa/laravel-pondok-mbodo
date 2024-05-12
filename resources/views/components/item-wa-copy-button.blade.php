@props(['name', 'phone', 'message'])
<div class="mt-2">
    <div x-data="{
        isCopy: false,
        copy: function() {
            navigator.clipboard.writeText({{ $phone }});
            this.isCopy = true;
        },
    }"
        class="flex items-center justify-between rounded-md border border-gray-200 p-2 dark:border-gray-700">
        <span>{{ $name }}{{ $phone === '' ? '' : ': ' . $phone }}</span>
        @if ($phone !== '')
            <div class="flex items-center justify-end gap-1">
                <x-filament::icon-button icon="icon-whatsapp" class="fill-amber-400" tooltip="Whatsapp" size="lg"
                    href="https://wa.me/{{ $phone }}?text={{ rawurlencode($message) }}" tag="a"
                    target="_blank" />
                <x-filament::icon-button x-cloak x-show="!isCopy" tooltip="Salin Nomor" size="lg"
                    icon="heroicon-m-clipboard-document" color="warning" x-data x-on:click="copy();" />
                <x-filament::icon-button x-cloak x-show="isCopy" tooltip="Nomor Tersalin" size="lg"
                    icon="heroicon-m-clipboard-document-check" color="warning" x-data x-on:click="copy();" />
            </div>
        @endif
    </div>
</div>
