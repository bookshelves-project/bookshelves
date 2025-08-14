<script lang="ts" setup>
const props = defineProps<{
  language?: App.Models.Language
}>()
</script>

<template>
  <div :title="props.language?.name"
    class="inline-block ml-3">
    <img :src="`/images/flags/${props.language?.slug}.svg`"
      :alt="props.language?.slug"
      class="w-6 h-6 rounded-md">
  </div>
</template>
