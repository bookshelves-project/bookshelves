<template>
  <a :href="`mailto:${value}`" class="underline" @click.stop>{{ value }}</a>
</template>

<script lang="ts" setup>
  defineProps({
    value: {
      type: String,
      required: true,
    },
  })
</script>
