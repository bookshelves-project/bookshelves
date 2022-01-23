<template>
  <div v-if="pages > 1">
    <div class="flex flex-wrap justify-center -mb-1">
      <button
        type="button"
        class="link"
        :disabled="currentPage === 1"
        @click="changePage(1)"
      >
        <chevron-double-left-icon />
      </button>
      <button
        type="button"
        class="link"
        :disabled="currentPage === 1"
        @click="changePage(currentPage - 1)"
      >
        <chevron-left-icon />
      </button>
      <button v-if="showFirstDots" type="button" class="link" disabled>
        ...
      </button>
      <button
        v-for="(page, i) in links"
        :key="i"
        type="button"
        class="link"
        :disabled="page === currentPage"
        :class="{ active: page === currentPage }"
        @click="changePage(page)"
      >
        {{ page }}
      </button>
      <button v-if="showLastDots" type="button" class="link" disabled>
        ...
      </button>
      <button
        type="button"
        class="link"
        :disabled="currentPage === pages"
        @click="changePage(currentPage + 1)"
      >
        <chevron-right-icon />
      </button>
      <button
        type="button"
        class="link"
        :disabled="currentPage === pages"
        @click="changePage(pages)"
      >
        <chevron-double-right-icon />
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
  import { computed } from 'vue'

  const props = defineProps({
    currentPage: {
      type: Number,
      required: true,
    },
    perPage: {
      type: [Number, String],
      required: true,
    },
    total: {
      type: Number,
      required: true,
    },
    limit: {
      type: Number,
      default: 6,
    },
    ellipsesThreshold: {
      type: Number,
      default: 3,
    },
  })

  const emit = defineEmits(['page-change'])

  const pages = computed(() => {
    let page = props.perPage
    if (typeof page === 'string') {
      page = parseInt(page, 10)
    }
    return Math.ceil(props.total / page)
  })

  const showAllPages = computed(() => {
    return pages.value <= props.limit
  })
  const nearFromBeginning = computed(() => {
    return (
      !showAllPages.value &&
      props.currentPage < props.limit - 1 &&
      props.limit > props.ellipsesThreshold
    )
  })
  const nearFromEnd = computed(() => {
    return (
      !showAllPages.value &&
      !nearFromBeginning.value &&
      pages.value - props.currentPage + 2 < props.limit &&
      props.limit > props.ellipsesThreshold
    )
  })
  const isOnTheMiddle = computed(() => {
    return (
      !showAllPages.value &&
      !nearFromBeginning.value &&
      !nearFromEnd.value &&
      props.limit > props.ellipsesThreshold
    )
  })
  const showFirstDots = computed(() => {
    return nearFromEnd.value || isOnTheMiddle.value
  })
  const showLastDots = computed(() => {
    return nearFromBeginning.value || isOnTheMiddle.value
  })
  const numberOfLinks = computed(() => {
    if (showAllPages.value) {
      return pages.value
    }
    if (nearFromBeginning.value || nearFromEnd.value) {
      return props.limit - 1
    }
    if (isOnTheMiddle.value) {
      return props.limit - 2
    }
    return props.limit
  })
  const startNumber = computed(() => {
    let startNumber = 1
    if (nearFromEnd.value) {
      startNumber = pages.value - numberOfLinks.value + 1
    } else if (isOnTheMiddle.value) {
      startNumber = props.currentPage - Math.floor(numberOfLinks.value / 2)
    }
    if (startNumber < 1) {
      return 1
    }
    if (startNumber > pages.value - numberOfLinks.value) {
      return pages.value - numberOfLinks.value + 1
    }
    return startNumber
  })

  const links = computed(() =>
    [...Array(numberOfLinks.value).keys()].map((x) => startNumber.value + x)
  )

  const changePage = (page: number) => {
    emit('page-change', page)
  }
</script>

<style lang="postcss" scoped>
  .link {
    @apply mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-primary-300 rounded;

    svg {
      @apply h-4 w-4;
    }

    &[disabled] {
      @apply cursor-not-allowed;

      &:not(.active) {
        @apply opacity-25;
      }
    }

    &:not([disabled]) {
      @apply hover:bg-white focus:border-primary-500 focus:text-primary-500;
    }

    &.active {
      @apply bg-primary text-white;
    }
  }
</style>
