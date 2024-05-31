<script lang="ts" setup>
defineProps<{
  square?: boolean
  title?: string
  cover?: string
  href?: string
  carousel?: boolean
  color?: string
  hideTop?: boolean
}>()

const slots = useSlots()
</script>

<template>
  <ILink
    :href="href || '#'"
  >
    <li
      class="relative hover-zoom"
      :title="title"
    >
      <div
        class="model-card book-shadow"
        :class="{
          'h-[20rem]': carousel,
          'aspect-square': square,
          'aspect-poster': !square,
        }"
      >
        <AppImg
          :src="cover"
          :color="color || '#000000'"
          :alt="title"
          class="model-card_image"
        />
      </div>
      <div class="mt-2 block space-y-0.5">
        <p class="truncate text-sm font-medium text-gray-100">
          <slot name="title" />
        </p>
        <p
          v-if="slots.subtitle"
          class="text-xs text-gray-200 line-clamp-1"
        >
          <slot name="subtitle" />
        </p>
        <p
          v-if="slots.extra"
          class="text-sm text-gray-400 line-clamp-1 max-w-44"
        >
          <slot name="extra" />
        </p>
      </div>
      <div
        v-if="!hideTop"
        class="absolute top-0 h-24 model-card_top w-full"
      />
      <div
        v-if="!hideTop"
        class="absolute top-2 flex justify-between w-full px-4 italic text-sm"
      >
        <div
          v-if="slots.topLeft"
          class="model-card_text-shadow font-medium"
        >
          <slot name="topLeft" />
        </div>
        <div
          v-if="slots.topRight"
          class="model-card_text-shadow font-medium"
        >
          <slot name="topRight" />
        </div>
      </div>
    </li>
  </ILink>
</template>

<style lang="css" scoped>
.model-card_top {
  @apply bg-gradient-to-b from-gray-900/90 via-gray-900/60 to-white/0;
}

.model-card {
  @apply block w-full overflow-hidden;
  @apply bg-gray-900;
  @apply rounded-md;
}

.model-card :deep(.model-card_image) {
  @apply object-cover group-hover:opacity-75;
  @apply h-full w-full;
}

.model-card_text-shadow {
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 1);
}
</style>
