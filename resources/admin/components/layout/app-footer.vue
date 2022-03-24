<template>
  <footer>
    <div
      class="mx-auto pt-12 pb-5 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8"
    >
      <div class="flex justify-center space-x-6 md:order-2">
        <a
          v-for="item in navigation"
          :key="item.name"
          :href="item.href"
          class="text-gray-400 hover:text-gray-500"
        >
          <!-- <span class="sr-only">{{ item.name }}</span>
          <component :is="item.icon" class="h-6 w-6" aria-hidden="true" /> -->
          {{ item.name }}
        </a>
      </div>
      <div class="mt-8 md:mt-0 md:order-1">
        <p class="flex items-center text-center text-base text-gray-400">
          <creative-commons /><span class="ml-1">
            · {{ title }} Teams.
            <a
              href="https://github.com/adr1enbe4udou1n/laravel-rad-stack"
              target="_blank"
              rel="noopener noreferrer"
              class="hover:text-gray-600"
              >Powered by Laravel RAD Stack</a
            >.</span
          >
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
  import { getAppName, getProps } from '@admin/features/helpers'
  import route from 'ziggy-js'
  import Git from '@admin/svg/git.svg'
  import Api from '@admin/svg/api.svg'
  import Wiki from '@admin/svg/wiki.svg'

  const title = getAppName()
  const props = getProps()

  const navigation = [
    {
      name: 'Documentation',
      href: props.documentationUrl,
      icon: Wiki,
    },
    {
      name: 'API Documentation',
      href: route('scribe'),
      icon: Api,
    },
    {
      name: 'Git',
      href: props.repositoryUrl,
      icon: Git,
    },
  ]
</script>
