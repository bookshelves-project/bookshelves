<script lang="ts" setup>
// import { useInertia, useRouter } from '@kiwilan/typescriptable-laravel'

// const files = ref<string[]>([])
// const { isClient } = useInertia()
// const { listFiles } = useRouter()
// console.log(listFiles())
// console.log(await listFiles())

// onMounted(async () => {
//   files.value = await listFiles()
//   console.log(files.value)
//   console.log('mounted')
// })
</script>

<template>
  <App
    title="Welcome on Bookshelves"
    icon="home"
  >
    <div class="pt-10 space-y-6">
      <!-- hello -->
      <!-- {{ isClient ? 'Client' : 'Server' }} -->
      <!-- {{ files }} -->
      <SwiperHome
        endpoint="api.books.latest"
        title="Books recently added"
        type="book"
      />
      <SwiperHome
        endpoint="api.books.released"
        title="Books recently released"
        type="book"
      />
      <SwiperHome
        endpoint="api.series.latest"
        title="Series recently added"
        type="serie"
      />
    </div>
  </App>
</template>
