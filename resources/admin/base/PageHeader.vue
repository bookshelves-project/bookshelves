<template>
  <div class="flex items-center">
    <slot />
    <div v-if="$slots.actions" class="flex gap-2 ml-auto">
      <slot name="actions"></slot>
    </div>
  </div>
</template>

<script lang="ts" setup></script>
