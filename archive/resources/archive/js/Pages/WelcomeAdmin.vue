<template>
  <app-guest title="Home">
    <p>Welcome on Bookshelves' features.</p>
  </app-guest>
</template>

<script>
import AppGuest from "@/Layouts/AppGuest.vue";
export default {
  components: { AppGuest },
  name: "WelcomeAdmin",
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },
};
</script>
