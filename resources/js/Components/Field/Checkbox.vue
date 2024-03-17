<script lang="ts" setup>
interface Props {
  name: string
  label?: string
  required?: boolean
  modelValue: boolean | number
  error?: string
}

const props = withDefaults(defineProps<Props>(), {
  required: false,
})

const emit = defineEmits(['update:modelValue'])

const model = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  },
})
</script>

<template>
  <div class="relative flex items-start">
    <div class="flex h-6 items-center">
      <input
        :id="name"
        v-model="model"
        :aria-describedby="`${name}-description`"
        :name="name"
        :value="modelValue"
        type="checkbox"
        class="h-4 w-4 rounded border-white/10 bg-white/5 text-purple-600 focus:ring-purple-600 focus:ring-offset-gray-900"
      >
    </div>
    <div class="ml-3 text-sm leading-6">
      <label
        :for="name"
        class="font-medium text-gray-100"
      >
        {{ label }}
        <span
          v-if="required"
          class="text-red-500"
        >*</span>
      </label>
      <div
        :id="`${name}-description`"
        class="text-gray-400"
      >
        <slot />
      </div>
    </div>
  </div>
</template>
