<template>
  <div v-if="editor" class="editor relative">
    <div class="editor__actions">
      <action
        v-for="button in buttons"
        :key="button.id"
        :editor="editor"
        :action="button.action"
        :method="button.method"
        :params="button.params"
      >
        {{ button.title }}
      </action>
    </div>
    <hr class="mx-4" />
    <editor-content :editor="editor" class="editor__body" />
    <div class="character-count" v-if="editor">
      {{ editor.getCharacterCount() }}/{{ limit }} characters
    </div>
  </div>
</template>

<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Highlight from "@tiptap/extension-highlight";
import Typography from "@tiptap/extension-typography";
import CharacterCount from "@tiptap/extension-character-count";
import {
  ref,
  computed,
  watch,
  defineEmit,
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
  ],
  editorProps: {
    attributes: {
      spellcheck: "false",
      class:
        "prose prose-sm sm:prose lg:prose-lg p-4 mx-auto focus:outline-none max-h-screen overflow-auto scrollbar-thin !max-w-full",
    },
  },
  onUpdate: (val) => {
    emit("update:modelValue", val.editor.getHTML());
  },
});
</script>

<style lang="postcss" scoped>
/* Basic editor styles */
.editor::v-deep {
  @apply shadow-sm focus:ring-primary-500 focus:border-primary-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md;
}
.editor__actions::v-deep {
  @apply p-2 sticky top-0 z-10  bg-white;
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
