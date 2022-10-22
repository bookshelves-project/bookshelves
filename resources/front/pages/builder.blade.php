<x-layout.front>
  <div class="prose-lg prose mx-auto">
    @php
      $embed_medias = [
          'youtube_HYQN8XXgOkw' => 'https://www.youtube.com/watch?v=HYQN8XXgOkw',
          'youtube_aFPQftLJHZw' => 'https://youtu.be/aFPQftLJHZw',
          'twitter_1506281613746917394' => 'https://twitter.com/Steve8708/status/1506281613746917394',
      ];
    @endphp
    {{-- <livewire:social.embed url="https://player.vimeo.com/video/161110645?h=e46badf906" /> --}}
    {{-- <livewire:social.embed url="https://www.instagram.com/p/BC2_hmZh4K7" /> --}}
    {{-- <livewire:social.open-graph url="https://twitter.com/la_briochee_off/status/1581733181551955968" /> --}}
    {{-- <livewire:social.open-graph url="https://github.com" /> --}}
    {{-- <livewire:social.open-graph url="https://laravel-livewire.com" /> --}}
    {{-- <livewire:social.embed url="https://github.com" /> --}}
    {{-- <livewire:social.embed url="https://www.dailymotion.com/embed/video/x8elgz7" /> --}}
    {{-- <livewire:social.embed url="https://www.dailymotion.com/video/x8elgz7" /> --}}
    {{-- <livewire:social.twitter url="https://twitter.com/Steve8708/status/1506281613746917394" /> --}}

    {{-- <livewire:social.embed url="https://open.spotify.com/track/6xMpUNOfaSkyywPiFFXZFh" /> --}}
    {{-- <livewire:social.embed url="https://player.vimeo.com/video/161110645?h=e46badf906" /> --}}
    {{-- <livewire:social.embed url="https://open.spotify.com/track/3tlkmfnEvrEyL35tWnqHYl?si=96d4c52f62684f31" /> --}}
    {{-- <livewire:social.instagram url="https://www.instagram.com/p/CjcnkEXMmSI" /> --}}
    {{-- <livewire:social.embed url="https://www.instagram.com/p/CjcnkEXMmSI" /> --}}
    {{-- <livewire:social.embed url="https://www.facebook.com/operadeparis/videos/536238788377856" /> --}}
    {{-- <livewire:social.embed
      latitude="48.117266"
      longitude="-1.6777926"
      google-map
    /> --}}

    @foreach ($embed_medias as $type => $embed)
      <div>
        <div>{{ $type }}</div>
        <livewire:social.embed url="{{ $embed }}" />
      </div>
    @endforeach

    <script
      async
      defer
      src="https://platform.twitter.com/widgets.js"
      charset="utf-8"
    ></script>
  </div>
</x-layout.front>
