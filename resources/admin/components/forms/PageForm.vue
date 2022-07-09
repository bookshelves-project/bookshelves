<template>
  <base-form
    ref="form"
    v-slot="{ processing }"
    :method="method"
    :url="url">
    <div class="form-grid">
      <card-content>
        <text-input
          source="title"
          type="text" />
        <text-input
          source="meta_title"
          type="text" />
        <text-input
          source="summary"
          type="text"
          multiline />
        <text-input
          source="meta_description"
          type="text"
          multiline />
        <editor-input
          source="body"
          :height="800"
          options="complete"
          full />
      </card-content>
      <card-side>
        <file-input
          source="featured_image"
          file-source="featured_image_file"
          delete-source="featured_image_delete"
          preview
          preview-attr="url"
          full
        />
        <text-input
          source="slug"
          type="text"
          full />
        <text-input
          source="published_at"
          type="date"
          full />
        <form-button
          :processing="processing"
          :submit="submit" />
      </card-side>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue'

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

const form: Ref<HTMLElement | null | any> = ref(null)

const submit = () => {
  if (form.value) {
    form.value.submit()
  }
}
</script>
