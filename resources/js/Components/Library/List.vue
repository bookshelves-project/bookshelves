<script lang="ts" setup>
defineProps<{
  libraries?: App.Models.Library[]
}>();

</script>
<template>
  <ul role="list"
    class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
    <li v-for="library in libraries"
      :key="library.id"
      class="overflow-hidden rounded-xl outline outline-gray-200 dark:-outline-offset-1 dark:outline-white/10 relative hover-zoom">
      <ILink :href="$route('libraries.show', { library: library.slug })"
        class="absolute inset-0" />
      <div
        class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 dark:border-white/10 dark:bg-gray-800/50">
        <SvgIcon :name="(library.type as SvgName)"
          class="size-8 flex-none rounded-lg object-cover" />
        <div class="text-sm/6 font-medium text-gray-900 dark:text-white">
          {{ library.name }}
        </div>
      </div>
      <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6 dark:divide-white/10">
        <LibraryCardValue name="Type"
          :value="library.type_label" />
        <LibraryCardValue name="Books count"
          :value="library.books_count" />
        <LibraryCardValue name="Series count"
          :value="library.series_count" />
      </dl>
    </li>
  </ul>
</template>
