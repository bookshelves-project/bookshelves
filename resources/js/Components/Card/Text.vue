<script lang="ts" setup>
const props = defineProps<{
  text?: string
}>()

const currentText = ref<string>()
const limit = 600
const expandable = ref(false)
const excerpt = ref<string>()
const expanded = ref(false)

currentText.value = toPlainText(props.text)

if (props.text && props.text.length > limit)
  expandable.value = true

function spliceText() {
  if (currentText.value) {
    excerpt.value = currentText.value?.slice(0, limit)
    if (currentText.value.length > limit)
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

function toPlainText(text: string | undefined) {
  if (!text)
    return ''
  return text.replace(/<[^>]+>/g, '')
}
</script>

<template>
  <div>
    <div
      class="prose prose-invert"
      v-html="excerpt"
    />
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
