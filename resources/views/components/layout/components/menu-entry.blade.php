<a href="{{ $link['route'] ? route($link['route'], array_key_exists('parameters', $link) ? $link['parameters'] : []) : $link['href'] }}"
    target="{{ $link['external'] ? '_blank' : '' }}" rel="{{ $link['external'] ? 'noopener noreferrer' : '' }}"
    class="text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 justify-between {{ $link['route'] ? (Request::fullUrl() === route($link['route'], array_key_exists('parameters', $link) ? $link['parameters'] : []) ? 'bg-gray-300 dark:bg-gray-900' : '') : '' }}">
    <div class="flex items-center">
        @isset($link['icon'])
            <x-dynamic-component component="{{ 'icon-' . $link['icon'] }}"
                class="text-gray-700 dark:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" />
        @endisset
        {{ $slot }} {{ $link['title'] }}
    </div>
    @if ($link['external'])
        <x-icon-external class="w-4 h-4 text-gray-700 dark:text-gray-300" />
    @endif
</a>
