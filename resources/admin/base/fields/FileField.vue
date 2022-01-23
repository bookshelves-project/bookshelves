<template>
  <div class="flex flex-col">
    <template v-for="(media, i) in value">
      <a
        v-if="media.original_url"
        :key="i"
        class="text-primary-500 underline"
        :href="media.original_url"
        target="_blank"
        @click.stop
      >
        {{ media.name }}
      </a>
    </template>
  </div>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { Media } from '@admin/types'

  defineProps({
    value: {
      type: [String, Object] as
        | PropType<Media[]>
        | PropType<{
            [uuid: string]: Media
          }>,
      required: true,
    },
  })
</script>
