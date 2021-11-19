<template>
  <LayoutDefault title="CMS: Home">
    {{ editor }}
    <rich-text v-model="editor" />
  </LayoutDefault>
</template>

<script setup>
import { ref, computed, watch } from "vue";

const editor = ref("a");
function onSubmit() {
  // submit to backend or whatever you like
  console.log(editor.value);
}
</script>
