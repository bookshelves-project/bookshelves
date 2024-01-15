<script lang="ts" setup>
defineProps<{
  title?: string
  back?: string
  icon?: SvgName
}>()
</script>

<template>
  <main>
    <header class="relative flex items-center border-b border-white/5">
      <ILink
        v-if="back"
        class="px-5 hover:bg-gray-700 ml-6 rounded-md py-4 sm:py-6"
        :href="back"
      >
        <SvgIcon
          name="arrow-left"
          class="h-5 w-5 text-white"
        />
      </ILink>
      <div
        v-if="icon"
        class="px-5 ml-6 rounded-md py-4 sm:py-6"
      >
        <SvgIcon
          v-if="icon"
          class="h-6 w-6 text-white"
          :name="icon"
        />
      </div>
      <h1
        v-if="title"
        class="text-base font-semibold leading-7 text-white px-5 py-4 sm:py-6"
      >
        {{ title }}
      </h1>
    </header>
    <ul
      class="divide-y divide-white/5"
      role="list"
    >
      <slot />
    </ul>
  </main>
</template>
