<template>
  <create-context v-slot="{ title }" resource="blocks">
    <app-aside :title="title" class="w-128">
      <block-form :method="method" :url="url" />
    </app-aside>
  </create-context>
</template>

<script lang="ts" setup>
import route from 'ziggy-js'

const method = 'post'
const url = route('admin.blocks.store')
</script>
