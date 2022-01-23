<template>
  <create-context v-slot="{ title }" resource="users">
    <app-aside :title="title" class="w-96">
      <user-form :method="method" :url="url" />
    </app-aside>
  </create-context>
</template>

<script lang="ts" setup>
  import route from 'ziggy-js'

  const method = 'post'
  const url = route('admin.users.store')
</script>
