<template>
  <span class="action-btn">
    <button
      type="button"
      :class="action ? { 'is-active': editor.isActive(action, params) } : ''"
      @click="editor.chain().focus()[method](params).run()"
    >
      <slot />
    </button>
  </span>
</template>

<script setup>
// import { defineProps } from "vue";

const props = defineProps({
  editor: Object,
  action: String,
  method: String,
  params: Object,
});
// export default {
//   name: "RichTextAction",
//   props: {
//     editor: {
//       type: Object,
//       default: () => {},
//     },
//     action: {
//       type: String,
//       default: "",
//     },
//     method: {
//       type: String,
//       default: "toggleBold",
//     },
//     params: {
//       type: Object,
//       default: () => {},
//     },
//   },
// };
</script>

<style lang="postcss" scoped>
.action-btn :deep(button) {
  @apply py-1 px-2 m-1 bg-primary-600 rounded-md bg-opacity-60 text-white transition-colors duration-100 hover:bg-primary-500 hover:bg-opacity-60;
}
</style>
