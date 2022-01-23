<template>
  <edit-context v-slot="{ title }" resource="services" :item="service">
    <app-aside :title="title" class="w-96">
      <service-form :method="method" :url="url">
        <template #actions>
          <delete-button hide-label />
        </template>
      </service-form>
    </app-aside>
  </edit-context>
</template>

<script lang="ts" setup>
import { Service } from '@admin/types'
import { PropType } from 'vue'
import route from 'ziggy-js'

const props = defineProps({
  service: {
    type: Object as PropType<Service>,
    required: true,
  },
})

const method = 'put'
const url = route('admin.services.update', { id: props.service.id })
</script>
