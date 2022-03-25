<template>
  <div class="flex items-center justify-between mt-1" :title="label">
    <span v-if="label" class="flex-grow flex flex-col">
      <span
        id="availability-label"
        class="text-base font-medium text-gray-900 dark:text-gray-100"
        >{{ label }}</span
      >
    </span>
    <button
      type="button"
      :class="[
        toggled ? 'bg-primary-600' : 'bg-gray-300 dark:bg-gray-700',
        { 'ml-3': label },
      ]"
      class="relative inline-flex shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-primary-700 dark:focus:ring-offset-gray-900"
      role="switch"
      :aria-checked="toggled"
      @click="toggle"
    >
      <span class="sr-only">{{ label }}</span>
      <span
        :class="toggled ? 'translate-x-5' : 'translate-x-0'"
        class="pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white dark:bg-gray-800 shadow transform ring-0 transition ease-in-out duration-200"
      >
        <span
          :class="
            toggled
              ? 'opacity-0 ease-out duration-100'
              : 'opacity-100 ease-in duration-200'
          "
          class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
          aria-hidden="true"
        >
        </span>
        <span
          :class="
            toggled
              ? 'opacity-100 ease-in duration-200'
              : 'opacity-0 ease-out duration-100'
          "
          class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
          aria-hidden="true"
        >
        </span>
      </span>
    </button>
  </div>
</template>

<script setup lang="ts">
  import { onMounted, ref } from 'vue'

  const props = defineProps({
    modelValue: Boolean,
    label: {
      type: String,
      default: null,
    },
  })

  const emit = defineEmits(['update:modelValue'])

  const toggled = ref(false)
  const toggle = () => {
    toggled.value = !toggled.value
    emit('update:modelValue', toggled.value)
  }

  onMounted(() => {
    if (props.modelValue) {
      toggled.value = props.modelValue
    }
  })
</script>
