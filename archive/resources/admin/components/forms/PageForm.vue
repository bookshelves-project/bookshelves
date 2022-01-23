<template>
  <base-form v-slot="{ processing }" :method="method" :url="url">
    <div class="flex flex-col xl:flex-row gap-6">
      <div class="xl:w-3/4">
        <div v-if="template">
          <component :is="`${template}-form`" @uploading="onUpload" />
        </div>
        <div v-else class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
          <div>
            <editor-input source="body" :height="800" />
          </div>
        </div>
      </div>

      <div class="xl:flex-1">
        <div
          class="flex flex-col gap-4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md"
        >
          <div>
            <text-input source="title" type="text" />
          </div>

          <div>
            <text-input
              source="slug"
              type="text"
              :hint="$t('Leave empty for auto generate the link.')"
            />
          </div>
          <div>
            <switch-input source="active" :model-value="true" />
          </div>
          <div>
            <radio-group-input source="universe" choices="universes" />
          </div>
          <div class="flex">
            <base-button
              type="submit"
              variant="success"
              :loading="processing"
              :disabled="uploading"
              class="ml-auto"
            >
              {{ $t('Save') }}
            </base-button>
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
  template: String,
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
