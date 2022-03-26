<template>
  <base-form
    ref="form"
    v-slot="{ processing }"
    method="post"
    :url="url"
    :transform="
      (data) => ({
        ...data,
        _method: method,
      })
    "
    disable-submit
  >
    <div class="form-grid">
      <card-content>
        <text-input source="title" type="text" />
        <text-input source="meta_title" type="text" />
        <text-input source="summary" multiline />
        <text-input source="meta_description" multiline />
        <editor-input source="body" :height="800" full />
      </card-content>
      <card-side>
        <field source="status" type="select" choices="post_statuses" full />
        <text-input
          source="slug"
          type="text"
          :hint="$t('Leave empty for auto generate the link.')"
          full
        />
        <file-input
          source="featured_image"
          file-source="featured_image_file"
          delete-source="featured_image_delete"
          preview
          full
        />
        <rich-select-input
          source="user_id"
          label-key="user"
          resource="users"
          searchable
          :min-chars="0"
          full
        />
        <date-input
          source="published_at"
          :hint="
            $t(
              'If future date, the post will be automatically posted at this date.'
            )
          "
          full
        />
        <reference-input
          source="category_id"
          label-key="category"
          resource="post-categories"
          allow-empty
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
          :getter="(post) => post.tags.map((t) => t.name)"
          full
        />
        <switch-input source="pin" full />
        <switch-input source="promote" full />

        <div class="flex form-full">
          <dropdown class="ml-auto" wrapper-classes="w-72 right">
            <template #trigger>
              <base-button
                type="button"
                variant="success"
                :loading="processing"
                split
                @click="submit(true)"
              >
                {{ $t('Publish') }}
              </base-button>
            </template>

            <template #content>
              <dropdown-link type="button" @click.prevent="submit(false)">
                {{ $t('Save as draft') }}
              </dropdown-link>
            </template>
          </dropdown>
        </div>
      </card-side>
    </div>
  </base-form>
</template>

<script setup lang="ts">
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

const submit = (publish: boolean) => {
  if (form.value) {
    form.value.submit({ publish })
  }
}
</script>
