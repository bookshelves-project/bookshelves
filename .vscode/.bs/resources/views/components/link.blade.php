<a
  href="{{ $route ? route($route, $routeParam) : $href }}"
  target="{{ $external || $href ? '_blank' : '' }}"
  rel="{{ $external || $href ? 'noopener noreferrer' : '' }}"
  {{ $attributes->merge(['class' => 'flex items-center']) }}
>
  @if (\View::exists("components.icon.{$icon}"))
    <x-dynamic-component
      :component="'icon.' . $icon"
      class="mr-2 h-6 w-6"
    />
  @endif
  <span>
    @if (!$title)
      {{ $slot }}
    @else
      {{ $title }}
    @endif
  </span>
</a>
