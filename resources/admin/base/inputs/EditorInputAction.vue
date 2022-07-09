<script setup lang="ts">
import { useEditorInput } from '@admin/composables/useEditorInput'
import { Editor } from '@tiptap/vue-3'

defineProps<{
  button: EditorButton
  editor: Editor
}>()

const { callMethod } = useEditorInput()
</script>

<template>
  <span class="button-action">
    <div
      v-if="button.seperator"
      class="flex h-full">
      <div
        class="bg-gray-400 dark:bg-gray-600 mx-3 w-[1px] h-3/5 my-auto"
      ></div>
    </div>
    <button
      v-else
      type="button"
      :class="
        button.action
          ? { 'is-active': editor?.isActive(button.action, button.params) }
          : ''
      "
      @click="button.custom ? callMethod(button.method!, editor) : editor?.chain().focus()[button.method!](button.params).run()"
    >
      <slot />
    </button>
  </span>
</template>

<style lang="css" scoped>
.button-action :deep(button) {
  @apply py-1 px-2 m-0.5 rounded-md bg-opacity-60 text-white transition-colors duration-100 hover:bg-primary-500 hover:bg-opacity-60;
}
.is-active {
  @apply bg-primary-500;
}
</style>
