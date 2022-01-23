<template>
  <base-form v-slot="{ processing }" :method="method" :url="url">
    <div>
      <text-input source="name" type="text" />
    </div>
    <div class="mt-4">
      <text-input source="email" type="email" />
    </div>
    <div class="mt-4">
      <text-input source="password" type="password" />
    </div>
    <div class="mt-4">
      <switch-input source="active" :model-value="true" />
    </div>
    <div class="mt-4">
      <radio-group-input source="role" choices="roles" stacked />
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
