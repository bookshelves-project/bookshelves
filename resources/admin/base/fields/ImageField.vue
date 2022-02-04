<template>
  <div class="flex gap-4">
    <template v-for="(media, i) in value" :key="i">
      <a
        v-if="canPreview && media[original]"
        :href="media[original]"
        target="_blank"
        @click.stop
      >
        <img
          v-if="media[preview]"
          :src="media[preview]"
          :width="width"
          :height="height"
          :class="`max-w-max object-cover h-32 w-32`"
          :alt="media.name"
        />
        <span v-else>{{ media.name }}</span>
      </a>
      <span v-else>
        <img
          v-if="media[preview]"
          :src="media[preview]"
          :width="width"
          :height="height"
          class="max-w-max"
          :alt="media.name"
        />
        <span v-else>{{ media.name }}</span>
      </span>
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
    preview: {
      type: String,
      default: 'preview_url',
    },
    original: {
      type: String,
      default: 'original_url',
    },
    width: {
      type: Number,
      default: 100,
    },
    height: {
      type: Number,
      default: 100,
    },
    canPreview: Boolean,
  })
</script>
