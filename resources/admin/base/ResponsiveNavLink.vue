<template>
  <div>
    <component
      :is="href ? 'inertia-link' : 'button'"
      :href="href"
      class="
        block
        pl-3
        pr-4
        py-2
        border-l-4
        text-base
        font-medium
        focus:outline-none
        transition
      "
      :class="{ 'text-left w-full': !!href, active }"
    >
      <slot></slot>
    </component>
  </div>
</template>

<script lang="ts" setup>
  defineProps({
    active: Boolean,
    href: String,
  })
</script>

<style lang="postcss" scoped>
  a {
    @apply border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300;

    &.active {
      @apply border-primary-400 text-primary-700 bg-primary-50 focus:text-primary-800 focus:bg-primary-100 focus:border-primary-700;
    }
  }
</style>
