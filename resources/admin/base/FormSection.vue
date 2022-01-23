<template>
  <div
    class="md:grid md:gap-6"
    :class="{ 'md:grid-cols-3': !!$slots.title || !!$slots.description }"
  >
    <section-title>
      <template #title><slot name="title"></slot></template>
      <template #description><slot name="description"></slot></template>
    </section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
      <base-form
        v-slot="{ processing, recentlySuccessful }"
        :method="method"
        :url="url"
        :options="options"
        :item="item"
      >
        <div
          class="px-4 py-5 bg-white sm:p-6 shadow"
          :class="
            hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'
          "
        >
          <div class="grid grid-cols-6 gap-6">
            <slot name="form"></slot>
          </div>
        </div>

        <div
          v-if="hasActions"
          class="
            flex
            items-center
            justify-end
            px-4
            py-3
            bg-gray-50
            text-right
            sm:px-6
            shadow
            sm:rounded-bl-md sm:rounded-br-md
          "
        >
          <slot
            name="actions"
            :processing="processing"
            :recently-successful="recentlySuccessful"
          ></slot>
        </div>
      </base-form>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { computed, useSlots } from 'vue'

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
    item: Object,
  })

  const hasActions = computed(() => !!useSlots().actions)
</script>
