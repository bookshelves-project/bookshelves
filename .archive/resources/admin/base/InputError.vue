<script lang="ts" setup>
defineProps({
  message: String,
})
</script>

<template>
  <div v-show="message">
    <p class="text-base text-red-600">
      {{ message }}
    </p>
  </div>
</template>
