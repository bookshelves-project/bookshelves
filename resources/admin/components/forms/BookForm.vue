<template>
  <base-form ref="form" v-slot="{ processing }" :method="method" :url="url">
    <!-- <div class="flex flex-col xl:flex-row gap-6">
      <div class="xl:w-3/4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
        <div>
          <text-input source="title" type="text" />
        </div>
      </div>

      <div class="xl:flex-1">
        <div
          class="flex flex-col gap-4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md"
        >
          <base-button
            type="button"
            variant="success"
            :loading="processing"
            @click="submit()"
          >
            {{ $t('Save') }}
          </base-button>
        </div>
      </div>
    </div> -->
    <div class="form-grid">
      <card-content>
        <div class="form-split">
          <text-input source="title" type="text" />
        </div>
        <div class="form-split">
          <text-input source="slug_sort" type="text" />
        </div>
        <!-- <div class="form-split">
          <text-input source="meta_title" type="text" />
          <div class="mt-5">
            <text-input source="meta_description" multiline />
          </div>
        </div>
        <div class="form-full">
          <editor-input source="body" :height="800" />
        </div> -->
      </card-content>
      <card-side>
        <div class="flex form-full">
          <base-button
            class="ml-auto"
            type="button"
            variant="success"
            :loading="processing"
            @click="submit()"
          >
            {{ $t('Save') }}
          </base-button>
        </div>
      </card-side>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
  import { Ref, ref } from 'vue'

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

  const form: Ref<HTMLElement | null | any> = ref(null)

  const submit = () => {
    if (form.value) {
      form.value.submit()
    }
  }
</script>
