<script lang="ts" setup>
import { useUtils } from '@/Composables/useUtils'

defineProps<{
  author: App.Models.Author
  library: {
    name: string
    models: App.Models.Book[] | App.Models.Serie[]
  }[]
  type: 'book' | 'serie'
  title?: string
}>()

const { ucfirst } = useUtils()
</script>

<template>
  <section>
    <h2 class="text-3xl font-semibold">
      <span v-if="title">{{ title }}</span>
      {{ ucfirst(type) }}s of {{ author.name }}
    </h2>
    <div class="mt-6 border-t border-gray-500">
      <dl class="divide-y divide-dashed divide-gray-500">
        <div
          v-for="lib in library"
          :key="lib.name"
          class="px-4 py-6 sm:px-0"
        >
          <dd class="mt-1 text-sm leading-6 sm:mt-0">
            <div class="text-xl font-semibold">
              {{ ucfirst(type) }}s in {{ lib.name }} ({{ lib.models.length }})
            </div>
            <div class="books-grid mt-6">
              <template v-if="type === 'book'">
                <CardBook
                  v-for="book in lib.models"
                  :key="book.id"
                  :book="book"
                  :square="book.library?.type === 'audiobook'"
                />
              </template>
              <template v-else>
                <CardSerie
                  v-for="serie in lib.models"
                  :key="serie.id"
                  :serie="serie"
                  :square="serie.library?.type === 'audiobook'"
                />
              </template>
            </div>
          </dd>
        </div>
      </dl>
    </div>
  </section>
</template>
