<template>
  <base-form
    v-slot="{ processing }"
    class="flex flex-col gap-4"
    :method="method"
    :url="url"
  >
    <div class="flex flex-col xl:flex-row gap-6">
      <div class="xl:w-3/4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
        <div>
          <text-input source="title" type="text" />
        </div>
        <div class="mt-4">
          <text-input
            source="slug"
            type="text"
            :hint="$t('Leave empty for auto generate the link.')"
          />
        </div>
        <div class="mt-4">
          <text-input source="summary" multiline />
        </div>
        <div class="mt-4">
          <editor-input source="body" :height="800" />
        </div>
      </div>

      <div class="xl:flex-1">
        <div
          class="flex flex-col gap-4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md"
        >
          <div>
            <reference-input
              source="faq_category_id"
              label-key="category"
              resource="faq-categories"
              :label="$ta('category')"
              option-text="name"
              allow-empty
            />
          </div>
          <div class="mt-4">
            <media-collection-input
              source="featured_image"
              name="featured_image"
              :accept="['image/png', 'image/jpeg']"
              :custom-properties="['description']"
              @uploading="onUpload"
            />
          </div>
          <div class="flex mt-4">
            <base-button type="submit" :loading="processing">
              {{ $t('Save') }}
            </base-button>
            <div class="flex gap-2 ml-auto">
              <slot name="actions" />
            </div>
          </div>
        </div>
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md mt-6">
          <div>
            <text-input source="meta_title" type="text" />
          </div>
          <div class="mt-4">
            <text-input source="meta_description" multiline />
          </div>
        </div>
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
