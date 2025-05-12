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
  <div>
    <div class="block md:flex items-center space-y-3 md:space-y-0 md:space-x-3">
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
          <span>Download (slow)</span>
        </AppButton>
      </template>
      <template v-else>
        <AppButton
          :href="url"
          icon="download"
          download
          @click="notification()"
        >
          <span>Download</span>
          <span class="ml-1">({{ size }})</span>
        </AppButton>
      </template>
    </div>
    <p
      v-if="useNitro"
      class="mt-3 italic text-xs text-gray-300 prose"
    >
      First button with file size uses Nitro, a side service that allows you to download files faster. The second button is a direct link to the file, but it may be slower.
    </p>
  </div>
</template>
