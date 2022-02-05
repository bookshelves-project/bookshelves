<template>
  <app-layout :title="title">
    <dashboard-content />
  </app-layout>
</template>

<script setup lang="ts">
  import { useTitle } from '@admin/features/helpers'

  const title = useTitle('Settings')
</script>
