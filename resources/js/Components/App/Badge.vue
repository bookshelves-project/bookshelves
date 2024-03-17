<script lang="ts" setup>
export interface Props {
  size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl'
}

const props = withDefaults(defineProps<Props>(), {
  size: 'xs',
})

const style = computed(() => {
  const sizes = {
    xs: 'px-2 py-1 text-xs',
    sm: 'px-2 py-1 text-sm',
    md: 'px-3 py-1.5 text-sm',
    lg: 'px-3 py-1.5 text-base',
    xl: 'px-4 py-2 text-base',
  }

  return [
    'inline-flex items-center rounded-full',
    sizes[props.size],
  ]
})
</script>

<template>
  <span
    :class="style"
    class="inline-flex items-center rounded-md bg-purple-400/10 font-medium text-purple-300 ring-1 ring-inset ring-purple-300/30"
  >
    <slot />
  </span>
</template>
