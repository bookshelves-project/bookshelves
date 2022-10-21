<div class="my-8">
  @if ($is_frame)
    <iframe
      src="{{ $url }}"
      width="{{ $width }}"
      height="{{ $height }}"
      title="{{ $title }}"
      allow="{{ $allow }}"
      frameborder="0"
      style="border: 0"
      scrolling="no"
      loading="lazy"
      allowfullscreen
    ></iframe>
  @endif

  @if ($is_open_graph)
    <x-open-graph
      :og="$this->getOpenGraph()"
      :margin="false"
    />
  @endif

  @if ($is_embedded)
    {!! $embedded !!}
  @endif

  <script>
    document.addEventListener('livewire:load', async () => {
      await @this.fetch()
    })
  </script>
</div>
