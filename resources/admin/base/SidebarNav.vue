<template>
  <div v-for="(link, i) in mainNav" :key="i" class="mb-4 group">
    <inertia-link
      v-if="isLink(link)"
      class="flex items-center py-3"
      :href="link.href"
      :class="{ active: link.active() }"
    >
      <component :is="`${link.icon}-icon-solid`" class="w-5 h-5 mr-2" />
      {{ link.text }}
    </inertia-link>
    <h3
      v-if="isTitle(link)"
      class="
        text-primary-300 text-xs
        uppercase
        font-bold
        pt-4
        pb-2
        border-primary-300 border-b-1
      "
    >
      {{ link.title }}
    </h3>
  </div>
</template>

<script lang="ts" setup>
  import { mainNav, isTitle, isLink } from '@admin/_nav'
</script>

<style lang="postcss" scoped>
  a {
    @apply text-primary-300 group-hover:text-white;

    svg {
      @apply fill-current text-primary-400 group-hover:text-white;
    }

    &.active {
      @apply text-white;

      svg {
        @apply fill-current text-white;
      }
    }
  }
</style>
