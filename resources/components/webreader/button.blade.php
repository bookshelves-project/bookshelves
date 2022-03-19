@if ($link)
    <a x-ref="{{ $id }}" href="{{ $link }}" id="{{ $id }}"
        class="hover:bg-gray-300 transition-colors duration-100 block p-3 text-gray-800">
        <span class="my-auto">
            <x-dynamic-component :component="'icons.' . $icon" class="w-6 h-6" />
        </span>
    </a>
@else
    <button x-ref="{{ $id }}" id="{{ $id }}"
        class="hover:bg-gray-300 transition-colors duration-100 block p-3 text-gray-800">
        <span class="my-auto">
            <x-dynamic-component :component="'icons.' . $icon" class="w-6 h-6" />
        </span>
    </button>
@endif
