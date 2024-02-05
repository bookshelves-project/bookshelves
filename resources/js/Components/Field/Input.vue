<script setup lang="ts">
import type { InputTypeHTMLAttribute } from 'vue'

interface Props {
  name: string
  label?: string
  required?: boolean
  autocomplete?: string
  placeholder?: string
  hint?: string
  type?: InputTypeHTMLAttribute
  modelValue: string | number
  multiline?: boolean
  error?: string
}

withDefaults(defineProps<Props>(), {
  required: false,
  autocomplete: 'off',
  type: 'text',
})

const emit = defineEmits(['update:modelValue'])

function updateInput(event: Event) {
  const e = event.target as HTMLInputElement
  emit('update:modelValue', e.value)
}
</script>

<template>
  <div>
    <div class="flex justify-between">
      <label
        v-if="label"
        :for="name"
        class="block text-sm font-medium leading-6 text-gray-100"
      >
        {{ label }}
        <span
          v-if="required"
          class="text-red-500"
        >*</span>
      </label>
      <span
        v-if="hint"
        :id="`${name}-optional`"
        class="text-sm leading-6 text-gray-400"
      >
        {{ hint }}
      </span>
    </div>
    <div class="mt-2">
      <input
        v-if="!multiline"
        :id="name"
        :value="modelValue"
        :type="type"
        :name="name"
        class="block w-full rounded-md border-0 py-1.5 text-gray-100 shadow-sm ring-1 ring-inset ring-gray-700 placeholder:text-gray-300 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6 bg-gray-800"
        :placeholder="placeholder"
        :autocomplete="autocomplete"
        :required="required"
        :aria-describedby="`${name}-description`"
        @input="event => updateInput(event)"
      >
      <textarea
        v-if="multiline"
        :id="name"
        :name="name"
        :value="modelValue"
        :placeholder="placeholder"
        :autocomplete="autocomplete"
        :required="required"
        :aria-describedby="`${name}-description`"
        rows="3"
        class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
        @input="event => updateInput(event)"
      />
    </div>
    <div
      :id="`${name}-description`"
      class="mt-2 text-sm text-gray-500"
    >
      <slot />
      <div
        v-if="error"
        class="text-red-500"
      >
        {{ error }}
      </div>
    </div>
  </div>
</template>
