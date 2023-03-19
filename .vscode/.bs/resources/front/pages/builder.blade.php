<x-layout.front>
  <div class="prose-lg prose mx-auto">
    @php
      $embed_medias = [
          // 'youtube_HYQN8XXgOkw' => 'https://www.youtube.com/watch?v=HYQN8XXgOkw',
          // 'youtube_aFPQftLJHZw' => 'https://youtu.be/aFPQftLJHZw',
          'twitter_1506281613746917394' => 'https://twitter.com/Steve8708/status/1506281613746917394',
          // 'facebook_536238788377856' => 'https://www.facebook.com/operadeparis/videos/536238788377856',
          'instagram_CjcnkEXMmSI' => 'https://www.instagram.com/p/CjcnkEXMmSI',
          'dailymotion_x8elgz7' => 'https://www.dailymotion.com/video/x8elgz7',
          'open_graph_1' => 'https://github.com',
          'twitter_1581733181551955968' => 'https://twitter.com/la_briochee_off/status/1581733181551955968',
          'spotify_6xMpUNOfaSkyywPiFFXZFh' => 'https://open.spotify.com/track/6xMpUNOfaSkyywPiFFXZFh',
          // 'vimeo_161110645' => 'https://player.vimeo.com/video/161110645?h=e46badf906',
          // 'flickr_2nSa681' => 'https://flic.kr/p/2nSa681',
          'flickr_52424722168' => 'https://www.flickr.com/photos/jmlpyt/52424722168',
          'tiktok_7155146642000219398' => 'https://www.tiktok.com/@mrnatasmr/video/7155146642000219398',
      ];
    @endphp
    {{-- <livewire:social.open-graph url="https://twitter.com/la_briochee_off/status/1581733181551955968" /> --}}
    {{-- @foreach ($embed_medias as $type => $embed)
      <div>
        <div>{{ $type }}</div>
        <livewire:social.embed url="{{ $embed }}" />
      </div>
    @endforeach --}}

    @foreach ($embed_medias as $type => $embed)
      <div>
        <div>{{ $type }}</div>
        <x-social.embed :url="$embed" />
      </div>
    @endforeach

    {{-- <livewire:social.embed
      latitude="48.117266"
      longitude="-1.6777926"
      google-map
    /> --}}

    {{-- <script
      async
      src="//embedr.flickr.com/assets/client-code.js"
      charset="utf-8"
    ></script> --}}
    {{-- <script
      async
      src="//www.instagram.com/embed.js"
    ></script> --}}
  </div>
</x-layout.front>
