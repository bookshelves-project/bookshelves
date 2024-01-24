<script lang="ts" setup>
import { useDate, useInertia } from '@kiwilan/typescriptable-laravel'
import type { DetailsMedia } from './Container.vue'

// import type { DetailsMedia } from '../Index.vue'
// import { useUtils } from '@/Composables/useUtils'
// import { useMembers } from '@/Composables/useMembers'

const props = defineProps<DetailsMedia>()

// const { page } = useInertia()
// const { popularityFormat, bytesToHuman } = useUtils()
// const { actors } = useMembers(props.model?.members)

// const isGuest = page.props.auth.user.role === 'guest'
</script>

<template>
  <section class="card">
    <div class="flex flex-col gap-6 md:flex-row mt-6">
      <div class="relative hidden flex-none rounded-md md:block">
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
            class="hidden sm:block aspect-cover w-[9rem] flex-none rounded-md object-cover md:hidden"
            :src="cover"
            :color="coverColor"
            :alt="title"
          />
          <div>
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
            <div class="mt-4 text-sm">
              <div
                v-if="properties"
                class="flex flex-wrap gap-3"
              >
                <span
                  v-for="property in properties.filter(property => property)"
                  :key="property"
                >
                  {{ property }}
                </span>
              </div>
              <div
                v-if="badges"
                class="mt-3 flex flex-wrap gap-3"
              >
                <AppBadge
                  v-for="badge in badges.filter(badge => badge)"
                  :key="badge"
                >
                  {{ badge }}
                </AppBadge>
              </div>
            </div>
            <div
              v-if="tags"
              class="mt-3 text-sm"
            >
              <ShowTags :tags="tags" />
            </div>
            <div class="mt-5 flex items-center space-x-3 text-sm">
              <!-- <a
                v-if="popularity"
                class="flex items-center space-x-2 link"
                title="TMDB popularity"
                :href="tmdbUrl"
                target="_blank"
                rel="noopener noreferrer"
              >
                <SvgIcon
                  name="tmdb"
                  class="h-4 w-4 text-green-500"
                />
                <span>{{ popularityFormat(popularity) }} on TMDB</span>
              </a>
              <a
                v-if="imdbId"
                class="flex items-center space-x-2 link"
                title="IMDB"
                :href="`https://www.imdb.com/title/${imdbId}`"
                target="_blank"
                rel="noopener noreferrer"
              >
                <SvgIcon
                  name="imdb"
                  class="w-6"
                />
                <span>IMDB</span>
              </a> -->
            </div>
          </div>
        </div>
        <div class="mb-6 mt-8 flex items-center space-x-3">
          <!-- <AppButton
            v-if="!isGuest && file"
            :href="file.download_url"
            icon="download"
            download
          >
            <span>Download</span>
            <span class="ml-1">({{ bytesToHuman(file.size) }})</span>
          </AppButton> -->
          <AppButton
            icon="download"
            download
          >
            <span>Download</span>
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
          <p>{{ overview }}</p>
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
