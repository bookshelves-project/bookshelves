<template>
  <auth-layout>
    <validation-errors class="mb-4" />

    <base-form
      v-slot="{ processing }"
      method="post"
      :url="route('password.update')"
    >
      <div>
        <text-input source="email" type="email" required />
      </div>

      <div class="mt-4">
        <text-input
          source="password"
          type="password"
          required
          autocomplete="new-password"
          autofocus
        />
      </div>

      <div class="mt-4">
        <text-input
          source="password_confirmation"
          type="password"
          required
          autocomplete="new-password"
        />
      </div>

      <div class="mt-4">
        <base-button type="submit" class="w-full" :loading="processing">
          {{ $t('Reset Password') }}
        </base-button>
      </div>
    </base-form>
  </auth-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  defineProps({
    token: String,
    email: String,
  })

  useTitle('Reset Password')
</script>
