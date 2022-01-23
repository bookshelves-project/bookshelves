<template>
  <div>
    <transition
      leave-active-class="transition ease-in duration-1000"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-show="on" class="text-sm text-green-500">
        <slot />
      </div>
    </transition>
  </div>
</template>

<script lang="ts" setup>
  defineProps({
    on: Boolean,
  })
</script>
