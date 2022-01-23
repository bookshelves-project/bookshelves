<template>
  <form @submit.prevent="submit">
    <input v-model="form.email" type="email" />
    <input v-model="form.password" type="password" />
    <input v-model="form.remember" type="checkbox" />
    <!-- <a
      :href="route('password.request')"
      class="underline text-sm text-gray-600 hover:text-gray-900"
    >
      Forgot your password?
    </a> -->
    <button type="submit">sign in</button>
  </form>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  props: {
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: 'admin@mail.com',
        password: 'a',
        remember: true,
      }),
    }
  },

  methods: {
    submit() {
      this.form
        .transform((data) => ({
          ...data,
          remember: this.form.remember ? 'on' : '',
        }))
        .post(this.route('login'), {
          onFinish: () => this.form.reset('password'),
        })
    },
  },
})
</script>
