<template>
  <div class="flex items-center space-x-2 max-content mx-auto">
    <div>
      <Bookshelves :class="`h-${size} w-${size} ${color}`" />
    </div>
    <div
      v-if="full"
      :class="{ 'text-white': reverse }"
      class="font-handlee text-3xl"
    >
      Bookshelves
    </div>
  </div>
</template>

<script setup lang="ts">
  import Bookshelves from '@admin/svg/bookshelves.svg'

  interface Props {
    full?: boolean
    size?: number
    color?: string
    reverse?: boolean
  }

  const props = withDefaults(defineProps<Props>(), {
    full: false,
    size: 10,
    color: 'text-black',
    reverse: false,
  })
</script>
