<x-layouts.app>
  <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:px-8 lg:py-12">
    <x-title class="text-center">
      {{ config('app.name') }}
      {{ request()->route()->getName() !== 'front.home'? ': ' . SEO::getTitle(true): '' }}
    </x-title>
    <div class="space-y-4">
      <x-steward-button :href="config('app.front_url')">
        Back to {{ config('app.name') }}
      </x-steward-button>
      <div>{{ $slot }}</div>
    </div>
  </div>
  <div class="mt-auto">
    <x-layouts.footer class="mt-auto" />
  </div>
</x-layouts.app>
