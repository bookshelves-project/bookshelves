<template>
  <div>
    <slot :title="getTitle" />
  </div>
</template>

<script lang="ts" setup>
  import { pageProps, pageSetup } from '@admin/mixins/pages'

  const props = defineProps(pageProps)

  const { getTitle } = pageSetup(props, 'index', 10)
</script>
