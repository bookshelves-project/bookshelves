<script lang="ts" setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: [Object, Array],
    required: true,
  },
  text: String,
  resource: String,
  i18n: Boolean,
  link: String,
})

const locale = computed(() => usePage().props.value.locale)

const isArray = computed(() => {
  return Array.isArray(props.value)
})

const getLocaleText = (value: object): string => {
  // eslint-disable-next-line no-prototype-builtins
  if (value.hasOwnProperty(locale.value))
    return value[locale.value]
  else
    return value[Object.keys(props.value)[0]]
}
const getText = computed((): string => {
  const value = props.text ? props.value[props.text] : props.value
  if (props.i18n)
    return getLocaleText(value)
  else
    return value
})
</script>

<template>
  <div>
    <div
      v-if="isArray"
      class="badge"
    >
      <div v-if="!link && value">
        <span
          v-for="(item, index) in value"
          :key="index"
        >
          {{ item instanceof Object && text ? item[text] : '' }}
        </span>
      </div>
      <span v-else-if="value">
        <inertia-link
          v-for="(item, index) in value"
          :key="index"
          class="badge-link"
          :href="route(`admin.${resource}.${link}`, item.id)"
          @click.stop
        >
          <span>{{ item instanceof Object && text ? item[text] : '' }}</span>
        </inertia-link>
      </span>
    </div>
    <div
      v-else
      class="badge"
    >
      <div v-if="!link && value">
        <span>{{ getText }}</span>
      </div>
      <inertia-link
        v-else-if="value"
        class="badge-link"
        :href="route(`admin.${resource}.${link}`, value.id)"
        @click.stop
      >
        <span>{{ getText }}</span>
      </inertia-link>
    </div>
  </div>
</template>

<style lang="css" scoped>
.badge {
  & a,
  span {
    @apply max-w-48 whitespace-pre-wrap rounded-md;
    word-wrap: break-word;
    width: max-content;
  }
}
.badge-link {
  @apply block hover:bg-gray-200 dark:hover:bg-gray-700 p-2 transition-all duration-75 underline underline-offset-2 underline-gray-500;
  & span {
    @apply;
  }
}
</style>
