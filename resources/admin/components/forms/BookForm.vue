<template>
  <base-form ref="form" v-slot="{ processing }" :method="method" :url="url">
    <div class="form-grid">
      <card-content>
        <div class="form-split">
          <text-input source="title" type="text" />
        </div>
        <div class="form-split">
          <text-input source="volume" type="number" />
        </div>
        <div class="form-split">
          <text-input source="isbn" type="text" />
        </div>
        <div class="form-split">
          <text-input source="isbn13" type="text" />
        </div>
        <div class="form-split">
          <reference-input
            source="language_slug"
            label-key="language"
            resource="languages"
            allow-empty
          />
        </div>
        <div class="form-split">
          <reference-input
            source="serie_id"
            label-key="serie"
            resource="series"
            option-text="title"
            allow-empty
          />
        </div>
        <div class="form-split">
          <reference-input
            source="publisher_id"
            label-key="publisher"
            resource="publishers"
            allow-empty
          />
        </div>
        <div class="form-split">
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
          />
        </div>
        <div class="form-full">
          <editor-input source="description" :height="800" />
        </div>
        <div class="form-split">
          <text-input source="contributor" type="text" />
        </div>
        <div class="form-split">
          <text-input source="rights" type="text" />
        </div>
      </card-content>
      <card-side>
        <div class="form-full">
          <file-input
            source="cover"
            file-source="cover_file"
            delete-source="cover_delete"
            preview
            preview-attr="url"
          />
        </div>
        <div class="form-full">
          <text-input source="slug" type="text" />
        </div>
        <div class="form-full">
          <text-input source="slug_sort" type="text" />
        </div>
        <div class="form-full">
          <select-input source="type" choices="book_types" />
        </div>
        <div class="form-full">
          <date-input source="released_on" :options="{ dateFormat: 'Y-m-d' }" />
        </div>
        <div class="form-full">
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
            :hint="
              $t(`Try
              to type any tag to find existing tag, if it not present click on
              it to create it.`)
            "
          />
        </div>
        <div class="form-full">
          <text-input source="page_count" type="number" />
        </div>
        <div class="form-full">
          <text-input source="maturity_rating" type="text" />
        </div>
        <div class="form-full">
          <switch-input source="disabled" />
        </div>
        <div class="flex form-full mt-auto">
          <base-button
            class="ml-auto"
            type="button"
            variant="success"
            :loading="processing"
            @click="submit()"
          >
            {{ $t('Save') }}
          </base-button>
        </div>
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
