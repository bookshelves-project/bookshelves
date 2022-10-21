@if (!$og->isEmpty())
  <div
    @class(['mx-auto max-w-lg', 'my-8' => $margin])
    title="{{ $og->title }}"
  >
    <a
      href="{{ $og->url }}"
      target="_blank"
      class="relative block rounded-md border border-gray-200 bg-gray-50 p-3 text-gray-900 no-underline dark:border-gray-700 dark:bg-gray-800 dark:text-gray-50"
    >
      @php
        /** @var \Kiwilan\Steward\Services\OpenGraphService\OpenGraphItem $og */
      @endphp
      <div
        style="background-color: {{ $og->theme_color }}"
        class="absolute inset-y-0 left-0 h-full w-1 rounded-md"
      ></div>
      <div class="px-2">
        <div class="text-sm">
          {{ $og->site_name }}
        </div>
        <div class="mt-1 text-gray-800 underline dark:text-gray-100">
          {{ $og->title }}
        </div>
        <div class="mt-2 text-sm">
          {{ $og->description }}
        </div>
        @if ($og->image)
          <img
            src="{{ $og->image }}"
            alt=""
            class="mb-0 h-32 w-full rounded-md object-cover"
          >
        @endif
      </div>
    </a>
  </div>
@endif
