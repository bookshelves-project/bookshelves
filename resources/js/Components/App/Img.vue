<script lang="ts" setup>
import { useLazy } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  color?: string
}>()

const { vLazy } = useLazy(props.color)
const attrs = useAttrs()
</script>

<template>
  <div
    v-lazy
    v-bind="attrs"
  />
</template>
