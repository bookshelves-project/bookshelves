<template>
  <base-form ref="form" v-slot="{ processing }" :method="method" :url="url">
    <div class="form-grid">
      <card-content>
        <div class="form-split">
          <text-input source="title" type="text" />
        </div>
        <div class="form-split">
          <text-input source="slug" type="text" />
        </div>
        <div class="form-full">
          <text-input source="summary" type="text" multiline />
        </div>
        <div class="form-full">
          <editor-input source="body" :height="800" />
        </div>
      </card-content>
      <card-side>
        <div class="form-full">
          <file-input
            source="image"
            file-source="image_file"
            delete-source="image_delete"
            preview
            preview-attr="url"
          />
        </div>
        <div class="form-full">
          <text-input source="meta_title" type="text" />
        </div>
        <div class="form-full">
          <text-input source="meta_description" type="text" />
        </div>
        <div class="form-full">
          <date-input
            source="published_at"
            :options="{ dateFormat: 'Y-m-d' }"
          />
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
