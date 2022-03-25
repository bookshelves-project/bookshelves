<script lang="ts" setup>
import { computed, onMounted } from 'vue'
import { inputProps, inputSetup } from '@admin/composables/input'
import { getLocale, __ } from 'matice'
import route from 'ziggy-js'
import axios from 'axios'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Typography from '@tiptap/extension-typography'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import TaskList from '@tiptap/extension-task-list'
import TaskItem from '@tiptap/extension-task-item'
import Placeholder from '@tiptap/extension-placeholder'
import CharacterCount from '@tiptap/extension-character-count'
import { useEditorInput } from '@admin/composables/useEditorInput'
import { useElfinderStore } from '@admin/stores/elfinder'

const props = defineProps({
  ...inputProps,
  modelValue: String,
  height: {
    type: Number,
    default: 500,
  },
  menubar: Boolean,
  statusbar: Boolean,
  inline: Boolean,
  plugins: Array,
  toolbar: String,
  options: String,
})

const emit = defineEmits(['update:modelValue'])
const { getLabel, formValue, getError, id } = inputSetup(props, emit)

const editor = useEditor({
  content: props.modelValue,
  extensions: [
    StarterKit,
    Typography,
    Image,
    Link.configure({
      openOnClick: false,
    }),
    TaskList,
    TaskItem.configure({
      nested: true,
    }),
    Placeholder.configure({
      placeholder: 'Write something…',
    }),
    CharacterCount.configure(),
  ],
  editorProps: {
    attributes: {
      spellcheck: 'false',
      class:
        'prose prose-lg max-w-full p-4 mx-auto focus:outline-none max-h-screen min-h-[50vh] overflow-auto scrollbar-thin',
    },
  },
  onUpdate: () => {
    formValue.value = editor.value?.getHTML()
  },
})
onMounted(() => {
  if (editor.value) {
    editor.value.commands.setContent(formValue.value)
  }
})

const store = useElfinderStore()
const elfinderStatus = computed(() => store.elfinderStatus)
const { buttonsBasic, buttonsComplete, elfinder } = useEditorInput()
const buttons = props.options === 'basic' ? buttonsBasic() : buttonsComplete()
</script>

<template>
  <base-input>
    <input-label :for="id" class="mb-1" :value="getLabel" />
    <div class="editor-text">
      <div class="editor relative">
        <div v-if="editor" class="editor__actions">
          <editor-input-action
            v-for="(button, index) in buttons"
            :key="index"
            :editor="editor"
            :button="button"
            :title="button.title"
          >
            <svg-icon
              :name="`editor-${button.icon}`"
              class="w-6 h-6 text-gray-800 dark:text-gray-100"
            />
          </editor-input-action>
        </div>
        <hr class="mx-4" />
        <editor-content
          v-model="formValue"
          :editor="editor"
          class="editor__body"
        />
        <div class="mx-4">
          <div v-if="editor" class="character-count">
            {{ editor.storage.characterCount.words() }} words
          </div>
          <div
            class="p-2 border-t border-gray-300 text-gray-600 italic dark:border-gray-700 dark:text-gray-400"
          >
            Powered by
            <a
              href="https://tiptap.dev/"
              target="_blank"
              rel="noopener noreferrer"
              class="underline underline-gray-600 underline-offset-2"
              >Tiptap</a
            >, you can use
            <a
              href="https://www.markdownguide.org/cheat-sheet/"
              target="_blank"
              rel="noopener noreferrer"
              class="underline underline-gray-600 underline-offset-2"
              >Markdown</a
            >.
          </div>
        </div>
      </div>
      <input-error :message="getError" class="mt-2" />
      <input-hint :message="hint" class="mt-2" />
    </div>
  </base-input>
</template>

<style lang="css" scoped>
/* Basic editor styles */
.editor-text :deep(.editor) {
  @apply shadow-sm focus:ring-primary-500 focus:border-primary-500 mt-1 block w-full sm:text-base border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700;
}
.editor-text :deep(.editor__actions) {
  @apply p-2 sticky top-20 flex flex-wrap;
}
.editor-text :deep(.ProseMirror) {
  > * + * {
    margin-top: 0.75em;
  }

  ul,
  ol {
    padding: 0 1rem;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    line-height: 1.1;
  }

  code {
    background-color: rgba(#616161, 0.1);
    color: #616161;
  }

  pre {
    background: #0d0d0d;
    color: #fff;
    font-family: 'JetBrainsMono', monospace;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;

    code {
      color: inherit;
      padding: 0;
      background: none;
      font-size: 0.8rem;
    }
  }

  img {
    max-width: 100%;
    height: auto;
  }

  blockquote {
    padding-left: 1rem;
    border-left: 2px solid rgba(#0d0d0d, 0.1);
  }

  hr {
    border: none;
    border-top: 2px solid rgba(#0d0d0d, 0.1);
    margin: 2rem 0;
  }

  & li {
    @apply flex;
  }
}

.editor-text :deep(.prose-lg) ul li {
  @apply !flex;
}
.editor-text :deep(.prose-lg) ul label {
  @apply !m-0 mr-2;
}
.editor-text :deep(.prose-lg) ul div {
  @apply !m-0;
}
.editor-text :deep(.prose-lg) ul p {
  @apply !m-0;
}
</style>
