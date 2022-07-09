<script setup lang="ts">
import { computed, defineAsyncComponent, useAttrs } from 'vue'
import Error from './error.vue'

const props = defineProps<{
  name?: string
}>()

const currentIcon = computed(() =>
  defineAsyncComponent({
    loader: () => import(`../svg/${props.name}.svg`),
    loadingComponent: {
      template: '<span></span>',
    },
    errorComponent: {
      template: '<span>error</span>',
    },
    delay: 200, // default: 200
    timeout: 3000, // default: Infinity
    suspensible: true, // default: true
    onError(error, retry, fail, attempts) {
      // if (error.message.match(/fetch/) && attempts <= 3) {
      //   retry()
      // } else {
      //   fail()
      // }
    },
  })
)
const attrs = useAttrs()
</script>

<template>
  <span>
    <component
      :is="currentIcon"
      :class="attrs.class" />
    <!-- <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        :class="attrs.class"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
        />
      </svg> -->
  </span>
</template>
