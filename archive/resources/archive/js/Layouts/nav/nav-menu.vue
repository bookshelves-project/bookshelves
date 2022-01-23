<template>
  <a
    :href="item.href ? route(item.href) : item.link"
    :target="item.external ? '_blank' : ''"
    :rel="item.external ? 'noopener noreferrer' : ''"
    :class="[
      item.current
        ? 'bg-gray-900 text-white'
        : 'text-gray-300 hover:bg-gray-700 hover:text-white',
      'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
    ]"
  >
    <component
      :is="item.icon"
      :class="[
        item.current
          ? 'text-gray-300'
          : 'text-gray-400 group-hover:text-gray-300',
        'mr-3 flex-shrink-0 h-6 w-6',
      ]"
      aria-hidden="true"
    />
    {{ item.name }}
  </a>
</template>

<script setup>
name: "NavMenu";
const props = defineProps({
  item: Object,
});
</script>
