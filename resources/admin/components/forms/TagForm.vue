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

<template>
  <base-form ref="form" v-slot="{ processing }" :method="method" :url="url">
    <div class="form-grid">
      <card-content>
        <text-input source="name" type="text" />
        <select-input source="type" choices="tag_types" />
        <i18n-input source="slug" type="text" full />
        <form-button :processing="processing" :submit="submit" />
      </card-content>
    </div>
  </base-form>
</template>
