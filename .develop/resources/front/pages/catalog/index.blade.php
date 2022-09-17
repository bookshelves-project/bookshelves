<x-layouts.main>
  <x-content :content="$content">
    <div class="mx-auto mt-6 w-max">
      <x-steward-button :route="route('catalog.search')">
        Access to Catalog
      </x-steward-button>
    </div>
    <div class="mt-3">
      To access to Catalog from your eReader, just put this address to
      your web browser*:
      <pre>{{ route('catalog') }}</pre>
      <div class="mt-3">
        <small>
          *: Works only on phone, tablet or eReader.
        </small>
      </div>
    </div>
  </x-content>
</x-layouts.main>
