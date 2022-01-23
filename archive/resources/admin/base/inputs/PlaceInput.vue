<template>
  <input-label class="mb-1">{{ getLabel }}</input-label>

  <Multiselect
    v-model="placeValue"
    v-bind="{ ...translations }"
    :options="asyncSearch"
    :min-chars="minChars"
    :placeholder="placeholder"
    :filter-results="false"
    :delay="500"
    searchable
    :object="true"
    :caret="false"
    @select="onSelect"
  >
  </Multiselect>

  <input-error :message="getError" class="mt-2" />
  <input-hint :message="hint" class="mt-2" />
</template>

<script lang="ts" setup>
import { inputProps, inputSetup } from '@admin/mixins/input'
import Multiselect from '@vueform/multiselect'
import { computed, ref } from 'vue'
import axios from 'axios'
import French from '@admin/lang/multiselect.fr'
import { getLocale } from 'matice'

const placeValue = ref<any>(null)

const props = defineProps({
  ...inputProps,
  modelValue: [String, Number, Array],
  minChars: Number,
  placeholder: String,
})

const emit = defineEmits(['update:modelValue'])
let { getLabel, formValue, getError } = inputSetup(props, emit)

const translations = computed(() => {
  return getLocale() === 'fr' ? French : {}
})

const onSelect = async ({ value }) => {
  /**
   * 2eme appel nécessaire pour le code région
   */
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const [departmentCode, departmentName, regionName] =
    value.properties.context.split(', ')

  const { data } = await axios.get<{ nom: string; code: string }[]>(
    `https://geo.api.gouv.fr/regions?nom=${regionName}`
  )

  if (data.length === 0) {
    // TODO Gestion de l'erreur si aucune région ?
    return
  }

  formValue.value = {
    street: value.properties.name,
    city: value.properties.city,
    postcode: value.properties.postcode,
    city_code: value.properties.citycode,
    department_code: departmentCode,
    region_code: data[0].code,
    location: value.geometry.coordinates,
  }
}

const asyncSearch = computed(() => {
  return async (query: string) => {
    if (query) {
      const { data } = await axios.get<{ features: any[] }>(
        `https://api-adresse.data.gouv.fr/search/?q=${query}&type=housenumber`
      )

      return data.features.map((feature) => ({
        value: feature,
        label: feature.properties.label,
      }))
    }

    if (!query && formValue.value) {
      formValue.value = {
        street: formValue.value.street,
        city: formValue.value.city,
        postcode: formValue.value.postcode,
        city_code: formValue.value.city_code,
        department_code: formValue.value.department_code,
        region_code: formValue.value.region_code,
        location: formValue.value.location,
      }

      placeValue.value = {
        value: formValue.value,
        label: [
          formValue.value.street,
          formValue.value.postcode,
          formValue.value.city,
        ].join(' '),
      }
    }

    return []
  }
})
</script>
