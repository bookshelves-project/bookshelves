<script lang="ts" setup>
const props = defineProps<{
  tag: App.Models.Tag
  current: number
}>()

const colors = [
  ['bg-slate-600', 'bg-zinc-600', 'bg-neutral-600', 'bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-lime-600', 'bg-green-600', 'bg-emerald-600', 'bg-teal-600', 'bg-cyan-600', 'bg-sky-600', 'bg-blue-600', 'bg-indigo-600', 'bg-violet-600', 'bg-purple-600', 'bg-fuchsia-600', 'bg-pink-600', 'bg-rose-600'],
]
const color = computed(() => colors[0][props.current % colors[0].length])

const count = computed(() => (props.tag.books_count ?? 0) + (props.tag.series_count ?? 0))
</script>

<template>
  <ILink
    :class="color"
    class="h-28 rounded-md bg-opacity-40 px-3 py-2 hover-zoom"
    :href="$route('tags.show', { tag: tag.slug })"
  >
    <h2 class="text-lg lowercase text-gray-300">
      #{{ tag.name }}
    </h2>
    <div class="mt-1 text-gray-300">
      {{ count }}
    </div>
  </ILink>
</template>
