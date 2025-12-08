<script lang="ts" setup>
// import { Notifications } from '@kiwilan/typescriptable-laravel/vue'

defineProps<{
  title?: string
  description?: string
  image?: string
  color?: string
  back?: string
  icon?: SvgName
  maintenance?: boolean
}>()
</script>

<template>
  <div class="h-full">
    <AppMeta :title="title"
      :description="description"
      :image="image"
      :color="color"
      app-title="Bookshelves"
      app-description="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
      app-image="/default.jpg"
      app-author="Bookshelves"
      app-color="#8b5cf6" />
    <template v-if="maintenance">
      <Maintenance />
    </template>
    <template v-else>
      <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
      <LayoutSidebar />
      <!-- Static sidebar for desktop -->
      <LayoutSidebarStatic />

      <div class="xl:pl-72 body">
        <!-- Sticky search header -->
        <LayoutHeader />

        <LayoutMain :title="title"
          :back="back"
          :icon="icon">
          <slot />
        </LayoutMain>
        <LayoutFooter class="footer flex justify-center pt-5 pb-5" />
      </div>
    </template>
  </div>
  <Notifications />
</template>

<style lang="css">
html {
  @apply h-full;
}

body {
  @apply h-full;
}

#app {
  @apply h-full;
}

.body {
  min-height: 98vh;
  margin: 0;
  display: flex;
  flex-direction: column;
}

.footer {
  margin-top: auto;
  height: 4rem;
}
</style>
