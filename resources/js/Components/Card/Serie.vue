<script lang="ts" setup>
import { useUtils } from '@/Composables/useUtils'

interface Props {
  serie: App.Models.Serie
  square?: boolean
}

withDefaults(defineProps<Props>(), {
  square: false,
})

const { ucfirst } = useUtils()
</script>

<template>
  <ILink
    :href="$route(`series.${serie.type}s.show` as any, { serie_slug: serie.slug })"
    class="relative"
  >
    <AppImg
      :class="{
        'poster h-[20rem]': !square,
        'album': square,
      }"
      class="w-full"
      :src="serie.cover_thumbnail"
      :color="serie.cover_color"
      :alt="serie.title"
    />
    <div class="absolute bg-gradient-to-b from-gray-900/60 via-gray-900/30 to-white/0 h-20 w-full top-0 z-10" />
    <div class="info left-2 text-shadow">
      {{ ucfirst(serie.type) }}
    </div>
    <div class="mt-3">
      <p class="line-clamp-1">
        {{ serie.title }}
      </p>
      <p
        v-if="serie.authors_names"
        class="text-xs text-gray-200 line-clamp-1"
      >
        {{ serie.authors_names }}
      </p>
      <div class="line-clamp-1 text-sm text-gray-400">
        <span v-if="serie.books_count">
          {{ serie.books_count }} books
        </span>
        <span v-if="serie.language">
          ({{ serie.language.name }})
        </span>
      </div>
    </div>
  </ILink>
</template>

<style lang="css" scoped>
.info {
  @apply absolute top-2 text-sm italic text-gray-200 z-20 font-semibold;
}
.text-shadow {
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 1);
}
</style>
