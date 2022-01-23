<template>
  <edit-context v-slot="{ title }" resource="testimonies" :item="testimony">
    <app-aside :title="title" class="w-128">
      <testimony-form :method="method" :url="url">
        <template #actions>
          <delete-button hide-label />
        </template>
      </testimony-form>
    </app-aside>
  </edit-context>
</template>

<script lang="ts" setup>
import { Testimony } from '@admin/types'
import { PropType } from 'vue'
import route from 'ziggy-js'

const props = defineProps({
  testimony: {
    type: Object as PropType<Testimony>,
    required: true,
  },
})

const method = 'put'
const url = route('admin.testimonies.update', { id: props.testimony.id })
</script>
