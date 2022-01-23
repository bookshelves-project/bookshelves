<template>
  <div class="relative whitespace-nowrap">
    <div @click="open = !open">
      <slot name="trigger"></slot>
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-show="open"
        class="absolute z-50 mt-2 rounded-md shadow-lg"
        :class="wrapperClasses"
        style="display: none"
        @click="open = false"
      >
        <div
          class="rounded-md ring-1 ring-black ring-opacity-5"
          :class="linkClasses"
        >
          <slot name="content"></slot>
        </div>
      </div>
    </transition>
  </div>
</template>

<script lang="ts" setup>
  import { onMounted, onUnmounted, ref } from 'vue'

  defineProps({
    wrapperClasses: {
      type: [String, Array],
      default: () => ['w-48', 'right'],
    },
    linkClasses: {
      type: [String, Array],
      default: () => ['py-1', 'bg-white'],
    },
  })

  let open = ref(false)

  const closeOnEscape = (e: KeyboardEvent) => {
    if (open.value && e.key === 'Escape') {
      open.value = false
    }
  }

  onMounted(() => document.addEventListener('keydown', closeOnEscape))
  onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))
</script>

<style lang="postcss" scoped>
  .left {
    @apply origin-top-left left-0;
  }
  .right {
    @apply origin-top-right right-0;
  }
</style>
