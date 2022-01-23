<template>
  <form-section
    method="put"
    :url="route('user-password.update')"
    :options="{
      errorBag: 'updatePassword',
      preserveScroll: true,
    }"
  >
    <template #title> {{ $t('Update Password') }} </template>

    <template #description>
      {{
        $t(
          'Ensure your account is using a long, random password to stay secure.'
        )
      }}
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <text-input
          source="current_password"
          type="password"
          required
          autocomplete="current-password"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <text-input
          source="password"
          type="password"
          required
          autocomplete="new-password"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <text-input
          source="password_confirmation"
          type="password"
          required
          autocomplete="new-password"
        />
      </div>
    </template>

    <template #actions="{ processing, recentlySuccessful }">
      <action-message :on="recentlySuccessful" class="mr-3">
        {{ $t('Saved.') }}
      </action-message>

      <base-button type="submit" :loading="processing">
        {{ $t('Save') }}
      </base-button>
    </template>
  </form-section>
</template>

<script lang="ts" setup></script>
