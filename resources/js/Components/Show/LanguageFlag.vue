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
      class="h-4 rounded-sm"
      :title="props.language?.name">
  </div>
</template>
