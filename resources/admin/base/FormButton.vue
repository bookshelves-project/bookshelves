<script setup lang="ts">
import { ref, watch } from 'vue'

const props = defineProps<{
  processing: boolean
  submit: () => void
}>()

const loading = ref(false)

watch(
  () => props.processing,
  (newVal) => {
    loading.value = newVal
  }
)

const send = () => {
  props.submit()
}
</script>

<template>
  <div class="flex form-full mt-auto">
    <base-button
      class="ml-auto"
      type="button"
      variant="success"
      :loading="processing"
      @click="send()"
    >
      {{ $t('Save') }}
    </base-button>
  </div>
</template>
