<template>
  <base-form
    v-slot="{ processing }"
    class="flex flex-col gap-4"
    :method="method"
    :url="url"
  >
    <div>
      <text-input source="name" type="text" />
    </div>
    <div class="flex mt-4">
      <base-button type="submit" :loading="processing">
        {{ $t('Save') }}
      </base-button>
      <div class="flex gap-2 ml-auto">
        <slot name="actions" />
      </div>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
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
</script>
