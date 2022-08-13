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
        <file-drag-input full />
        <form-button
          :processing="processing"
          :submit="submit"
        />
      </card-content>
    </div>
  </base-form>
</template>
