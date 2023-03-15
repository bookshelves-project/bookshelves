<x-layouts.webreader>
  <div class="p-6 text-center">
    {{ config('app.name') }} can't read this format now.
    <x-steward-button :route="$url">
      Download
    </x-steward-button>
  </div>
</x-layouts.webreader>
