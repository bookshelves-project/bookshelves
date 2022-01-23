<template>
  <div v-if="hasErrors" class="bg-red-500 rounded-md p-3">
    <ul class="text-sm text-white">
      <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
  import { computed } from 'vue'
  import { usePage } from '@inertiajs/inertia-vue3'

  const errors = computed(() => usePage().props.value.errors)
  const hasErrors = computed(() => Object.keys(errors.value).length > 0)
</script>
