<template>
  <base-form
    ref="form"
    v-slot="{ processing }"
    method="stub"
    :url="url"
    :transform="
      (data) => ({
        ...data,
        _method: method,
      })
    "
    disable-submit
  >
    <div class="flex flex-col xl:flex-row gap-6">
      <div class="xl:w-3/4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
        <div>
          <text-input source="stubAttr" type="text" />
        </div>
      </div>

      <div class="xl:flex-1">
        <div
          class="flex flex-col gap-4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md"
        >
          <!-- option 1  -->
          <base-button type="submit" :loading="processing">
            {{ $t('Save') }}
          </base-button>
        </div>
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md mt-6">
          <!-- option 2  -->
        </div>
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md mt-6">
          <!-- option 3  -->
        </div>
      </div>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
  defineProps({
    method: {
      type: String,
      required: true,
    },
    url: {
      type: String,
      required: true,
    },
  })
</script>
