<a href="{{ $route ? route($route, $routeParam) : $href }}" target="{{ $external || $href ? '_blank' : '' }}"
    rel="{{ $external || $href ? 'noopener noreferrer' : '' }}"
    {{ $attributes->merge(['class' => 'flex items-center']) }}>
    @if (\View::exists("components.icons.{$icon}"))
        <x-dynamic-component :component="'icons.'.$icon" class="w-6 h-6 mr-2" />
    @endif
    <span>
        @if (!$title)
            {{ $slot }}
        @else
            {{ $title }}
        @endif
    </span>
</a>
