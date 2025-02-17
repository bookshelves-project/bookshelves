<script lang="ts" setup>
import { useHomeHeroStore } from '@/Stores/home-hero'
import { useFetch } from '@kiwilan/typescriptable-laravel'

const hero = useHomeHeroStore()

async function asyncData() {
  if (hero.ready) {
    return
  }

  const { laravel } = useFetch()
  const res = await laravel.get('api.live.random-covers')
  const body = await res.getBody<string[]>()
  if (!body) {
    console.warn('Failed to fetch random posters')
    return
  }

  hero.setPosters(body)
}

onMounted(() => {
  asyncData()
})
</script>

<template>
  <div>
    <main>
      <div class="relative isolate">
        <svg
          class="absolute inset-x-0 top-0 -z-10 h-[64rem] w-full stroke-gray-700 [mask-image:radial-gradient(32rem_32rem_at_center,white,transparent)]"
          aria-hidden="true"
        >
          <defs>
            <pattern
              id="1f932ae7-37de-4c0a-a8b0-a6e3b4d44b84"
              width="200"
              height="200"
              x="50%"
              y="-1"
              patternUnits="userSpaceOnUse"
            >
              <path
                d="M.5 200V.5H200"
                fill="none"
              />
            </pattern>
          </defs>
          <svg
            x="50%"
            y="-1"
            class="overflow-visible fill-gray-800"
          >
            <path
              d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z"
              stroke-width="0"
            />
          </svg>
          <rect
            width="100%"
            height="100%"
            stroke-width="0"
            fill="url(#1f932ae7-37de-4c0a-a8b0-a6e3b4d44b84)"
          />
        </svg>
        <div
          class="absolute left-1/2 right-0 top-0 -z-10 -ml-24 transform-gpu overflow-hidden blur-3xl lg:ml-24 xl:ml-48"
          aria-hidden="true"
        >
          <div
            class="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
            style="clip-path: polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)"
          />
        </div>
        <div class="overflow-hidden">
          <div class="mx-auto px-6 pb-6 pt-4 lg:px-8">
            <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
              <div class="relative w-full lg:max-w-xl lg:shrink-0 xl:max-w-2xl">
                <h1 class="text-pretty text-5xl font-semibold tracking-tight text-gray-100 sm:text-6xl">
                  We help culture reach as many people as possible
                </h1>
                <p class="mt-8 text-pretty text-lg font-medium text-gray-400 sm:max-w-md sm:text-xl/8 lg:max-w-none">
                  Bookshelves isn't just a project, it's a vision, an ideal and the beauty of impossible freedom. It's also perfectly illegal.
                </p>
              </div>
              <div class="mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0">
                <div class="ml-auto w-44 flex-none space-y-8 pt-32 sm:ml-0 sm:pt-80 lg:order-last lg:pt-36 xl:order-none xl:pt-80">
                  <HomeHeroImage
                    :src="hero.posters?.one"
                    :ready="hero.ready"
                  />
                </div>
                <div class="mr-auto w-44 flex-none space-y-8 sm:mr-0 sm:pt-52 lg:pt-36">
                  <HomeHeroImage
                    :src="hero.posters?.two"
                    :ready="hero.ready"
                  />
                  <HomeHeroImage
                    :src="hero.posters?.three"
                    :ready="hero.ready"
                  />
                </div>
                <div class="w-44 flex-none space-y-8 pt-32 sm:pt-0">
                  <HomeHeroImage
                    :src="hero.posters?.four"
                    :ready="hero.ready"
                  />
                  <HomeHeroImage
                    :src="hero.posters?.five"
                    :ready="hero.ready"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
