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
          class="
            flex flex-col
            gap-4
            px-4
            py-5
            bg-white
            sm:p-6
            shadow
            sm:rounded-md
          "
        >
          <div>
            <field source="status" type="select" choices="post_statuses" />
          </div>
          <div>
            <rich-select-input
              source="user_id"
              label-key="user"
              resource="users"
              searchable
              :min-chars="3"
            />
          </div>
          <div>
            <date-input
              source="published_at"
              :hint="
                $t(
                  'If future date, the post will be automatically posted at this date.'
                )
              "
            />
          </div>
          <div>
            <switch-input source="pin" />
          </div>
          <div>
            <switch-input source="promote" />
          </div>
          <div class="flex">
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
        </div>
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md mt-6">
          <div>
            <file-input
              source="featured_image"
              file-source="featured_image_file"
              delete-source="featured_image_delete"
              preview
            />
          </div>
          <div class="mt-4">
            <reference-input
              source="category_id"
              label-key="category"
              resource="post-categories"
              allow-empty
            />
          </div>
          <div class="mt-4">
            <rich-select-input
              source="tags"
              resource="tags"
              multiple
              taggable
              searchable
              :min-chars="3"
              option-value="name"
              :getter="(post) => post.tags.map((t) => t.name)"
            />
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
