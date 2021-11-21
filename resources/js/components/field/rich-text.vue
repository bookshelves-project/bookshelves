<template>
  <div v-if="editor" class="editor relative">
    <div class="editor__actions">
      <div class="editor__actions__list">
        <action
          v-for="button in buttons"
          :key="button.id"
          :editor="editor"
          :button="button"
        />
      </div>
    </div>
    <hr class="mx-4" />
    <editor-content :editor="editor" class="editor__body" />
    <div class="py-3 px-3 border-t border-gray-300 flex justify-between">
      <div>
        Powered by
        <a
          href="https://tiptap.dev/"
          target="_blank"
          rel="noopener noreferrer"
          class="
            border-b border-primary-600
            text-primary-600
            font-semibold
            hover:bg-primary-600 hover:bg-opacity-30
          "
        >
          Tiptap</a
        >, you can use
        <a
          href="https://www.markdownguide.org/cheat-sheet/"
          target="_blank"
          rel="noopener noreferrer"
          class="
            border-b border-primary-600
            text-primary-600
            font-semibold
            hover:bg-primary-600 hover:bg-opacity-30
          "
          >Markdown</a
        >.
      </div>
      <div class="character-count" v-if="editor">
        {{ editor.getCharacterCount() }}/{{ limit }} characters
      </div>
    </div>
  </div>
</template>

<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Highlight from "@tiptap/extension-highlight";
import Typography from "@tiptap/extension-typography";
import CharacterCount from "@tiptap/extension-character-count";
import TextAlign from "@tiptap/extension-text-align";
import Link from "@tiptap/extension-link";
import Underline from "@tiptap/extension-underline";
import Image from "@tiptap/extension-image";
import TaskList from "@tiptap/extension-task-list";
import TaskItem from "@tiptap/extension-task-item";
import CodeBlockLowlight from "@tiptap/extension-code-block-lowlight";
import lowlight from "lowlight";
import {
  ref,
  computed,
  watch,
  onMounted,
  onBeforeMount,
  onBeforeUnmount,
} from "vue";
import Action from "./rich-text/action.vue";
import { buttons } from "./rich-text/buttons";

const props = defineProps({
  modelValue: String,
});

const emit = defineEmits(["update:modelValue", "submit"]);

watch(
  () => props.modelValue,
  (newVal) => {
    console.log("modelValue");
    console.log(newVal);
  },
  () => valueEditor,
  (newVal) => {
    console.log("valueEditor");
    console.log(valueEditor.value);
    // emit("update:modelValue", newVal);
  }
);

const limit = 5000;
let valueEditor = ref(props.modelValue);

const editor = useEditor({
  content: valueEditor.value,
  extensions: [
    StarterKit,
    Highlight,
    Typography,
    CharacterCount.configure({
      limit: limit,
    }),
    TextAlign.configure({
      types: ["paragraph"],
      alignments: ["left", "right"],
    }),
    Link,
    Underline,
    Image,
    // CodeBlockLowlight.configure({
    //   lowlight,
    // }),
    TaskList,
    TaskItem.configure({
      nested: true,
    }),
  ],
  editorProps: {
    attributes: {
      spellcheck: "false",
      class:
        "prose p-4 mx-auto focus:outline-none max-h-screen overflow-auto scrollbar-thin !max-w-full",
    },
  },
  onUpdate: (val) => {
    emit("update:modelValue", val.editor.getHTML());
  },
});
</script>

<style lang="postcss" scoped>
.editor :deep(li[data-checked] div) {
  @apply inline;
}
.editor :deep(li p) {
  @apply inline my-0 ml-2 !important;
}
/* Basic editor styles */
.editor::v-deep {
  @apply shadow-sm focus:ring-primary-500 focus:border-primary-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md;
}

.editor :deep(.editor__actions) {
  @apply p-2 sticky top-0 z-10 bg-primary-400 rounded-t-md;
}
.editor :deep(.editor__actions__list) {
  /* @apply grid grid-cols-3 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 xl:grid-cols-12; */
  @apply flex items-center flex-wrap;
}
.ProseMirror::v-deep {
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
    font-family: "JetBrainsMono", monospace;
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
}
</style>
