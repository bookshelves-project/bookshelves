<template>
  <modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    @close="$emit('close')"
  >
    <base-form
      v-slot="{ processing }"
      :method="method"
      :url="url"
      :options="options"
      :data="data"
    >
      <div class="px-6 py-4">
        <div class="text-lg">
          <slot name="title"></slot>
        </div>

        <div class="mt-4">
          <slot name="content"></slot>
        </div>
      </div>

      <div class="px-6 py-4 bg-gray-100 text-right">
        <slot name="footer" :processing="processing"></slot>
      </div>
    </base-form>
  </modal>
</template>

<script lang="ts" setup>
  import {} from 'vue'

  defineProps({
    method: {
      type: String,
      required: true,
    },
    url: {
      type: String,
      required: true,
    },
    options: Object,
    data: Object,
    show: {
      type: Boolean,
      default: false,
    },
    maxWidth: {
      type: String,
      default: '2xl',
    },
    closeable: {
      type: Boolean,
      default: true,
    },
  })

  defineEmits(['close'])
</script>
