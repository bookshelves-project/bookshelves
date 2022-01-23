<a href="{{ $link->route ? route($link->route, property_exists($link, 'parameters') ? (array) $link->parameters : []) : $link->href }}"
    target="{{ $link->external ? '_blank' : '' }}" rel="{{ $link->external ? 'noopener noreferrer' : '' }}"
    {{ $attributes }}>
    @if (!$title)
        {{ $slot }}
    @else
        {{ $link->title }}
    @endif
</a>
