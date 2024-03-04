<script lang="ts" setup>
const props = defineProps<{
  text?: string
}>()

const excerpt = ref<string>()
const expanded = ref(false)

function spliceText() {
  if (props.text) {
    excerpt.value = props.text?.slice(0, 1000)
    if (props.text.length > 1000)
      excerpt.value += '...'
  }
}
spliceText()

function readMore() {
  if (expanded.value) {
    spliceText()
    return
  }
  excerpt.value = props.text
  expanded.value = true
}
</script>

<template>
  <div>
    <p>
      {{ excerpt }}
    </p>
    <button
      class="mt-2 text-purple-400 underline hover:text-purple-300"
      @click="readMore"
    >
      Read
      <span v-if="expanded">less</span>
      <span v-else>more</span>
    </button>
  </div>
</template>
