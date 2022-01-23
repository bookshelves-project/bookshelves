<template>
  <div class="flex flex-col">
    <!-- <template v-for="(media, i) in value">
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
})
</script>
