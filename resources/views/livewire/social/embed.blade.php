<div class="my-8">
  {{-- @dump($this) --}}
  @if ($loaded)
    @if ($is_frame)
      <div align="center">
        <iframe
          src="{{ $url }}"
          width="{{ $width }}"
          height="{{ $height }}"
          title="{{ $title }}"
          style="border:none"
          scrolling="no"
          frameborder="0"
          allowfullscreen
          allow="{{ $allow }}"
          loading="lazy"
        ></iframe>
      </div>
    @endif

    @if ($is_open_graph)
      <div>
        <livewire:social.open-graph
          :url="$url"
          :margin="false"
          sync
        />
      </div>
    @endif

    @if ($is_custom)
      <livewire:is
        :component="$custom"
        :url="$url"
      >
    @endif
  @endif
  <script>
    document.addEventListener('livewire:load', async () => {
      await @this.fetchData()
    })
  </script>
</div>
