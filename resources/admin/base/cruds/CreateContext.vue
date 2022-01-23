<template>
  <div>
    <slot :title="getTitle" />
  </div>
</template>

<script lang="ts" setup>
  import { pageProps, pageSetup } from '@admin/mixins/pages'

  const props = defineProps(pageProps)

  const { getTitle } = pageSetup(props, 'create', 0)
</script>
