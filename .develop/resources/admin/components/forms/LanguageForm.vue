<script lang="ts" setup>
import type { Ref } from 'vue'
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

const form: Ref<HTMLElement | null | any> = ref(null)

const submit = () => {
  if (form.value)
    form.value.submit()
}
</script>

<template>
  <base-form
    ref="form"
    v-slot="{ processing }"
    :method="method"
    :url="url"
  >
    <div class="form-grid">
      <card-content>
        <i18n-input
          source="name"
          type="text"
          full
        />
      </card-content>
      <card-side>
        <text-input
          source="slug"
          type="text"
          full
          readonly
        />
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
