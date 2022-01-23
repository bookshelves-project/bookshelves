<template>
  <app-layout>
    <template #header>
      <h1>{{ title }}</h1>
    </template>

    <h2 class="mb-4 font-semibold text-2xl">
      {{ $tc('crud.posts.name', 10) }}
    </h2>

    <div class="flex flex-wrap gap-8">
      <inertia-link
        v-for="post in posts.data"
        :key="post.id"
        class="flex w-[calc(30%)] overflow-hidden rounded"
        :href="route('admin.posts.edit', { id: post.id })"
      >
        <div
          v-if="post.featured_image[0].preview_url"
          class="flex-none w-48 relative"
        >
          <img
            :src="post.featured_image[0].preview_url"
            alt=""
            class="absolute inset-0 w-full h-full object-cover"
          />
        </div>
        <div class="flex-auto p-6 bg-white">
          <div class="flex flex-wrap">
            <h1 class="flex-auto text-xl font-semibold">
              {{ post.title }}
            </h1>
            <div
              class="w-full flex-none text-sm font-medium text-gray-500 mt-2"
            >
              {{ post.summary }}
            </div>
          </div>
        </div>
      </inertia-link>
    </div>
  </app-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'
  import { PaginatedData, Post } from '@admin/types'
  import { computed, PropType } from 'vue'

  const props = defineProps({
    query: {
      type: String,
      required: true,
    },
    posts: {
      type: Object as PropType<PaginatedData<Post>>,
      required: true,
    },
  })

  const title = computed(() => {
    return useTitle('Search :query', {
      args: { query: props.query },
    })
  })
</script>
