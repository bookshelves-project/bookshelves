<template>
  <span class="button-action">
    <button
      type="button"
      :class="action ? { 'is-active': editor?.isActive(action, params) } : ''"
      @click="editor?.chain().focus()[method](params).run()"
    >
      <slot />
    </button>
  </span>
</template>

<script setup lang="ts">
  defineProps({
    editor: Object,
    action: String,
    method: {
      type: String,
      default: 'toggleBold',
    },
    params: Object,
  })
</script>

<style lang="css" scoped>
  .button-action :deep(button) {
    @apply py-1 px-2 m-0.5 bg-primary-600 rounded-md bg-opacity-60 text-white transition-colors duration-100 hover:bg-primary-500 hover:bg-opacity-60;
  }
</style>
