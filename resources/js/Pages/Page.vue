<script lang="ts" setup>
defineProps<{
  headers: {
    id: string
    label: string
    level: number
  }[]
  contents: string
  frontmatter: {
    title: string
    subtitle: string
    description: string
  }
  icon: SvgName
}>()
</script>

<template>
  <App
    :title="frontmatter.title"
    :icon="icon"
  >
    <main class="main-container relative items-start space-y-6 py-10 md:flex md:space-y-0 hide-backticks">
      <div class="order-2 space-y-2 md:sticky md:top-20">
        <a
          v-for="header in headers"
          :key="header.id"
          class="block text-gray-100 hover:text-gray-300"
          :href="`#${header.id}`"
          :style="`padding-left: ${header.level * 1.5}rem`"
        >
          {{ header.label }}
        </a>
      </div>
      <AppProse
        :title="frontmatter.title"
        :subtitle="frontmatter.subtitle"
        :description="frontmatter.description"
        :contents="contents"
      />
    </main>
  </App>
</template>
