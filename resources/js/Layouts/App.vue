<script lang="ts" setup>
defineProps<{
  title?: string
  back?: string
  icon?: SvgName
}>()
</script>

<template>
  <div>
    <IHead :title="title" />
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
