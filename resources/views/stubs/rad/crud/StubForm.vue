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
        <text-input
          source="stubAttr"
          type="text"
        />
      </card-content>
      <card-side>
        <form-button
          :processing="processing"
          :submit="submit"
        />
      </card-side>
    </div>
  </base-form>
</template>
