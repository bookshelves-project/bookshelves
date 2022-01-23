<template>
  <TabGroup>
    <TabList class="flex pt-1 px-2 bg-gray-200 sm:rounded-t-md">
      <Tab
        v-for="(item, i) in items"
        :key="i"
        v-slot="{ selected }"
        as="template"
      >
        <button
          :class="[
            'w-full py-2.5 text-sm rounded-t-md focus:outline-none',
            selected ? 'bg-white' : 'hover:bg-white/[0.12] hover:text-orange',
          ]"
        >
          {{ itemText ? item[itemText] : item }}
        </button>
      </Tab>
    </TabList>

    <TabPanels>
      <TabPanel
        v-for="(item, i) in items"
        :key="i"
        :class="['px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md']"
      >
        <slot :name="`panel-${i}`" />
      </TabPanel>
    </TabPanels>
  </TabGroup>
</template>

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

  defineProps({
    items: Array as PropType<{ [key: string]: string }[]>,
    itemText: String,
  })
</script>
