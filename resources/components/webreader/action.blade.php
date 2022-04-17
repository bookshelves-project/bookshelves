<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div
        :class="[{{ $action }} ? 'bg-gray-600 !bg-opacity-75 border-white' : 'border-transparent', 'transition-colors duration-75 border-2 rounded-md']">
        @if (\View::exists("components.icons.{$icon}"))
            <x-dynamic-component :component="'icons.' . $icon"
                class="w-10 h-10 hover:bg-gray-600 hover:bg-opacity-70 transition-colors duration-75 p-2 rounded-md relative z-10" />
        @endif
    </div>
</div>
