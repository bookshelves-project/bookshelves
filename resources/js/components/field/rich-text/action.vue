<template>
  <div v-if="button && !button.space" class="action-btn">
    <button
      type="button"
      :class="
        button.action
          ? { 'is-active': editor.isActive(button.action, button.params) }
          : ''
      "
      :title="button.title"
      @click="
        button.custom
          ? custom(button.method)
          : editor.chain().focus()[button.method](button.params).run()
      "
    >
      <svg-vue
        v-if="button.svg"
        :icon="`editor/${button.svg}`"
        class="w-5 h-5 mx-auto"
      />
      <!-- <div class="text-center text-xs italic mt-1">
        {{ button.title }}
      </div> -->
    </button>
  </div>
  <div v-else class="mx-2 my-1 hidden xl:block"></div>
</template>

<script setup>
import { getCurrentInstance } from "vue";

const props = defineProps({
  editor: Object,
  button: Object,
});

const internalInstance = getCurrentInstance();

function custom(type) {
  this[type]();
}

function addImage() {
  const url = window.prompt("URL");

  if (url) {
    props.editor.chain().focus().setImage({ src: url }).run();
  }
}

function setLink() {
  const previousUrl = props.editor.getAttributes("link").href;
  const url = window.prompt("URL", previousUrl);

  // cancelled
  if (url === null) {
    return;
  }

  // empty
  if (url === "") {
    props.editor.chain().focus().extendMarkRange("link").unsetLink().run();

    return;
  }

  // update link
  props.editor
    .chain()
    .focus()
    .extendMarkRange("link")
    .setLink({ href: url })
    .run();
}

function help() {
  console.log(internalInstance.parent);
  // console.log(internalInstance.parent.openHelp(true));
}
</script>

<style lang="postcss" scoped>
.action-btn :deep(button) {
  @apply py-1 px-2 bg-opacity-60 text-white rounded-md transition-colors duration-100 hover:bg-primary-500 hover:bg-opacity-60;
}
</style>
