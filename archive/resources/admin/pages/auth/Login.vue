<template>
  <auth-layout>
    <div
      class="min-h-full flex items-center justify-center px-4 sm:px-6 lg:px-8"
    >
      <div class="max-w-md w-full space-y-8">
        <div>
          <h2 class="mt-6 text-center text-3xl font-semibold text-gray-900">
            Admin
          </h2>
        </div>
        <base-form
          v-slot="{ processing }"
          method="post"
          class="mt-8 space-y-6"
          :url="route('admin.auth.login')"
          :transform="
            (data) => ({
              ...data,
              remember: data.remember ? 'on' : '',
            })
          "
        >
          <input type="hidden" name="remember" value="true" />
          <div class="rounded-md -space-y-px">
            <div>
              <text-input
                source="email"
                type="email"
                placeholder="Email"
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                required
                autofocus
              />
            </div>
            <div>
              <text-input
                source="password"
                type="password"
                placeholder="Password"
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                required
                autocomplete="current-password"
              />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <checkbox-input
                source="remember"
                name="remember"
                label="Remember me"
              />
            </div>

            <div class="text-sm">
              <a
                href="#"
                class="font-medium text-indigo-600 hover:text-indigo-500"
              >
                Forgot your password?
              </a>
              <!-- <inertia-link
                :href="route('admin.password.request')"
                class="underline text-xs text-gray-600 hover:text-gray-900 ml-auto"
              >
                {{ $t('Forgot your password?') }}
              </inertia-link> -->
            </div>
          </div>

          <div>
            <button
              type="submit"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <LockClosedIcon
                  class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                  aria-hidden="true"
                />
              </span>
              Sign in
            </button>
            <base-button type="submit" class="ml-4" :loading="processing">
              {{ $t('Log in') }}
            </base-button>
          </div>
        </base-form>
      </div>
    </div>
  </auth-layout>
</template>

<script setup lang="ts">
import { LockClosedIcon } from '@heroicons/vue/solid'
import { useTitle } from '@admin/features/helpers'

defineProps({
  canRegister: Boolean,
  status: String,
})

useTitle('Login')
</script>
