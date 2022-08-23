@if ($download)
    <a href="{{ $downloadLink }}" download
        {{ $attributes->merge(['class' => 'transition-colors duration-75 border rounded-md hover:border-white border-transparent']) }}>
        @if (\View::exists("components.icons.{$icon}"))
            <x-dynamic-component :component="'icons.' . $icon" class="w-10 h-10 p-2" />
        @endif
    </a>
@else
    <button {{ $attributes->merge(['class' => 'relative']) }}>
        <div :class="[
            {{ $action }} ? 'bg-gray-600 !bg-opacity-75 border-white' : 'border-transparent',
            'transition-colors duration-75 border rounded-md hover:border-white',
        ]">
            @if (\View::exists("components.icons.{$icon}"))
                <x-dynamic-component :component="'icons.' . $icon" class="w-10 h-10 p-2" />
            @endif
        </div>
    </button>
@endif
