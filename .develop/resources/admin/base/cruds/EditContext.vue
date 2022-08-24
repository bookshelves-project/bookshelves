<script lang="ts" setup>
import { pageWithItemProps, pageWithItemSetup } from '@admin/composables/pages'

const props = defineProps(pageWithItemProps)

const { getTitle } = pageWithItemSetup(props, 'edit', 0)
</script>

<template>
  <div>
    <slot :title="getTitle" />
  </div>
</template>
