<script setup lang="ts">
defineProps({
  file: {
    type: Object,
    required: true,
  },
  tag: {
    type: String,
    default: 'li',
  },
})

defineEmits(['remove'])
</script>

<template>
  <component
    :is="tag"
    class="overflow-auto"
  >
    <button
      class="close-icon"
      @click="$emit('remove', file)"
    >
      &times;
    </button>
    <img
      :src="file.url"
      :alt="file.file.name"
      :title="file.file.name"
    >

    <span
      v-show="file.status == 'loading'"
      class="status-indicator loading-indicator"
    >In Progress</span>
    <span
      v-show="file.status == true"
      class="status-indicator success-indicator"
    >Uploaded</span>
    <span
      v-show="file.status == false"
      class="status-indicator failure-indicator"
    >Error</span>
  </component>
</template>

<style scoped lang="css">
.file-preview {
  width: 20%;
  margin: 1rem 2.5%;
  position: relative;
  aspect-ratio: 1/1;
  overflow: hidden;

  img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
  }

  .close-icon,
  .status-indicator {
    --size: 20px;
    position: absolute;
    line-height: var(--size);
    height: var(--size);
    border-radius: var(--size);
    box-shadow: 0 0 5px currentColor;
    right: 0.25rem;
    appearance: none;
    border: 0;
    padding: 0;
  }

  .close-icon {
    width: var(--size);
    font-size: var(--size);
    background: #933;
    color: #fff;
    top: 0.25rem;
    cursor: pointer;
  }

  .status-indicator {
    font-size: calc(0.75 * var(--size));
    bottom: 0.25rem;
    padding: 0 10px;
  }

  .loading-indicator {
    animation: pulse 1.5s linear 0s infinite;
    color: #000;
  }

  .success-indicator {
    background: #6c6;
    color: #040;
  }

  .failure-indicator {
    background: #933;
    color: #fff;
  }
}

@keyframes pulse {
  0% {
    background: #fff;
  }

  50% {
    background: #ddd;
  }

  100% {
    background: #fff;
  }
}
</style>
