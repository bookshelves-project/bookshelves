<template>
  <span v-if="!link && value">
    <span
      v-for="(item, index) in value"
      :key="index"
      class="inline-block px-2 py-1 text-white text-sm rounded bg-gray-600 mr-1"
    >
      <span>
        {{ item instanceof Object && text ? item[text] : '' }}
      </span>
    </span>
  </span>
  <inertia-link
    v-else-if="value"
    class="inline-block px-2 py-1 text-white text-sm rounded bg-gray-600"
    :href="route(`admin.${resource}.${link}`, value['id'])"
    @click.stop
  >
    {{ text ? value[text] : value }}
  </inertia-link>
</template>

<script lang="ts" setup>
  defineProps({
    value: {
      type: Array,
      required: true,
    },
    text: String,
    resource: String,
    link: String,
  })
</script>
