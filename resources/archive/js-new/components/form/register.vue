<template>
  <form @submit.prevent="submit">
    <label for="first_name">First name:</label>
    <input id="first_name" v-model="form.first_name" />
    <label for="last_name">Last name:</label>
    <input id="last_name" v-model="form.last_name" />
    <label for="email">Email:</label>
    <input id="email" v-model="form.email" />
    <button type="submit">Submit</button>
  </form>
</template>

<script>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
  setup() {
    const form = reactive({
      first_name: null,
      last_name: null,
      email: null,
    })

    function submit() {
      Inertia.post('/users', form)
    }

    return { form, submit }
  },
}
</script>
