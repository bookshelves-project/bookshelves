<template>
  <span>
    <span @click="startConfirmingPassword">
      <slot />
    </span>

    <jet-dialog-modal :show="confirmingPassword" @close="closeModal">
      <template #title>
        {{ title }}
      </template>

      <template #content>
        {{ content }}

        <div class="mt-4">
          <jet-input
            ref="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-3/4"
            placeholder="Password"
            @keyup.enter="confirmPassword"
          />

          <jet-input-error :message="form.error" class="mt-2" />
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click="closeModal">
          Cancel
        </jet-secondary-button>

        <jet-button
          class="ml-3"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          @click="confirmPassword"
        >
          {{ button }}
        </jet-button>
      </template>
    </jet-dialog-modal>
  </span>
</template>

<script>
  import { defineComponent } from 'vue'
  import JetButton from './Button.vue'
  import JetDialogModal from './DialogModal.vue'
  import JetInput from './Input.vue'
  import JetInputError from './InputError.vue'
  import JetSecondaryButton from './SecondaryButton.vue'

  export default defineComponent({
    components: {
      JetButton,
      JetDialogModal,
      JetInput,
      JetInputError,
      JetSecondaryButton,
    },

    props: {
      title: {
        default: 'Confirm Password',
      },
      content: {
        default: 'For your security, please confirm your password to continue.',
      },
      button: {
        default: 'Confirm',
      },
    },
    emits: ['confirmed'],

    data() {
      return {
        confirmingPassword: false,
        form: {
          password: '',
          error: '',
        },
      }
    },

    methods: {
      startConfirmingPassword() {
        axios.get(route('password.confirmation')).then((response) => {
          if (response.data.confirmed) {
            this.$emit('confirmed')
          } else {
            this.confirmingPassword = true

            setTimeout(() => this.$refs.password.focus(), 250)
          }
        })
      },

      confirmPassword() {
        this.form.processing = true

        axios
          .post(route('password.confirm'), {
            password: this.form.password,
          })
          .then(() => {
            this.form.processing = false
            this.closeModal()
            this.$nextTick(() => this.$emit('confirmed'))
          })
          .catch((error) => {
            this.form.processing = false
            this.form.error = error.response.data.errors.password[0]
            this.$refs.password.focus()
          })
      },

      closeModal() {
        this.confirmingPassword = false
        this.form.password = ''
        this.form.error = ''
      },
    },
  })
</script>
