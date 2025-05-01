<script lang="ts" setup>
const display = ref(false)

const currentMonth = new Date().getMonth()
const months = [5]
display.value = months.includes(currentMonth)
</script>

<template>
  <img
    v-if="display"
    src="/images/lgbti.svg"
    alt="LGBTI flag"
    class="absolute w-14 rotate-12 top-4 -right-2 rounded-md"
  >
</template>
