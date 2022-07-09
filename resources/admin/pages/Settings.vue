<template>
  <app-layout :title="title">
    <div class="max-w-sm">
      <div class="flow-root mt-6">
        <ul
          role="list"
          class="-my-5 divide-y divide-gray-200 dark:divide-gray-700"
        >
          <li
            v-for="(item, index) in configuration"
            :key="index"
            class="py-4">
            <div class="flex items-center space-x-4">
              <div class="flex-1 min-w-0">
                <p
                  class="text-base font-medium text-gray-900 dark:text-gray-100"
                >
                  {{ item.key }}
                </p>
                <p class="text-base text-gray-500 dark:text-gray-400">
                  {{ item.value }}
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </app-layout>
</template>

<script setup lang="ts">
import { useTitle } from '@admin/features/helpers'

const title = useTitle('Settings')

defineProps<{
  configuration: any
}>()
</script>
