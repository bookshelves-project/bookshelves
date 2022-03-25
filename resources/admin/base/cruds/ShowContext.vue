<template>
  <div>
    <slot :title="getTitle" />
  </div>
</template>

<script lang="ts" setup>
import { pageWithItemProps, pageWithItemSetup } from '@admin/composables/pages'

const props = defineProps(pageWithItemProps)

const { getTitle } = pageWithItemSetup(props, 'show', 0)
</script>
