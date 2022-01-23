<template>
  <app-layout>
    <template #header>
      <h1>{{ title }}</h1>
    </template>
  </app-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  const title = useTitle('Dashboard')
</script>
