<x-layout.front
  :features="false"
  :developer="false"
>
  <div class="pt-10 sm:pt-0">
    <div class="text-white sm:absolute sm:top-1/2 sm:left-1/2 sm:-translate-y-1/2 sm:-translate-x-1/2 sm:transform">
      <div class="flex">
        <div class="font-handlee max-content mx-auto flex items-center space-x-2 text-xl sm:text-3xl">
          <x-icon.logo class="h-6 w-6 text-white sm:h-10 sm:w-10" />
          <span>{{ config('app.name') }}</span>
        </div>
      </div>
      <div class="mx-auto mt-6 max-w-lg">
        @include('front::components.nav.features')
        @include('front::components.nav.developer')
      </div>
    </div>
  </div>
</x-layout.front>
