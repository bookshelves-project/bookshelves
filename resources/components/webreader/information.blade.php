<div x-show="$store.webreader.informationEnabled"
    class="fixed z-20 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform bg-gray-900 p-6 rounded-md shadow max-w-lg">
    <h2 class="text-lg mb-2">
        {{ $book->full_title }}
    </h2>
    <p>
        You progression is automatically saved but you can remove it with trash icon.
    </p>
    <ul class="list-none list-inside space-y-2">
        <template x-for="command in $store.webreader.commands">
            <li>
                <template x-for="key in command.key">
                    <span x-text="key" class="bg-gray-700 px-2 py-0.5 rounded-md mr-1"></span>
                </template>
                <span x-text="command.label"></span>
            </li>
        </template>
    </ul>
    <div class="text-sm mt-2 text-right">
        {{ config('app.name') }} Webreader
    </div>
</div>
