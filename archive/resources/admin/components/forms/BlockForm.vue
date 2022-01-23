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
      <text-input source="subtitle" type="text" />
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
      <radio-group-input source="section" choices="block_sections" />
    </div>
    <div>
      <radio-group-input source="content_position" choices="positions" />
    </div>
    <div>
      <text-input source="content" multiline />
    </div>
    <div>
      <switch-input source="active" :model-value="true" />
    </div>
    <div>
      <text-input source="cta_text" type="text" />
    </div>
    <div>
      <text-input source="cta_link" type="text" />
    </div>
    <div>
      <rich-select-input
        source="page_ids"
        resource="pages"
        searchable
        multiple
        option-text="title"
        :min-chars="3"
        :getter="(block) => block.pages.map((p) => p.id)"
      />
    </div>
    <div>
      <rich-select-input
        source="page_residence_ids"
        resource="page-residences"
        searchable
        multiple
        option-text="title"
        custom-search="residence.name"
        :min-chars="3"
        :getter="(block) => block.page_residences.map((p) => p.id)"
      />
    </div>
    <div>
      <rich-select-input
        source="post_ids"
        resource="posts"
        searchable
        multiple
        option-text="title"
        :min-chars="3"
        :getter="(block) => block.posts.map((p) => p.id)"
      />
    </div>
    <div>
      <text-input
        source="system_urls"
        multiline
        :hint="$ta('Separate each urls by a new line')"
      />
    </div>
    <div class="flex">
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

defineEmits(['submitted'])
</script>
