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
}

const props = defineProps<DetailsMedia>()

type Display = 'media' | 'crew' | 'metadata'
const display = ref<Display>('media')
const tabs: { name: Display, label?: string, displayed: boolean }[] = [
  {
    name: 'media',
    label: props.type,
    displayed: true,
  },
  // {
  //   name: 'crew',
  //   label: 'Crew & production',
  //   displayed: (props.model?.members && props.model?.members.length > 0) ?? false,
  // },
  // {
  //   name: 'metadata',
  //   label: 'Metadata',
  //   displayed: (props.file !== undefined && props.file.metadata !== null) ?? false,
  // },
]
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
      <div class="block mt-6">
        <div class="border-b border-gray-600">
          <nav
            class="-mb-px flex space-x-8"
            aria-label="Tabs"
          >
            <div
              v-for="tab in tabs"
              :key="tab.label"
            >
              <button
                v-if="tab.displayed"
                :class="{
                  'tab-active': display === tab.name,
                  'tab-inactive': display !== tab.name,
                }"
                class="tab"
                @click="display = tab.name"
              >
                {{ tab.label }}
              </button>
            </div>
          </nav>
        </div>
      </div>
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
