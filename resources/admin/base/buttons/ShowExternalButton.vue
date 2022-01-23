<template>
  <base-button
    v-if="item"
    tag="a"
    icon="eye"
    :href="getPath"
    target="_blank"
    variant="success"
    :hide-label="hideLabel"
  >
    {{ $t('Show') }}
  </base-button>
</template>

<script lang="ts" setup>
  import { Model } from '@admin/types'
  import trimStart from 'lodash/trimStart'
  import get from 'lodash/get'
  import { computed, inject } from 'vue'
  import qs from 'qs'

  const props = defineProps({
    only: Array,
    hideLabel: Boolean,
    path: {
      type: String,
      required: true,
    },
    query: Object,
  })

  const item = inject<Model>('item')

  const getPath = computed(() => {
    let url = `/${trimStart(get(item, props.path), '/')}`

    if (props.query) {
      url += `?${qs.stringify(props.query)}`
    }
    return url
  })
</script>
