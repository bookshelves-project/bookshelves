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
          type="text"
          required />
        <text-input
          source="volume"
          type="number" />
        <text-input
          source="isbn10"
          type="text" />
        <text-input
          source="isbn13"
          type="text" />
        <reference-input
          source="language_slug"
          label-key="language"
          resource="languages"
          i18n
          required
        />
        <reference-input
          source="serie_id"
          label-key="serie"
          resource="series"
          option-text="title"
        />
        <reference-input
          source="publisher_id"
          label-key="publisher"
          resource="publishers"
        />
        <rich-select-input
          source="authors"
          resource="authors"
          label-key="authors"
          multiple
          taggable
          searchable
          :min-chars="0"
          option-value="name"
          :getter="(book) => book.authors.map((t) => t.name)"
          required
        />
        <editor-input
          source="description"
          :height="800"
          options="basic"
          full />
        <text-input
          source="contributor"
          type="text" />
        <text-input
          source="rights"
          type="text" />
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
          full
          required />
        <text-input
          source="slug_sort"
          type="text"
          full
          required />
        <select-input
          source="type"
          choices="book_types"
          full
          required />
        <date-input
          source="released_on"
          :options="{ dateFormat: 'Y-m-d' }"
          full
        />
        <rich-select-input
          source="tags"
          resource="tags"
          label-key="tags"
          multiple
          taggable
          searchable
          :min-chars="0"
          option-value="name"
          :getter="(book) => book.tags.map((t) => t.name)"
          full
        />
        <text-input
          source="page_count"
          type="number"
          full />
        <text-input
          source="maturity_rating"
          type="text"
          full />
        <switch-input
          source="disabled"
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
