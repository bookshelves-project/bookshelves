<template>
  <create-context v-slot="{ title }" resource="testimonies">
    <app-aside :title="title" class="w-128">
      <testimony-form :method="method" :url="url" />
    </app-aside>
  </create-context>
</template>

<script lang="ts" setup>
import route from 'ziggy-js'

const method = 'post'
const url = route('admin.testimonies.store')
</script>
