<template>
  <base-form
    v-slot="{ processing }"
    class="flex flex-col gap-4"
    :method="method"
    :url="url"
  >
    <div>
      <rich-select-input
        source="id_mdm"
        resource="residences"
        searchable
        option-text="name"
        option-value="id_mdm"
        :min-chars="3"
      />
    </div>
    <div>
      <text-input source="title" type="text" />
    </div>
    <div>
      <text-input source="text" multiline />
    </div>
    <div>
      <rich-select-input
        source="icon"
        type="choices"
        choices="icons"
        :multiple="false"
        :taggable="false"
        option-value="value"
        allow-empty
      >
        <template #singlelabel="{ value }">
          <div
            class="flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5"
          >
            <component
              :is="`icon-${value.value.replaceAll('_', '-')}`"
              class="w-6 h-6 mr-2"
            />
            {{ value.text }}
          </div>
        </template>
        <template #option="{ option }">
          <div class="flex items-center">
            <component
              :is="`icon-${option.value.replaceAll('_', '-')}`"
              class="w-6 h-6 mr-3"
            />
            {{ option.text }}
          </div>
        </template>
      </rich-select-input>
    </div>
    <div>
      <date-input source="start_date" />
    </div>
    <div class="flex mt-4">
      <base-button type="submit" :loading="processing">
        {{ $t('Save') }}
      </base-button>
      <div class="flex gap-2 ml-auto">
        <slot name="actions" />
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
