<script lang="ts" setup>
import route from 'ziggy-js'

const method = 'post'
const url = route('admin.languages.store')
</script>

<template>
  <create-context
    v-slot="{ title }"
    resource="languages"
  >
    <app-layout>
      <template #header>
        <page-header>
          <h1>{{ title }}</h1>
          <template #actions>
            <list-button />
          </template>
        </page-header>
      </template>

      <language-form
        :method="method"
        :url="url"
      />
    </app-layout>
  </create-context>
</template>
