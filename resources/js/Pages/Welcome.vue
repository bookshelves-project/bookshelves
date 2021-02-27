<template>
  <div
    class="relative flex justify-center min-h-screen bg-gray-100 items-top dark:bg-gray-900 sm:items-center sm:pt-0"
  >
    <div v-if="canLogin" class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
      <inertia-link
        v-if="$page.props.user"
        href="/dashboard"
        class="text-sm text-gray-700 underline"
      >
        Dashboard
      </inertia-link>

      <template v-else>
        <inertia-link
          :href="route('login')"
          class="text-sm text-gray-700 underline"
        >
          Log in
        </inertia-link>

        <inertia-link
          v-if="canRegister"
          :href="route('register')"
          class="ml-4 text-sm text-gray-700 underline"
        >
          Register
        </inertia-link>
      </template>
    </div>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div
        class="flex justify-center mt-4 font-handlee sm:items-center sm:justify-between"
      >
        <div>
          <div class="text-6xl">Bookshelves: admin</div>
          <div
            class="mt-1 ml-4 text-sm text-center text-gray-500 sm:text-right sm:ml-0"
          >
            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },
}
</script>
