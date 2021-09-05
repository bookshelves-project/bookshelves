<a href="{{ route($link['route'], array_key_exists('parameters', $link) ? $link['parameters'] : []) }}"
    target="{{ $link['external'] ? '_blank' : '' }}" rel="{{ $link['external'] ? 'noopener noreferrer' : '' }}"
    class="text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 {{ Request::fullUrl() === route($link['route'], array_key_exists('parameters', $link) ? $link['parameters'] : []) ? 'bg-gray-300 dark:bg-gray-900' : '' }}">
    @isset($link['icon'])
        <x-dynamic-component component="{{ 'icon-' . $link['icon'] }}"
            class="text-gray-700 dark:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" />
    @endisset
    {{ $slot }} {{ $link['title'] }}
</a>
