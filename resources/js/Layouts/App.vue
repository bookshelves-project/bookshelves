<script lang="ts" setup>
defineProps<{
  title?: string
  description?: string
  image?: string
  color?: string
  back?: string
  icon?: SvgName
}>()
</script>

<template>
  <div>
    <AppMeta
      :title="title"
      :description="description"
      :image="image"
      :color="color"
      app-title="Bookshelves"
      app-description="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
      app-image="/default.jpg"
      app-author="Bookshelves"
      app-color="#8b5cf6"
    />
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <LayoutSidebar />
    <!-- Static sidebar for desktop -->
    <LayoutSidebarStatic />

    <div class="xl:pl-72 body">
      <!-- Sticky search header -->
      <LayoutHeader />

      <LayoutMain
        :title="title"
        :back="back"
        :icon="icon"
      >
        <slot />
      </LayoutMain>
      <LayoutFooter class="footer flex justify-center pt-5 pb-5" />
    </div>
  </div>
</template>

<style lang="css" scoped>
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
