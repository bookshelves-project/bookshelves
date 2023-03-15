<x-layouts.main :route="route('front.home')">
  <x-content :content="$content">
    @isset($route)
      <div class="mx-auto mt-6 w-max">
        <x-steward-button :route="$route">
          Try random book now
        </x-steward-button>
      </div>
    @endisset
  </x-content>
</x-layouts.main>
