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
  <ILink
    :href="entity.route"
    :title="entity.title"
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
    <div class="mt-3">
      <p class="line-clamp-1">
        {{ entity.title }}
      </p>
      <p
        v-if="entity"
        class="text-xs text-gray-200 line-clamp-1"
      >
        <!-- {{ entity.serie.title }} #{{ entity.volume_pad }} -->
      </p>
      <p class="line-clamp-1 text-sm text-gray-400">
        <!-- {{ entity.authors?.map((author) => author.name).join(', ') }} -->
      </p>
    </div>
  </ILink>
</template>
