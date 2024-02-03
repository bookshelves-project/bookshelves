<script setup lang="ts">
defineProps<{
  title?: string
  url?: string
  padding?: boolean
}>()

const scrollEl = ref<HTMLDivElement>()

function scrollLeft() {
  scrollEl.value?.scrollBy({
    left: -window.innerWidth,
    behavior: 'smooth',
  })
}

function scrollRight() {
  scrollEl.value?.scrollBy({
    left: window.innerWidth,
    behavior: 'smooth',
  })
}
</script>

<template>
  <div>
    <div class="flex items-center">
      <div
        v-if="title"
        :class="{
          'pl-6': padding,
        }"
        class="text-2xl font-semibold"
      >
        {{ title }}
      </div>
      <div class="flex-auto" />
      <div>
        <ILink
          v-if="url"
          :href="url"
        >
          <div class="text-gray-300 hover:text-gray-200">
            See all
          </div>
        </ILink>
        <div class="space-x-1 pr-6">
          <button
            class="bg-gray-700 hover:bg-gray-800 rounded-md p-0.5"
            title="Scroll left"
            @click="scrollLeft()"
          >
            <SvgIcon
              name="arrow-left"
              class="w-5 h-5"
            />
          </button>
          <button
            class="bg-gray-700 hover:bg-gray-800 rounded-md p-0.5"
            title="Scroll right"
            @click="scrollRight()"
          >
            <SvgIcon
              name="arrow-right"
              class="w-5 h-5"
            />
          </button>
        </div>
      </div>
    </div>
    <div class="relative mt-3">
      <div
        ref="scrollEl"
        class="overflow-y-auto carousel"
      >
        <div
          class="flex gap-6 w-max mt-5 pb-5 pr-6"
        >
          <div v-if="padding" />
          <slot />
        </div>
      </div>
      <button
        class="absolute top-0 left-0 bottom-0 bg-black/50 p-3 items-center opacity-0 hover:opacity-100 justify-center transition flex-col"
        title="Scroll left"
        @click="scrollLeft()"
      >
        <div class="text-3xl text-white" />
      </button>
      <button
        class="absolute top-0 right-0 bottom-0 bg-black/50 p-3 items-center opacity-0 hover:opacity-100 justify-center transition flex-col"
        title="Scroll right"
        @click="scrollRight()"
      >
        <div class=" text-3xl text-white" />
      </button>
    </div>
  </div>
</template>

<style lang="css" scoped>
.carousel {
  -ms-overflow-style: none;  /* Internet Explorer 10+ */
  scrollbar-width: none;  /* Firefox */
}
.carousel::-webkit-scrollbar {
  display: none;  /* Safari and Chrome */
}
</style>
