<template>
  <div
    class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      bg-gray-100
      dark:bg-gray-900
      sm:items-center sm:pt-0
    "
  >
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="block max-w-6xl p-5 mx-auto sm:px-6 lg:px-8">
        <div
          class="
            flex
            justify-center
            mt-4
            font-handlee
            sm:items-center sm:justify-between
          "
        >
          <div class="mx-auto">
            <div class="lg:text-6xl text-xl">
              {{ $inertia.page.props.app.name }}
            </div>
            <div
              class="
                mt-1
                ml-4
                text-sm text-center text-gray-500
                sm:text-right sm:ml-0
              "
            >
              Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </div>
          </div>
        </div>
      </div>
      <div class="flex">
        <Link
          :href="route('admin')"
          class="
            text-sm text-gray-700
            mx-auto
            border-b border-transparent
            transition-colors
            duration-100
            hover:border-gray-700
          "
        >
          Access to admin
        </Link>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
  components: {
    Link,
  },

  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },
}
</script>
