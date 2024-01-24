<script lang="ts" setup>
const props = defineProps<{
  type: 'recent' | 'complete' | 'edition'
}>()

const title = computed(() => {
  const titles = {
    recent: 'Recently added',
    complete: 'Complete',
    edition: 'Alternative version',
  }

  return titles[props.type]
})
</script>

<template>
  <div
    :class="{
      'bg-orange-500': type === 'recent',
      'bg-purple-500': type === 'complete',
      'bg-cyan-500': type === 'edition',
    }"
    class="badge absolute right-0 top-0 z-10 cursor-help rounded-tr-md p-4"
    :title="title"
  />
</template>
