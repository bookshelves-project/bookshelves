@foreach (config('bookshelves.navigation.user') as $link)
    <x-layout.components.menu-entry :link="$link" />
@endforeach
<hr class="border-gray-300 dark:border-gray-600 my-2" />
<div class="ml-2 font-semibold my-3 dark:text-gray-100">
    For developers
</div>
@foreach (config('bookshelves.navigation.dev') as $link)
    <x-layout.components.menu-entry :link="$link" />
@endforeach
@isset($links)
    <hr class="border-gray-300 dark:border-gray-600 my-2" />
    <div class="ml-2 mt-5">
        <div class="text-xl font-semibold">
            Other pages
        </div>
        <div class="ml-3 mt-3">
            @foreach ($links as $key => $link)
                <x-layout.components.menu-entry :link="$link">
                    {{ $key + 1 }}.
                </x-layout.components.menu-entry>
            @endforeach
        </div>
    </div>
@endisset
