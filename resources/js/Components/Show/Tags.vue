<script lang="ts" setup>
defineProps<{
  tags?: App.Models.Tag[]
}>()
</script>

<template>
  <div v-if="tags">
    <ul class="flex flex-wrap gap-1">
      <li
        v-for="(tag, id) in tags"
        :key="id"
      >
        <ILink
          class="text-gray-300 hover:text-gray-100 link"
          :href="$route('tags.show', { tag: tag.slug })"
        >
          {{ tag.name }}{{ id === tags.length - 1 ? '' : ',' }}
        </ILink>
      </li>
    </ul>
  </div>
</template>
