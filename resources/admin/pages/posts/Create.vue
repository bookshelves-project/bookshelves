<template>
  <create-context v-slot="{ title }" resource="posts">
    <app-layout>
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
          </template>
        </page-header>
      </template>

      <post-form :method="method" :url="url" />
    </app-layout>
  </create-context>
</template>

<script lang="ts" setup>
  import route from 'ziggy-js'

  const method = 'post'
  const url = route('admin.posts.store')
</script>
