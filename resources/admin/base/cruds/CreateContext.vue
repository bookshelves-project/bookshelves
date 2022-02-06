<template>
  <div>
    <slot :title="getTitle" />
  </div>
</template>

<script lang="ts" setup>
  import { pageProps, pageSetup } from '@admin/composables/pages'

  const props = defineProps(pageProps)

  const { getTitle } = pageSetup(props, 'create', 0)
</script>
