<template>
  <edit-context v-slot="{ title }" resource="users" :item="user">
    <app-aside :title="title" class="w-96">
      <user-form :method="method" :url="url">
        <template #actions>
          <impersonate-button hide-label />
          <delete-button hide-label />
        </template>
      </user-form>
    </app-aside>
  </edit-context>
</template>

<script lang="ts" setup>
  import { User } from '@admin/types'
  import { PropType } from 'vue'
  import route from 'ziggy-js'

  const props = defineProps({
    user: {
      type: Object as PropType<User>,
      required: true,
    },
  })

  const method = 'put'
  const url = route('admin.users.update', { id: props.user.id })
</script>
