<script lang="ts" setup>
interface Props {
  name: string
  label?: string
  required?: boolean
  modelValue: string | number
  options: { label: string, value: string | number }[]
  placeholder?: string
  error?: string
}

withDefaults(defineProps<Props>(), {
  required: false,
})
const emit = defineEmits(['update:modelValue'])

function updateSelect(event: Event) {
  const e = event.target as HTMLSelectElement
  emit('update:modelValue', e.value)
}
</script>

<template>
  <div>
    <label
      :for="name"
      class="block text-sm font-medium leading-6 text-gray-100"
    >
      {{ label }}
    </label>
    <select
      :id="name"
      :value="modelValue"
      :name="name"
      class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-100 ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-purple-600 sm:text-sm sm:leading-6 bg-gray-800"
      @input="event => updateSelect(event)"
    >
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>
