<script lang="ts" setup>
defineProps<{
  series?: App.Models.Serie[]
  title?: string
  url?: string
  padding?: boolean
  ready: boolean
}>()
</script>

<template>
  <AppCarousel
    v-if="series && series.length"
    :title="title"
    :url="url"
    :padding="padding"
    :ready="ready"
  >
    <template
      v-for="serie in series"
      :key="serie.id"
    >
      <CardSerie
        :serie="serie"
        class="w-44"
      />
    </template>
  </AppCarousel>
</template>
