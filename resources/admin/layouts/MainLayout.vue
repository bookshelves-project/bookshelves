<script setup lang="ts">
window.onerror = (error) => {
  //
  console.log(error)
}

const isDev = process.env.NODE_ENV === 'development'
</script>

<template>
  <div :class="{ 'debug-screens': isDev }">
    <slot />
  </div>
</template>
