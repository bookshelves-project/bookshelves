<x-layouts.app>
    <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-12">
        <x-title class="text-center">
            {{ config('app.name') }}
            {{ request()->route()->getName() !== 'front.home'? ': ' . SEO::getTitle(true): '' }}
        </x-title>
        <div class="space-y-4">
            <x-button :href="config('app.front_url')">
                Back to {{ config('app.name') }}
            </x-button>
            <div>{{ $slot }}</div>
        </div>
    </div>
    <div class="mt-auto">
        <x-layouts.footer class="mt-auto" />
    </div>
</x-layouts.app>
