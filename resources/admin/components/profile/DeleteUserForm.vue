<template>
  <action-section>
    <template #title> {{ $t('Delete Account') }} </template>

    <template #description>
      {{ $t('Permanently delete your account.') }}
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        {{
          $t(
            'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'
          )
        }}
      </div>

      <div class="mt-5">
        <base-button
          variant="danger"
          icon="trash"
          type="button"
          @click="confirmUserDeletion"
        >
          {{ $t('Delete Account') }}
        </base-button>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <dialog-modal
        method="delete"
        :url="route('current-user.destroy')"
        :options="{
          errorBag: 'updatePassword',
          preserveScroll: true,
          onSuccess: () => closeModal(),
        }"
        :show="confirmingUserDeletion"
        @close="closeModal"
      >
        <template #title> {{ $t('Delete Account') }} </template>

        <template #content>
          {{
            $t(
              'Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'
            )
          }}

          <div class="mt-4 w-3/4">
            <text-input
              source="password"
              type="password"
              :placeholder="$t('Password')"
            />
          </div>
        </template>

        <template #footer="{ processing }">
          <base-button outlined type="button" @click="closeModal">
            {{ $t('Cancel') }}
          </base-button>

          <base-button
            variant="danger"
            type="submit"
            class="ml-2"
            :loading="processing"
          >
            {{ $t('Delete Account') }}
          </base-button>
        </template>
      </dialog-modal>
    </template>
  </action-section>
</template>

<script lang="ts" setup>
  import { Ref, ref } from 'vue'

  const password: Ref<HTMLInputElement | null> = ref(null)
  const confirmingUserDeletion = ref(false)

  const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true

    setTimeout(() => password.value?.focus(), 250)
  }

  const closeModal = () => {
    confirmingUserDeletion.value = false
  }
</script>
