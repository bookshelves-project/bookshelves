<x-layouts.app>
  <main class="relative h-full min-h-screen lg:grid">
    <div class="pt-10 lg:pt-0">
      <div class="text-white lg:absolute lg:top-1/2 lg:left-1/2 lg:-translate-y-1/2 lg:-translate-x-1/2 lg:transform">
        <div class="flex">
          <div class="font-handlee max-content mx-auto flex items-center space-x-2 text-xl lg:text-3xl">
            <x-icon.bookshelves class="text-primary-600 h-6 w-6 lg:h-10 lg:w-10" />
            <span>{{ config('app.name') }}</span>
          </div>
        </div>
        <div class="mx-auto mt-6 max-w-lg">
          <ul
            role="list"
            class="justify-center lg:flex lg:flex-wrap"
          >
            @foreach (config('bookshelves.navigation.features') as $route)
              <x-link
                :data="$route"
                class="!lg:mx-2 max-content !mx-auto rounded-md p-2 text-base text-gray-400 hover:bg-gray-800 hover:text-gray-300"
              />
            @endforeach
          </ul>
          <div class="mx-auto mt-3 max-w-sm border-t border-gray-600"></div>
          <nav
            class="mt-3 justify-center lg:flex lg:flex-wrap"
            aria-label="Footer"
          >
            @foreach (config('bookshelves.navigation.footer') as $route)
              <x-link
                :data="$route"
                class="!lg:mx-2 max-content !mx-auto rounded-md p-2 text-base text-gray-400 hover:bg-gray-800 hover:text-gray-300"
              />
            @endforeach
          </nav>
        </div>
      </div>
    </div>
    <x-layouts.footer class="lg:row-start-2 lg:row-end-3" />
  </main>
</x-layouts.app>
