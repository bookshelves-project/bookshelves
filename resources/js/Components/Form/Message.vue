<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3'
import { useInertia, useRouter } from '@kiwilan/typescriptable-laravel'
import { toast } from 'vue3-toastify'

const form = useForm({
  type: 'bug',
  description: '',
})

const test = {
  type: 'feedback',
  description: 'Dolore laborum exercitation magna dolore aute aliquip laborum Lorem fugiat incididunt.',
}

const { isDev } = useInertia()
const { route } = useRouter()

function testing() {
  form.type = test.type
  form.description = test.description
}

function submit() {
  const url = route('form.message.post')
  form.clearErrors()
  form.post(url, {
    data: form.data(),
    preserveScroll: true,
    onSuccess: () => {
      toast('Your request has been sent !', {
        autoClose: 2000,
        type: 'success',
      })
      form.reset()
    },
    onError: () => {
      toast('Ups, something went wrong !', {
        autoClose: 2000,
        type: 'error',
      })
    },
  })
}
</script>

<template>
  <form @submit.prevent="submit">
    <div class="mx-auto">
      <div class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-2 lg:grid-cols-1 2xl:grid-cols-2">
        <FieldSelect
          v-model="form.type"
          name="type"
          label="Type"
          :options="[
            { label: 'Bug', value: 'bug' },
            { label: 'Feedback', value: 'feedback' },
            { label: 'Books', value: 'book' },
          ]"
          required
          :error="form.errors.type"
          class="large"
        />
        <FieldInput
          v-model="form.description"
          name="description"
          label="Description"
          placeholder="Describe your bug, feedback, or request"
          autocomplete="description"
          multiline
          class="large"
          required
          :error="form.errors.description"
        />
      </div>
    </div>
    <div class="mt-8 flex items-center justify-end space-x-2">
      <AppButton
        type="submit"
        :disabled="form.processing"
      >
        Send
      </AppButton>
      <AppButton
        v-if="isDev"
        type="button"
        @click="testing"
      >
        Testing
      </AppButton>
    </div>
  </form>
</template>
