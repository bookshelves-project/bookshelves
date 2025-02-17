<script lang="ts" setup>
defineProps<{
  src?: string
  ready: boolean
}>()
</script>

<template>
  <div class="relative">
    <div class="poster-base">
      <Transition :duration="200">
        <img
          v-if="ready"
          :src="src"
          alt=""
          class="poster-img"
        >
        <div
          v-else
          class="poster-loading"
        />
      </Transition>
    </div>
    <div class="poster-pointer" />
  </div>
</template>

<style lang="css" scoped>
.poster-base {
  @apply aspect-[2/3] w-full rounded-xl bg-gray-900 object-cover shadow-lg;
}
.poster-loading {
  @apply animate-pulse h-full bg-gray-800 rounded-xl absolute inset-0;
}
.poster-img {
  @apply aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg;
}
.poster-pointer {
  @apply pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10;
}
</style>
