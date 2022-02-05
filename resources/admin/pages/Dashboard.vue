<template>
  <app-layout :title="title">
    <dashboard-content />
  </app-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  const title = useTitle('Dashboard')
</script>
