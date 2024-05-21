<script lang="ts" setup>
import { useUtils } from '@/Composables/useUtils'
import type { Entity } from '@/Types'

interface Props {
  entity: Entity
  square?: boolean
  carousel?: boolean
}

withDefaults(defineProps<Props>(), {
  square: false,
})

const { ucfirst } = useUtils()
</script>

<template>
  <ILink
    :href="entity.route"
    :title="entity.title"
    class="relative"
  >
    <AppImg
      :class="{
        'poster ': !square,
        'album ': square,
        'h-[20rem]': carousel && !square,
        'h-[10rem]': carousel && square,
      }"
      class="w-full"
      :src="entity.cover_thumbnail"
      :color="entity.cover_color"
      :alt="entity.title"
    />
    <div class="absolute bg-gradient-to-b from-gray-900/60 via-gray-900/30 to-white/0 h-20 w-full top-0 z-10" />
    <div
      v-if="entity.language"
      class="card-info left-2 card-info-shadow"
    >
      {{ entity.language.name }}
    </div>
    <div
      v-if="entity.library"
      class="card-info right-2 card-info-shadow"
    >
      {{ ucfirst(entity.library.type) }}
    </div>
    <div class="mt-3">
      <p class="line-clamp-1 w-48">
        {{ entity.title }}
      </p>
      <p class="text-xs text-gray-200 line-clamp-1">
        <template v-if="entity.serie">
          {{ entity.serie.title }} #{{ entity.volume }}
        </template>
        <template v-else-if="entity.count">
          {{ entity.count }} books
        </template>
        <template v-else />
      </p>
      <p class="line-clamp-1 text-sm text-gray-400">
        {{ entity.class }}
        <template v-if="entity.library">
          from {{ entity.library?.name }}
        </template>
      </p>
    </div>
  </ILink>
</template>
