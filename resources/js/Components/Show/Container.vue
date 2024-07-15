<script lang="ts" setup>
export interface DetailsMedia {
  backdrop?: string
  cover?: string
  coverColor?: string
  library?: App.Models.Library
  title?: string
  eyebrow?: string
  undertitle?: string
  overview?: string
  properties?: Array<string | number | undefined>
  badges?: Array<string | number | undefined>
  tags?: App.Models.Tag[]
  download?: {
    url?: string
    size?: string
    extension?: string
    direct?: boolean
    filename?: string
  }
  breadcrumbs?: any[]
  square?: boolean
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
        class="hidden lg:block"
      />
      <Transition
        name="fade"
        mode="out-in"
      >
        <ShowMedia
          v-if="display === 'media'"
          v-bind="props"
        >
          <template
            v-if="library"
            #before
          >
            <AppBadge
              v-if="library"
              size="md"
              class="mb-3"
            >
              <SvgIcon
                :name="(library.type as SvgName)"
                class="w-5 h-5 mr-2"
              />
              <span class="text-md">
                Type : {{ library.type_label }}
              </span>
            </AppBadge>
          </template>
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
