<template>
  <input
    id="remember-me"
    v-model="proxyChecked"
    name="remember-me"
    type="checkbox"
    :value="value"
  />
  <label for="remember-me" class="ml-2 block text-sm text-gray-900">
    Remember me
  </label>
</template>

<script>
export default {
  props: {
    checked: {
      type: [Array, Boolean],
      default: false,
    },
    value: {
      default: null,
    },
  },
  emits: ['update:checked'],

  computed: {
    proxyChecked: {
      get() {
        return this.checked
      },

      set(val) {
        this.$emit('update:checked', val)
      },
    },
  },
}
</script>
