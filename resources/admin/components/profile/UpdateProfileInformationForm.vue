<template>
  <form-section
    method="put"
    :url="route('user-profile-information.update')"
    :options="{
      errorBag: 'updateProfileInformation',
      preserveScroll: true,
    }"
    :item="user"
  >
    <template #title> {{ $t('Profile Information') }} </template>

    <template #description>
      {{ $t("Update your account's profile information and email address.") }}
    </template>

    <template #form>
      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <text-input source="name" type="text" required autocomplete="name" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <text-input source="email" type="text" required />
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

<script lang="ts" setup>
  import { PropType } from 'vue'
  import { Profile } from '@admin/types'

  defineProps({
    user: {
      type: Object as PropType<Profile>,
      required: true,
    },
  })
</script>
