<template>
  <div v-show="message">
    <p class="text-sm text-gray-600">
      {{ message }}
    </p>
  </div>
</template>

<script lang="ts" setup>
  defineProps({
    message: String,
  })
</script>
