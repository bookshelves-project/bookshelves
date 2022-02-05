<template>
  <div>
    <div v-if="isArray" class="badge">
      <div v-if="!link && value">
        <span v-for="(item, index) in value" :key="index">
          {{ item instanceof Object && text ? item[text] : '' }}
        </span>
      </div>
      <span v-else-if="value">
        <inertia-link
          v-for="(item, index) in value"
          :key="index"
          class="badge-link"
          :href="route(`admin.${resource}.${link}`, item['id'])"
          @click.stop
        >
          <span>{{ item instanceof Object && text ? item[text] : '' }}</span>
        </inertia-link>
      </span>
    </div>
    <div v-else class="badge">
      <div v-if="!link && value">
        <span>{{ text ? value[text] : value }}</span>
      </div>
      <inertia-link
        v-else-if="value"
        class="badge-link"
        :href="route(`admin.${resource}.${link}`, value['id'])"
        @click.stop
      >
        <span>{{ text ? value[text] : value }}</span>
      </inertia-link>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { computed } from 'vue'

  const props = defineProps({
    value: {
      type: [Object, Array],
      required: true,
    },
    text: String,
    resource: String,
    link: String,
  })

  const isArray = computed(() => {
    return props.value instanceof Array
  })
</script>

<style lang="css" scoped>
  .badge {
    & a,
    span {
      @apply max-w-48 whitespace-pre-wrap rounded-md;
      word-wrap: break-word;
      width: max-content;
    }
  }
  .badge-link {
    @apply block hover:bg-gray-200 p-2 transition-all duration-75 underline underline-offset-2 underline-gray-500;
    & span {
      @apply;
    }
  }
</style>
