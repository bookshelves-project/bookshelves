<script lang="ts" setup>
defineProps<{
  author: App.Models.Author
  breadcrumbs: any[]
}>()
</script>

<template>
  <App
    :title="author.name"
    icon="quill"
  >
    <ShowContainer
      :model="author"
      :title="author.name"
      :cover="author.cover_standard"
      :cover-color="author.cover_color"
      :overview="author.description"
    >
      //
    </ShowContainer>
  </App>
</template>
