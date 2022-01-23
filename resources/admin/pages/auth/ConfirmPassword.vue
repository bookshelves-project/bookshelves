<template>
  <auth-layout>
    <div class="mb-4 text-sm text-gray-600">
      {{
        $t(
          'This is a secure area of the application. Please confirm your password before continuing.'
        )
      }}
    </div>

    <validation-errors class="mb-4" />

    <base-form
      v-slot="{ processing }"
      method="post"
      :url="route('password.confirm')"
    >
      <div>
        <text-input
          source="password"
          type="password"
          required
          autocomplete="current-password"
          autofocus
        />
      </div>

      <div class="mt-4">
        <base-button type="submit" class="w-full" :loading="processing">
          {{ $t('Confirm') }}
        </base-button>
      </div>
    </base-form>
  </auth-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  useTitle('Confirm Password')
</script>
