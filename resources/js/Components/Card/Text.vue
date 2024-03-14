<script lang="ts" setup>
const props = defineProps<{
  text?: string
}>()

const limit = 600
const expandable = ref(false)
const excerpt = ref<string>()
const expanded = ref(false)

if (props.text && props.text.length > limit)
  expandable.value = true

function spliceText() {
  if (props.text) {
    excerpt.value = props.text?.slice(0, limit)
    if (props.text.length > limit)
      excerpt.value += '...'
  }
}
spliceText()

function readMore() {
  if (expanded.value) {
    spliceText()
    expanded.value = false
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
      v-if="expandable"
      class="mt-2 text-purple-400 underline hover:text-purple-300"
      @click="readMore"
    >
      Read
      <span v-if="expanded">less</span>
      <span v-else>more</span>
    </button>
  </div>
</template>
