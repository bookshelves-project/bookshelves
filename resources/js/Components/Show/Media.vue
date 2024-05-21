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
  <section class="card">
    <div class="flex flex-col gap-6 md:flex-row mt-6">
      <div class="relative hidden flex-none rounded-md lg:block">
        <AppImg
          class="hidden aspect-cover w-[20rem] flex-none self-start rounded-md object-cover md:block card-shadow"
          :src="cover"
          :color="coverColor"
          :alt="title"
        />
      </div>
      <div class="flex-auto">
        <div class="flex gap-6">
          <AppImg
            class="hidden md:block aspect-cover w-[9rem] flex-none rounded-md object-cover lg:hidden"
            :src="cover"
            :color="coverColor"
            :alt="title"
          />
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
          v-if="frenchTitle"
          class="mt-3 italic text-gray-300"
        >
          <p>French title<br>{{ frenchTitle }}</p>
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
      </div>
    </div>
    <div class="mt-16" />
    <div class="space-y-10">
      <!-- <SwiperMembers
        :members="actors"
        title="Actors"
      /> -->
      <slot name="swipers" />
    </div>
  </section>
</template>

<style lang="css" scoped>
.card :deep(.card-shadow) {
  box-shadow: var(--card-shadow);
  -webkit-box-shadow: var(--card-shadow);
  -moz-box-shadow: var(--card-shadow);
}
</style>
