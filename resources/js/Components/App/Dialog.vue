<script lang="ts" setup>
import { onClickOutside } from '@vueuse/core'

interface Props {
  title?: string
  opened: boolean
  size?: 'sm' | 'md' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | '6xl'
}

const props = withDefaults(defineProps<Props>(), {
  opened: false,
  size: 'md',
})

const emit = defineEmits(['close'])

const overlay = ref(false)
const layer = ref(false)
const isOpen = ref(false)

const target = ref<HTMLElement>()
onClickOutside(target, () => closeDialog())

const sizes = {
  'sm': 'sm:max-w-sm',
  'md': 'sm:max-w-md',
  'lg': 'sm:max-w-lg',
  'xl': 'sm:max-w-xl',
  '2xl': 'sm:max-w-2xl',
  '3xl': 'sm:max-w-3xl',
  '4xl': 'sm:max-w-4xl',
  '5xl': 'sm:max-w-5xl',
  '6xl': 'sm:max-w-6xl',
}
const sized = computed(() => sizes[props.size])

function openDialog() {
  layer.value = true
  setTimeout(() => {
    overlay.value = true
    isOpen.value = true
  }, 200)
}

function closeDialog() {
  overlay.value = false
  isOpen.value = false
  setTimeout(() => {
    layer.value = false
  }, 200)

  emit('close')
}

watch(() => props.opened, (value) => {
  if (value)
    openDialog()
  else
    closeDialog()
})
</script>

<template>
  <Teleport to="body">
    <div
      v-if="layer"
      class="relative z-50"
      aria-labelledby="modal-title"
      role="dialog"
      aria-modal="true"
    >
      <!-- Background backdrop, show/hide based on modal state. -->
      <div
        v-if="layer"
        :class="overlay ? 'opacity-100' : 'opacity-0'"
        class="fixed inset-0 bg-gray-700 bg-opacity-75 transition-opacity ease-out duration-300"
      />

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <!-- Modal panel, show/hide based on modal state. -->
          <div
            ref="target"
            :class="[
              isOpen ? 'opacity-100 translate-y-0 sm:scale-100' : 'opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95',
              sized,
            ]"
            class="relative transform overflow-hidden rounded-lg bg-gray-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:p-6 ease-out duration-300"
          >
            <slot />
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>
