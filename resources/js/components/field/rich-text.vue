<template>
  <div>
    <editor-content ref="editorContent" :editor="editor" />
    value: {{ value }}
  </div>
  <div>
    <div>Hello, {{ name }}!</div>
    <input v-model="name" />
  </div>
</template>

<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import { ref, computed, watch, defineEmit, onMounted } from "vue";

const props = defineProps({
  modelValue: String,
});

const emit = defineEmits(["update:modelValue", "submit"]);

watch(
  () => props.modelValue,
  (newVal) => {
    console.log("hello modelValue");
    // emit("update:modelValue", newVal);
    const isSame = editor.value.getHTML() === value;

    if (isSame) {
      return;
    }

    editor.value.commands.setContent(value, false);
  }
);
watch(
  () => value,
  (newVal) => {
    console.log("hello value");
    // emit("update:modelValue", newVal);
  }
);
// const { input } = useInputValidator(props.value, (value) =>
//   emit("input", value)
// );

let value = ref("b");
let name = ref("");
onMounted(() => {
  console.log("mounted in the composition api!");
  value.value = props.modelValue;
  console.log(value.value);
});

const editor = useEditor({
  content: value.value,
  extensions: [StarterKit],
  onUpdate: (val) => {
    console.log(val);
    emit("update:modelValue", val.editor.getHTML());
  },
});
</script>
