<template>
  <edit-context v-slot="{ title }" resource="posts" :item="post">
    <app-layout>
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
            <delete-button />
          </template>
        </page-header>
      </template>

      <post-form :method="method" :url="url" />
    </app-layout>
  </edit-context>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { Post } from '@admin/types'
  import route from 'ziggy-js'

  const props = defineProps({
    post: {
      type: Object as PropType<Post>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.posts.update', { id: props.post.id })
</script>
