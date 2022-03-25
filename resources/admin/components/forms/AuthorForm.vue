<template>
  <base-form ref="form" v-slot="{ processing }" :method="method" :url="url">
    <div class="form-grid">
      <card-content>
        <div class="form-split">
          <text-input source="lastname" type="text" />
        </div>
        <div class="form-split">
          <text-input source="firstname" type="text" />
        </div>
        <div class="form-split">
          <select-input source="role" choices="author_roles" />
        </div>
        <div class="form-split">
          <text-input source="link" type="text" />
        </div>
        <div class="form-full">
          <text-input source="note" multiline />
        </div>
        <div class="form-full">
          <editor-input source="description" :height="800" />
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
