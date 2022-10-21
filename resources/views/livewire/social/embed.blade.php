<div class="my-8">
  @if ($loaded)
    @if ($is_frame)
      <iframe
        src="{{ $url }}"
        width="{{ $width }}"
        height="{{ $height }}"
        title="{{ $title }}"
        allow="{{ $allow }}"
        frameborder="0"
        style="border: 0"
        loading="lazy"
        allowfullscreen
      ></iframe>
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
  @endif


  {{-- <script
    async
    src="https://www.instagram.com/embed.js"
  ></script> --}}
  <script>
    document.addEventListener('livewire:load', async () => {
      await @this.fetchData()
    })
  </script>
</div>
