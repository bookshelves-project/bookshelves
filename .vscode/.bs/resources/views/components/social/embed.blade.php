<div
  x-data="embed"
  x-init="boot(@js($key))"
  class="text-gray-900 dark:text-gray-50"
>
  <div
    x-ref="url"
    class="hidden"
  >{{ $url }}</div>
  <div>
    {{ $type }}
  </div>
  <div>
    {{ $url }}
  </div>
  {!! $html !!}
  <div align="center">
    <div id="{{ $key }}"></div>
  </div>
</div>
