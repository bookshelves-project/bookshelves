<x-layouts.sidebar :links="$links">
    <x-title>
        {{ config('app.name') }}
        Development{{ SEO::getTitle(true) !== 'Features' ? ': ' . SEO::getTitle(true) : '' }}
    </x-title>
    <x-content :content="$content" />
</x-layouts.sidebar>
