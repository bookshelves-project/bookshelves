<template>
  <edit-context v-slot="{ title }" resource="blocks" :item="block">
    <app-aside :title="title" class="w-128">
      <block-form :method="method" :url="url">
        <template #actions>
          <delete-button hide-label />
        </template>
      </block-form>
    </app-aside>
  </edit-context>
</template>

<script lang="ts" setup>
import { Block } from '@admin/types'
import { PropType } from 'vue'
import route from 'ziggy-js'

const props = defineProps({
  block: {
    type: Object as PropType<Block>,
    required: true,
  },
})

const method = 'put'
const url = route('admin.blocks.update', { id: props.block.id })
</script>
