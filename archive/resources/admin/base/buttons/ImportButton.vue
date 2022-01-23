<template>
  <base-button
    variant="info"
    type="button"
    icon="upload"
    :hide-label="hideLabel"
    @click="onClick"
  >
    {{ title }}
  </base-button>

  <modal
    :show="showModal"
    :max-width="maxWidthModal"
    closeable
    @close="onClose"
  >
    <form @submit.prevent="onSubmit">
      <div class="px-6 py-4">
        <div v-if="errors" class="bg-red-500 text-white p-3 rounded mb-6">
          <div v-for="(error, i) in errors" :key="i">
            {{ error }}
          </div>
        </div>

        <div class="text-xl font-bold text-center">
          {{ title }}
        </div>

        <label
          class="w-1/2 mx-auto my-4 flex flex-col items-center px-4 py-6 bg-white rounded-md uppercase border border-black cursor-pointer hover:bg-primary hover:text-white text-primary ease-linear transition-all duration-150"
        >
          <upload-icon class="w-10 h-10" />
          <span class="mt-2 text-base leading-normal">
            {{ $t('Select a file') }}
          </span>
          <input type="file" class="hidden" @change="onFileChange" />
        </label>
        <span v-if="form.file" class="block text-center text-xs">
          Fichier :
          <strong>{{ filename }}</strong>
        </span>

        <div v-if="templateUrl" class="flex mt-6">
          <base-button
            tag="a"
            variant="primary"
            icon="download"
            :href="templateUrl"
            class="mx-auto"
          >
            {{ $t('Export template') }}
          </base-button>
        </div>
      </div>

      <div class="px-6 py-4 bg-gray-100 text-right">
        <base-button outlined type="button" @click="onClose">
          {{ $t('Cancel') }}
        </base-button>

        <base-button
          variant="success"
          type="submit"
          class="ml-2"
          :loading="processing"
          :disabled="!form.file"
        >
          {{ $t('Import') }}
        </base-button>
      </div>
    </form>
  </modal>
</template>

<script lang="ts" setup>
import { inject, ref } from 'vue'
import { trans } from 'matice'
import { useForm } from '@inertiajs/inertia-vue3'
import route from 'ziggy-js'

defineProps({
  hideLabel: Boolean,
  fileSource: String,
  title: {
    type: String,
    default: trans('Import'),
  },
  templateUrl: String,
  maxWidthModal: {
    type: String,
    default: '2xl',
  },
})

const resource = inject<string>('resource')
const showModal = ref(false)
const processing = ref(false)
const errors = ref<{ [x: string]: string } | null>(null)
const filename = ref<string>()
const form = useForm<{ file: File | null }>({
  file: null,
})

const onFileChange = (e: Event & { dataTransfer?: DataTransfer }) => {
  const files = (e.target as HTMLInputElement).files || e.dataTransfer?.files
  if (files?.length) {
    form.file = files[0]
    filename.value = form.file?.name
  }
}

const onSubmit = () => {
  if (form.file) {
    form.post(route(`admin.${resource}.import`), {
      onStart: () => (processing.value = true),
      onSuccess: () => onClose(),
      onError: (e) => (errors.value = e),
      onFinish: () => (processing.value = false),
    })
  }
}

const onClick = () => {
  showModal.value = true
}

const onClose = () => {
  showModal.value = false
  form.file = null
  filename.value = undefined
}

defineEmits(['close'])
</script>
