<template>
  <show-context v-slot="{ title }" resource="users" :item="user">
    <app-aside :title="title" class="w-96">
      <div class="flex flex-col gap-4">
        <div>
          <field source="name" />
        </div>
        <div>
          <field source="email" type="email" />
        </div>
        <div>
          <field source="active" type="boolean" />
        </div>
        <div>
          <field source="role" type="select" choices="roles" />
        </div>
        <div>
          <field source="last_login_at" type="date" />
        </div>
        <div>
          <field source="created_at" type="date" format="dd/MM/yyyy" />
        </div>
        <div>
          <field source="updated_at" type="date" format="dd/MM/yyyy" />
        </div>
        <div class="flex">
          <edit-button class="ml-auto" />
        </div>
      </div>
    </app-aside>
  </show-context>
</template>

<script lang="ts" setup>
  import { User } from '@admin/types'
  import { PropType } from 'vue'

  defineProps({
    user: {
      type: Object as PropType<User>,
      required: true,
    },
  })
</script>
