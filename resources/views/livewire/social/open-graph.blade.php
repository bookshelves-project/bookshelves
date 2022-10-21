<div>
  @if ($loaded)
    <div
      @class(['mx-auto max-w-lg', 'my-8' => $margin])
      title="{{ $title }}"
    >
      <a
        href="{{ $site_url }}"
        target="_blank"
        rel="noopener noreferrer"
        class="relative block rounded-md border border-gray-200 bg-gray-50 p-3 text-gray-900 no-underline dark:border-gray-700 dark:bg-gray-800 dark:text-gray-50"
      >
        <div
          style="background-color: {{ $theme_color }}"
          class="absolute inset-y-0 left-0 h-full w-1 rounded-md"
        ></div>
        <div class="px-2">
          <div class="text-sm line-clamp-1">
            {{ $site_name }}
          </div>
          <div class="mt-1 text-gray-800 underline line-clamp-2 dark:text-gray-100">
            {{ $title }}
          </div>
          <div class="mt-2 text-sm line-clamp-5">
            {{ $description }}
          </div>
          @if ($image)
            <img
              src="{{ $image }}"
              class="mb-0 h-32 w-full rounded-md object-cover"
              loading="lazy"
              onerror="this.style.display = 'none'"
            >
          @endif
        </div>
      </a>
    </div>
  @endif
  <script>
    document.addEventListener('livewire:load', async () => {
      if (!@this.get('sync')) {
        await @this.fetchData()
      }
      let image = @this.get('image')
      console.log(image);
    })
  </script>
</div>
