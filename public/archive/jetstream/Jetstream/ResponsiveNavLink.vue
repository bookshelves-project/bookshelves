<template>
  <div>
    <button v-if="as == 'button'" :class="classes" class="w-full text-left">
      <slot></slot>
    </button>

    <Link v-else :href="href" :class="classes">
      <slot />
    </Link>
  </div>
</template>

<script>
  import { defineComponent } from 'vue'
  import { Link } from '@inertiajs/inertia-vue3'

  export default defineComponent({
    components: {
      Link,
    },
    props: ['active', 'href', 'as'],

    computed: {
      classes() {
        return this.active
          ? 'block pl-3 pr-4 py-2 border-l-4 border-primary-400 text-base font-medium text-primary-700 bg-primary-50 focus:outline-none focus:text-primary-800 focus:bg-primary-100 focus:border-primary-700 transition'
          : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition'
      },
    },
  })
</script>
