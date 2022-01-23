<template>
  <auth-layout>
    <validation-errors class="mb-4" />

    <base-form v-slot="{ processing }" method="post" :url="route('register')">
      <div>
        <text-input
          source="name"
          type="text"
          required
          autofocus
          autocomplete="name"
        />
      </div>

      <div class="mt-4">
        <text-input source="email" type="email" required />
      </div>

      <div class="mt-4">
        <text-input
          source="password"
          type="password"
          required
          autocomplete="new-password"
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

      <div class="flex items-center justify-end mt-4">
        <inertia-link
          :href="route('admin.login')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          {{ $t('Already registered?') }}
        </inertia-link>

        <base-button type="submit" class="ml-4" :loading="processing">
          {{ $t('Register') }}
        </base-button>
      </div>
    </base-form>
  </auth-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  useTitle('Register')
</script>
