<script lang="ts" setup>
import type { Entity } from '@/Types'

interface Props {
  entity: Entity
  square?: boolean
  carousel?: boolean
}

withDefaults(defineProps<Props>(), {
  square: false,
})
</script>

<template>
  <CardModel
    :square="square"
    :cover="entity.cover_thumbnail"
    :title="entity.title"
    :href="entity.route"
    :carousel="carousel"
    :color="entity.cover_color"
  >
    <template #title>
      {{ entity.title }}
    </template>
    <template #subtitle>
      <template v-if="entity.serie">
        {{ entity.serie.title }} #{{ entity.volume }}
      </template>
      <template v-else-if="entity.count">
        {{ entity.count }} books
      </template>
      <template v-else />
    </template>
    <template #extra>
      {{ entity.class }}
      <template v-if="entity.library">
        from {{ entity.library?.name }}
      </template>
    </template>
    <template
      v-if="entity.language"
      #topLeft
    >
      {{ entity.language.name }}
    </template>
    <template
      v-if="entity.library"
      #topRight
    >
      {{ entity.library.type_label }}
    </template>
  </CardModel>
</template>
