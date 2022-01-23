<template>
  <component
    :is="href ? 'inertia-link' : 'button'"
    :href="href"
    class="
      flex
      items-center
      px-4
      py-2
      text-sm
      leading-5
      text-gray-700
      hover:bg-gray-100
      focus:outline-none focus:bg-gray-100
      transition
    "
    :class="href ? '' : 'text-left w-full'"
  >
    <component :is="`${icon}-icon`" v-if="icon" class="w-4 h-4 mr-2" />
    <slot></slot>
  </component>
</template>

<script lang="ts" setup>
  defineProps({
    href: String,
    icon: String,
  })
</script>
