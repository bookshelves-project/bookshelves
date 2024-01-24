<script lang="ts" setup>
interface Props {
  serie: App.Models.Serie
  square: boolean
}

withDefaults(defineProps<Props>(), {
  square: false,
})
</script>

<template>
  <ILink :href="$route('series.books.show', { serie_slug: serie.slug })">
    <AppImg
      :class="{
        'poster h-64': !square,
        'album': square,
      }"
      class="mx-auto"
      :src="serie.cover_thumbnail"
      :color="serie.cover_color"
      :alt="serie.title"
    />
    <div class="mt-3">
      <p class="line-clamp-2 text-center">
        {{ serie.title }}
      </p>
      <!-- <p>
        {{ book.serie?.title }} {{ book.volume_pad }}
      </p> -->
      <!-- <p>
        {{ book.authors?.map((author) => author.name).join(', ') }}
      </p> -->
    </div>
  </ILink>
</template>
