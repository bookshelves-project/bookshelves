<template>
  <list-context v-slot="{ title }" resource="users">
    <app-layout>
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <create-button :only="['action']" />
          </template>
        </page-header>
      </template>

      <data-table
        :source="users"
        :columns="columns"
        :sort="sort"
        :filter="filter"
        row-click="edit"
      >
        <template #actions>
          <export-button />
        </template>
        <template #bulk-actions="{ selected }">
          <delete-bulk-button :selected="selected" />
        </template>
        <template #field:row-action="{ row }">
          <div class="flex gap-2 ml-auto">
            <show-button hide-label :only="['action', 'user']" />
            <edit-button
              v-if="canBeUpdated(row)"
              hide-label
              :only="['action', 'user']"
            />
            <impersonate-button v-if="canBeImpersonated(row)" hide-label />
            <delete-button
              v-if="canBeUpdated(row) && $page.props.auth.id !== row.id"
              hide-label
            />
          </div>
        </template>
      </data-table>

      <template v-if="action !== 'list'" #aside>
        <create-user v-if="action === 'create'" />
        <show-user v-if="user && action === 'show'" :user="user" />
        <edit-user v-if="user && action === 'edit'" :user="user" />
      </template>
    </app-layout>
  </list-context>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { PaginatedData, User } from '@admin/types'
  import { Column } from '@admin/types/data-table'

  defineProps({
    action: String,
    users: {
      type: Object as PropType<PaginatedData<User>>,
      required: true,
    },
    user: Object as PropType<User>,
    sort: String,
    filter: Object,
  })

  const columns: (string | Column)[] = [
    {
      field: 'id',
      width: 40,
      numeric: true,
      sortable: true,
    },
    {
      field: 'name',
      sortable: true,
      searchable: true,
    },
    {
      field: 'email',
      searchable: true,
      type: 'email',
    },
    {
      field: 'active',
      type: 'switch',
      searchable: true,
    },
    {
      field: 'role',
      type: 'select',
      props: { choices: 'roles' },
      searchable: true,
    },
    {
      field: 'last_login_at',
      type: 'date',
      props: { format: 'dd/MM/yyyy HH:mm:ss' },
      sortable: true,
      centered: true,
    },
    {
      field: 'created_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
    {
      field: 'updated_at',
      type: 'date',
      sortable: true,
      centered: true,
    },
    'row-action',
  ]

  const canBeUpdated = (item) => {
    return (item as User).can_be_updated
  }

  const canBeImpersonated = (item) => {
    return (item as User).can_be_impersonated
  }
</script>
