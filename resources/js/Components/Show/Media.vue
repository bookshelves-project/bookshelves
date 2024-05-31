<script lang="ts" setup>
import type { DetailsMedia } from './Container.vue'

const props = defineProps<DetailsMedia>()
const propertiesList = computed(() => {
  return props.properties?.filter(property => property)
})
const badgesList = computed(() => {
  return props.badges?.filter(badge => badge)
})
const tagsList = computed(() => {
  return props.tags?.filter(tag => tag)
})
</script>

<template>
  <section class="card mt-10">
    <div class="lg:grid grid-cols-6 gap-10 space-y-6 lg:space-y-0">
      <div
        :class="{
          'aspect-square lg:aspect-poster md:h-64 lg:h-[unset]': !props.square,
          'aspect-square': props.square,
        }"
        class="book-shadow block overflow-hidden bg-gray-900 rounded-md col-span-2"
      >
        <AppImg
          class="object-cover h-full w-full"
          :src="cover"
          :alt="title"
        />
      </div>
      <section class="col-span-4">
        <div>
          <slot name="before" />
          <div class="flex gap-1 text-sm text-gray-300">
            {{ eyebrow }}
            <slot name="eyebrow" />
          </div>
          <h2 class="mt-1 text-3xl font-semibold">
            <slot name="title" />
            {{ title }}
          </h2>
          <div class="mt-1 flex gap-1 text-sm text-gray-300">
            <slot name="undertitle" />
            {{ undertitle }}
          </div>
          <div
            v-if="propertiesList?.length || badgesList?.length"
            class="mt-4 text-sm"
          >
            <div
              v-if="propertiesList"
              class="flex flex-wrap gap-3"
            >
              <span
                v-for="property in propertiesList"
                :key="property"
              >
                {{ property }}
              </span>
            </div>
            <div
              v-if="badgesList"
              class="mt-3 flex flex-wrap gap-3"
            >
              <AppBadge
                v-for="badge in badgesList"
                :key="badge"
              >
                {{ badge }}
              </AppBadge>
            </div>
          </div>
          <div
            v-if="tagsList?.length"
            class="mt-3 text-sm"
          >
            <ShowTags :tags="tagsList" />
          </div>
        </div>
        <div
          v-if="download && download?.url"
          class="mb-6 mt-8 flex items-center space-x-3"
        >
          <AppButton
            :href="download.url"
            icon="download"
            download
          >
            <span>Download</span>
            <span class="uppercase ml-1">{{ download.extension }}</span>
            <span class="ml-1">({{ download.size }})</span>
          </AppButton>
          <slot name="buttons" />
        </div>
        <div
          v-if="overview"
          class="mt-3"
        >
          <CardText :text="overview" />
        </div>
        <div class="mt-6">
          <slot name="bottom" />
        </div>
      </section>
    </div>
    <div class="mt-16" />
    <div class="space-y-10">
      <slot name="swipers" />
    </div>
  </section>
</template>
