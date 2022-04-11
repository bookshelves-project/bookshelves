<x-layouts.webreader>
    <div class="p-6 text-center">
        {{ config('app.name') }} can't read this format now.
        <x-button :route="$download_link">
            Download
        </x-button>
    </div>
</x-layouts.webreader>
