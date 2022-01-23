<template>
  <span
    v-if="!link && value"
    class="inline-block px-2 py-1 text-white text-sm rounded bg-gray-400"
    >{{ text ? value[text] : value }}
  </span>
  <inertia-link
    v-else-if="value"
    class="inline-block px-2 py-1 text-white text-sm rounded bg-gray-400"
    :href="route(`admin.${resource}.${link}`, value['id'])"
    @click.stop
    >{{ text ? value[text] : value }}
  </inertia-link>
</template>

<script lang="ts" setup>
  defineProps({
    value: {
      type: Object,
      required: true,
    },
    text: String,
    resource: String,
    link: String,
  })
</script>
