<template>
  <div class="flex gap-4">
    <!-- <template v-for="(media, i) in value" :key="i">
      <a
        v-if="canPreview && media.original_url"
        :href="media.original_url"
        target="_blank"
        @click.stop
      >
        <img
          v-if="media.preview_url"
          :src="media.preview_url"
          :width="width"
          :height="height"
          class="max-w-max"
          :alt="media.name"
        />
        <span v-else>{{ media.name }}</span>
      </a>
      <span v-else>
        <img
          v-if="media.preview_url"
          :src="media.preview_url"
          :width="width"
          :height="height"
          class="max-w-max"
          :alt="media.name"
        />
        <span v-else>{{ media.name }}</span>
      </span>
    </template> -->
  </div>
</template>

<script lang="ts" setup>
// import { MediaLibrary } from '@spatie/media-library-pro-core/dist/types'
// import { PropType } from 'vue'

defineProps({
  // value: {
  //   type: [String, Object] as
  //     | PropType<MediaLibrary.MediaAttributes[]>
  //     | PropType<{ [uuid: string]: MediaLibrary.MediaAttributes }>,
  //   required: true,
  // },
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
