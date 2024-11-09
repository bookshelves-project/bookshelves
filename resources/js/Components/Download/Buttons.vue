<script lang="ts" setup>
import { useDownload } from '@/Composables/useDownload'
import { useUtils } from '@/Composables/useUtils'
import { useNotification } from '@kiwilan/typescriptable-laravel'

const props = defineProps<{
  title?: string
  model: App.Models.Book | App.Models.Serie
  type: 'book' | 'serie'
  size?: string
  url?: string
}>()

const { useNitro } = useUtils()
const { save } = useDownload()

function notification() {
  const { push } = useNotification()
  push({
    title: `Download ${props.title}`,
    description: 'Your download will start shortly...',
  })
}
</script>

<template>
  <div class="flex items-center space-x-3">
    <template v-if="useNitro">
      <AppButton
        v-if="useNitro"
        icon="download"
        @click="[save(model, type), notification()]"
      >
        <span>Download</span>
        <span class="ml-1">({{ size }})</span>
      </AppButton>
      <AppButton
        :href="url"
        icon="download"
        color="secondary"
        download
        @click="notification()"
      >
        <span>Download (legacy)</span>
      </AppButton>
    </template>
    <template v-else>
      <AppButton
        :href="url"
        icon="download"
        color="secondary"
        download
        @click="notification()"
      >
        <span>Download</span>
        <span class="ml-1">({{ size }})</span>
      </AppButton>
    </template>
  </div>
</template>
