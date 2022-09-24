<x-link
  :object="$route"
  class="relative rounded-lg bg-gray-800 py-8 px-6 text-center transition-colors duration-75 hover:bg-gray-700 xl:px-8 xl:text-left"
>
  <div class="flex h-full flex-col">
    <x-dynamic-component
      :component="'icons.' . $route->icon"
      class="mx-auto h-16 w-16 text-white xl:h-32 xl:w-32"
    />
    <div class="mt-8 space-y-5 xl:flex xl:items-center xl:justify-between">
      <div class="space-y-3 text-lg font-medium leading-6">
        <h3 class="text-center text-3xl font-semibold text-white">
          {{ $route->title }}
        </h3>
        <div class="text-sm italic text-gray-400">
          {{ $route->description }}
        </div>
      </div>
    </div>
    <div class="mt-auto ml-auto">
      <x-icon.arrow-sm-right class="ml-auto h-10 w-10 text-white" />
    </div>
  </div>
</x-link>
