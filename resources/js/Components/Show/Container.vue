<script lang="ts" setup>
export interface DetailsMedia {
  backdrop?: string
  cover?: string
  coverColor?: string
  type?: string
  title?: string
  eyebrow?: string
  undertitle?: string
  popularity?: number
  tmdbUrl?: string
  imdbId?: string
  frenchTitle?: string
  overview?: string
  properties?: Array<string | number | undefined>
  badges?: Array<string | number | undefined>
  tags?: App.Models.Tag[]
  downloadUrl?: string
  downloadSize?: string
  download?: {
    url?: string
    size?: string
    extension?: string
  }
  breadcrumbs?: any[]
}

const props = defineProps<DetailsMedia>()

type Display = 'media' | 'crew' | 'metadata'
const display = ref<Display>('media')
</script>

<template>
  <div class="relative inline-block min-h-screen w-full overflow-hidden">
    <div
      v-if="backdrop"
      class="absolute inset-0 w-full bg-cover bg-fixed bg-center bg-no-repeat opacity-20 blur-md"
      :style="`background-image: url('${backdrop}');`"
    />
    <div class="main-container relative z-10 py-6">
      <slot name="breadcrumbs" />
      <Breadcrumbs
        v-if="breadcrumbs"
        :breadcrumbs="breadcrumbs"
      />
      <Transition
        name="fade"
        mode="out-in"
      >
        <ShowMedia
          v-if="display === 'media'"
          v-bind="props"
        >
          <template #title>
            <slot name="title" />
          </template>
          <template #eyebrow>
            <slot name="eyebrow" />
          </template>
          <template #undertitle>
            <slot name="undertitle" />
          </template>
          <template #buttons>
            <slot name="buttons" />
          </template>
          <template #bottom>
            <slot name="bottom" />
          </template>
          <template #swipers>
            <slot name="swipers" />
          </template>
        </ShowMedia>
        <!-- <ShowCrew
          v-else-if="display === 'crew'"
          :title="title"
          :model="model"
          :type="type"
          class="mt-6"
        /> -->
        <!-- <ShowMetadata
          v-else-if="file?.metadata && display === 'metadata'"
          :path="file?.relative_path"
          :metadata="file?.metadata"
        /> -->
      </Transition>
    </div>
  </div>
</template>

<style lang="css" scoped>
.tab {
  @apply whitespace-nowrap border-b-2 py-4 px-4 text-sm font-medium;
}
.tab-active {
  @apply border-purple-300 text-purple-300;
}
.tab-inactive {
  @apply border-transparent text-gray-400 hover:border-gray-400 hover:text-gray-100;
}
</style>
