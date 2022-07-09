<template>
  <base-form
    ref="form"
    v-slot="{ processing }"
    :method="method"
    :url="url">
    <div class="form-grid">
      <card-content>
        <text-input
          source="lastname"
          type="text" />
        <text-input
          source="firstname"
          type="text" />
        <select-input
          source="role"
          choices="author_roles" />
        <text-input
          source="link"
          type="text" />
        <text-input
          source="note"
          multiline />
        <editor-input
          source="description"
          :height="800"
          full />
      </card-content>
      <card-side>
        <file-input
          source="cover"
          file-source="cover_file"
          delete-source="cover_delete"
          preview
          preview-attr="url"
          full
        />
        <text-input
          source="slug"
          type="text"
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
