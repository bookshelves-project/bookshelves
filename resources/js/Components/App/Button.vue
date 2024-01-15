<script lang="ts" setup>
import { ref } from 'vue'

interface Props {
  href?: string
  type?: 'button' | 'submit' | 'reset'
  size?: keyof typeof sizes
  color?: keyof typeof colors
  rounded?: boolean
  icon?: SvgName
  iconPosition?: 'left' | 'right'
  external?: boolean
  download?: boolean
  full?: boolean
  asText?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  type: 'button',
  size: 'lg',
  color: 'purple',
  rounded: false,
  iconPosition: 'left',
  external: false,
  download: false,
  full: false,
})

const colors = {
  purple: 'btn-purple',
  secondary: 'btn-secondary',
  soft: 'btn-soft',
}

const sizes = {
  xs: 'px-2 py-1',
  sm: 'px-2.5 py-1',
  md: 'px-2.5 py-1.5',
  lg: 'px-3 py-2',
  xl: 'px-3.5 py-2.5',
}

const current = ref('button')
const attrs = ref<Record<string, string>>({})

if (props.href) {
  current.value = 'ILink'
  attrs.value = { href: props.href }

  if (props.external) {
    current.value = 'a'
    attrs.value.target = '_blank'
    attrs.value.rel = 'noopener noreferrer'
  }

  if (props.download) {
    current.value = 'a'
    attrs.value.download = ''
  }
}
else {
  attrs.value.type = props.type
}
</script>

<template>
  <component
    :is="current"
    :class="[
      [colors[color]],
      [sizes[size]],
      { circle: rounded },
      full ? 'w-full' : 'max-w-max',
      asText ? 'as-text' : '',
    ]"
    class="btn flex items-center justify-center"
    v-bind="attrs"
  >
    <div
      v-if="icon && iconPosition === 'left'"
      class="icon-left"
    >
      <SvgIcon
        :name="icon"
        class="icon"
      />
    </div>
    <div>
      <slot />
    </div>
    <span
      v-if="asText"
      aria-hidden="true"
      class="ml-1"
    >→</span>
    <div
      v-if="icon && iconPosition === 'right'"
      class="icon-right"
    >
      <SvgIcon
        :name="icon"
        class="icon"
      />
    </div>
  </component>
</template>

<style lang="css" scoped>
.dark .btn-purple {
  @apply bg-purple-600 shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-500 text-white;
}
.dark .btn-secondary {
  @apply bg-transparent text-purple-300 shadow-sm hover:bg-purple-300/20 ring-purple-300 dark:ring-purple-400 dark:text-purple-400;
}

.btn {
  @apply rounded font-semibold;
  @apply items-center justify-center font-medium tracking-tight rounded-lg transition hover:scale-105 hover:-rotate-1 group-hover:scale-105 group-hover:-rotate-1;
}
.circle {
  @apply rounded-full;
}

.btn-purple {
  @apply bg-purple-600 text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600;
}

.btn-secondary {
  @apply bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50;
}

.btn-soft {
  @apply bg-purple-50 px-2 py-1 text-purple-600 shadow-sm hover:bg-purple-100;
}

.icon {
  @apply h-5 w-5;
}

.icon-left {
  @apply mr-1.5;
}

.icon-right {
  @apply ml-1.5;
}

.as-text {
  @apply !bg-transparent !text-white !p-0 border-b border-transparent;
  @apply group-hover:border-white !rounded-none;
}
</style>
