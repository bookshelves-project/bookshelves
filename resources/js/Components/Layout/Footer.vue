<script lang="ts" setup>
import { useInertia, useRouter } from '@kiwilan/typescriptable-laravel'

const beginYear = 2021
const currentYear = new Date().getFullYear()

const year = currentYear > beginYear ? `${beginYear} - ${currentYear}` : beginYear

const { page } = useInertia()
</script>

<template>
  <footer class="mt-8 mb-6 md:mt-0 md:mb-0">
    <div class="md:flex md:items-center md:justify-between w-full px-6">
      <div class="flex justify-center space-x-6 md:order-2">
        <!-- <ILink
          :href="route('pages.legal')"
          class="text-gray-400 hover:text-gray-300 flex items-center space-x-2"
          title="Legal"
        >
          <span>Legal</span>
          <SvgIcon
            name="info"
            class="h-5 w-5"
          />
        </ILink> -->
      </div>
      <div class="mt-4 md:order-1 md:mt-0">
        <p class="text-xs leading-5 text-gray-400 flex items-center space-x-1 justify-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 980 980"
            class="fill-current h-2.5 w-2.5 inline-block"
          >
            <circle
              cx="490"
              cy="490"
              r="440"
              fill="none"
              stroke="currentColor"
              stroke-width="100"
            />
            <path d="M219,428H350a150,150 0 1 1 0,125H219a275,275 0 1 0 0-125z" />
          </svg>
          <span>{{ year }} Bookshelves, v{{ page.props.appVersion }}. No rights reserved.</span>
        </p>
      </div>
    </div>
  </footer>
</template>
