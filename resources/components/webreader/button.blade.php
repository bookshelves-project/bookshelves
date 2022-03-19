@if ($link)
    <a href="{{ $link }}" id="{{ $id }}"
        class="hover:bg-gray-300 transition-colors duration-100 block p-3 text-gray-800">
        <span class="my-auto">
            {{-- <x-dynamic-component :component="'icons.' . $icon" class="w-6 h-6" /> --}}
            {{ $id }}
        </span>
    </a>
@else
    <button id="{{ $id }}" class="hover:bg-gray-300 transition-colors duration-100 block p-3 text-gray-800">
        <span class="my-auto">
            {{-- <x-dynamic-component :component="'icons.' . $icon" class="w-6 h-6" /> --}}
            {{ $id }}
        </span>
    </button>
@endif
