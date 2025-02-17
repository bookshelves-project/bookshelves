<script lang="ts" setup>
const features: {
  icon: string
  title: string
  text: string
}[] = [
  {
    icon: 'download',
    title: 'Fast download',
    text: 'Powered by Nitro, the download speed is faster than ever. Download your favorite books and series in seconds.',
  },
  {
    icon: 'magnifying-glass',
    title: 'Blazing fast search',
    text: 'Powered by MeiliSearch, the search engine is blazing fast. Find your favorite books and series before you finish typing.',
  },
  {
    icon: 'paint',
    title: 'Ergonomic design',
    text: 'Bookshelves offer a clean and ergonomic design. You can easily find what you are looking for.',
  },
]
</script>

<template>
  <div class="py-8 sm:py-10">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:text-center">
        <h2 class="text-base/7 font-semibold text-indigo-300">
          What do you want?
        </h2>
        <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-100 sm:text-5xl lg:text-balance">
          Rediscover freedom
        </p>
        <p class="mt-6 text-lg/8 text-gray-300">
          Kiwiflix is at your service, offering hundreds of films and series for direct download.
        </p>
      </div>
      <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
          <div
            v-for="feature in features"
            :key="feature.icon"
            class="flex flex-col"
          >
            <dt class="flex items-center gap-x-3 text-base/7 font-semibold text-gray-100">
              <SvgIcon
                class="size-5 flex-none text-indigo-300"
                :name="feature.icon"
              />
              {{ feature.title }}
            </dt>
            <dd class="mt-4 flex flex-auto flex-col text-base/7 text-gray-300">
              <p class="flex-auto">
                {{ feature.text }}
              </p>
              <!-- <p class="mt-6">
                <a
                  href="#"
                  class="text-sm/6 font-semibold text-indigo-300"
                >Learn more <span aria-hidden="true">→</span></a>
              </p> -->
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>
