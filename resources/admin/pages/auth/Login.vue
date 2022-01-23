<template>
  <auth-layout>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <validation-errors class="mb-4" />

    <base-form
      v-slot="{ processing }"
      method="post"
      :url="route('login')"
      :transform="
        (data) => ({
          ...data,
          remember: data.remember ? 'on' : '',
        })
      "
    >
      <div>
        <text-input
          source="email"
          type="email"
          required
          autofocus
          model-value="admin@example.com"
        />
      </div>

      <div class="mt-4">
        <text-input
          source="password"
          type="password"
          required
          autocomplete="current-password"
          model-value="password"
        />
        <div class="flex mt-2">
          <inertia-link
            :href="route('admin.password.request')"
            class="underline text-xs text-gray-600 hover:text-gray-900 ml-auto"
          >
            {{ $t('Forgot your password?') }}
          </inertia-link>
        </div>
      </div>

      <div class="mt-4">
        <checkbox-input source="remember" name="remember" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <inertia-link
          v-if="canRegister"
          :href="route('admin.register')"
          class="underline text-sm text-gray-600 hover:text-gray-900 ml-auto"
        >
          {{ $t('Not registered yet?') }}
        </inertia-link>

        <base-button type="submit" class="ml-4" :loading="processing">
          {{ $t('Log in') }}
        </base-button>
      </div>
    </base-form>
  </auth-layout>
</template>

<script lang="ts" setup>
  import { useTitle } from '@admin/features/helpers'

  defineProps({
    canRegister: Boolean,
    status: String,
  })

  useTitle('Login')
</script>
