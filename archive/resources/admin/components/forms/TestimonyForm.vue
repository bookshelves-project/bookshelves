<template>
  <base-form
    v-slot="{ processing }"
    class="flex flex-col gap-4"
    :method="method"
    :url="url"
  >
    <div>
      <text-input source="title" type="text" />
    </div>
    <div>
      <media-collection-input
        source="featured_image"
        name="featured_image"
        :accept="['image/png', 'image/jpeg']"
        :custom-properties="['description']"
        @uploading="onUpload"
      />
    </div>
    <div>
      <radio-group-input source="universe" choices="universes" />
    </div>
    <div>
      <text-input source="summary" multiline />
    </div>
    <div>
      <switch-input source="active" :model-value="true" />
    </div>
    <div>
      <text-input source="rating" type="number" />
    </div>
    <div>
      <text-input source="youtube_video_id" type="text" />
    </div>
    <div>
      <date-input source="published_at" />
    </div>
    <div class="flex mt-4">
      <base-button type="submit" :loading="processing" :disabled="uploading">
        {{ $t('Save') }}
      </base-button>
      <div class="flex gap-2 ml-auto">
        <slot name="actions" />
      </div>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

defineProps({
  method: {
    type: String,
    required: true,
  },
  url: {
    type: String,
    required: true,
  },
})

const uploading = ref(false)

const onUpload = (value: boolean) => {
  uploading.value = value
}
</script>
