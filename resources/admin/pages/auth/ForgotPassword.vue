<template>
  <auth-layout>
    <div class="mb-4 text-sm text-gray-600">
      {{
        $t(
          'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.'
        )
      }}
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <validation-errors class="mb-4" />

    <base-form
      v-slot="{ processing }"
      method="post"
      :url="route('password.email')"
    >
      <div>
        <text-input source="email" type="email" required autofocus />
      </div>

      <div class="mt-4">
        <base-button
          type="submit"
          class="w-full text-center"
          :loading="processing"
        >
          {{ $t('Email Password Reset Link') }}
        </base-button>
      </div>
    </base-form>
  </auth-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  defineProps({
    status: String,
  })

  useTitle('Email Password Reset Link')
</script>
