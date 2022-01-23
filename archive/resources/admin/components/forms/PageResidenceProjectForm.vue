<template>
  <base-form
    ref="form"
    v-slot="{ processing }"
    :method="method"
    :url="url"
    disable-submit
  >
    <div class="flex flex-col xl:flex-row gap-6">
      <div class="xl:w-3/4">
        <tabs
          :items="[
            { key: 'tab_marketing', text: $ta('tab_marketing') },
            { key: 'tab_gallery', text: $ta('tab_gallery') },
            { key: 'tab_plan', text: $ta('tab_plan') },
            { key: 'tab_lot', text: $ta('tab_lot') },
            { key: 'tab_contact', text: $ta('tab_contact') },
            { key: 'tab_map', text: $ta('tab_map') },
            { key: 'tab_invest', text: $ta('tab_invest') },
          ]"
          item-text="text"
          tab-key="key"
        >
          <template #panel-tab_marketing>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" />
              <div class="mt-6">
                <text-input
                  source="marketing_list"
                  multiline
                  :hint="$ta('Separate each element by a new line')"
                />
              </div>
            </div>
          </template>
          <template #panel-tab_gallery>
            <div class="px-4 py-5">
              <media-collection-input
                source="gallery"
                name="gallery"
                :accept="['image/png', 'image/jpeg']"
                :custom-properties="['description']"
                :multiple="true"
                @uploading="onUpload"
              />
            </div>
          </template>
          <template #panel-tab_plan>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" />
              <div class="mt-6">
                <text-input
                  source="plan_title"
                  :label="$ta('title')"
                  type="text"
                />
              </div>
              <div class="mt-4">
                <text-input
                  source="plan_list"
                  :label="$ta('list')"
                  multiline
                  :hint="$ta('Separate each element by a new line')"
                />
              </div>
              <div class="mt-4">
                <media-collection-input
                  source="plan_image"
                  name="plan_image"
                  :label="$ta('image')"
                  :accept="['image/png', 'image/jpeg']"
                  :custom-properties="['description']"
                  @uploading="onUpload"
                />
              </div>
            </div>
          </template>
          <template #panel-tab_lot>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" />
              <div class="mt-6">
                <text-input
                  source="lot_title"
                  :label="$ta('title')"
                  type="text"
                />
              </div>
              <div class="mt-4">
                <text-input
                  source="lot_legal"
                  :label="$ta('legal')"
                  type="text"
                />
              </div>
              <div class="mt-4 flex gap-4">
                <div class="flex-1">
                  <text-input
                    source="lot_cta_text"
                    :label="$ta('cta_text')"
                    type="text"
                  />
                </div>
                <div class="flex-1">
                  <text-input
                    source="lot_cta_link"
                    :label="$ta('cta_link')"
                    type="text"
                  />
                </div>
              </div>
              <div v-for="i in 3" :key="i" class="mt-4">
                <h3 class="font-bold text-2xl mb-3">Lot {{ i }}</h3>
                <div class="flex gap-4">
                  <div class="flex-1">
                    <text-input
                      :source="`lot_${i}_call_price`"
                      :label="$ta('call_price')"
                      type="text"
                    />
                  </div>
                  <div class="flex-1">
                    <text-input
                      :source="`lot_${i}_caption`"
                      :label="$ta('caption')"
                      type="text"
                    />
                  </div>
                </div>
              </div>
            </div>
          </template>
          <template #panel-tab_contact>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" />
              <div class="mt-4 flex gap-4">
                <div class="flex-1">
                  <text-input
                    source="contact_text_1"
                    :label="$ta('contact_text_1')"
                    type="text"
                  />
                </div>
                <div class="flex-1">
                  <text-input
                    source="contact_text_2"
                    :label="$ta('contact_text_2')"
                    type="text"
                  />
                </div>
              </div>
              <div class="mt-4 flex gap-4">
                <div class="flex-1">
                  <text-input
                    source="contact_cta_text"
                    :label="$ta('cta_text')"
                    type="text"
                  />
                </div>
                <div class="flex-1">
                  <text-input
                    source="contact_cta_link"
                    :label="$ta('cta_link')"
                    type="text"
                  />
                </div>
              </div>
              <div class="mt-4">
                <media-collection-input
                  source="contact_image"
                  name="contact_image"
                  :label="$ta('image')"
                  :accept="['image/png', 'image/jpeg']"
                  :custom-properties="['description']"
                  @uploading="onUpload"
                />
              </div>
            </div>
          </template>
          <template #panel-tab_map>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <div class="mt-4">
                <text-input
                  source="map_title"
                  :label="$ta('title')"
                  type="text"
                />
              </div>
              <div class="my-4">
                <text-input
                  source="map_text"
                  :label="$ta('description')"
                  multiline
                />
              </div>
              <collection-input
                source="map_list"
                :label="$ta('list')"
                item-text="title"
                :new-item="mapItem"
              >
                <template #default="{ index }">
                  <div class="flex flex-col gap-4">
                    <div>
                      <text-input
                        :source="`map_list.${index}.title`"
                        type="text"
                      />
                    </div>
                    <div>
                      <rich-select-input
                        :source="`map_list.${index}.icon`"
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
                  </div>
                </template>
              </collection-input>
            </div>
          </template>
          <template #panel-tab_invest>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <div class="mt-4">
                <text-input
                  source="invest_title"
                  :label="$ta('title')"
                  type="text"
                />
              </div>
              <div class="mt-4">
                <text-input
                  source="invest_text"
                  :label="$ta('description')"
                  multiline
                />
              </div>
              <div class="mt-4">
                <media-collection-input
                  source="invest_image"
                  name="invest_image"
                  :label="$ta('image')"
                  :accept="['image/png', 'image/jpeg']"
                  :custom-properties="['description']"
                  @uploading="onUpload"
                />
              </div>
            </div>
          </template>
        </tabs>
      </div>
      <div class="xl:flex-1">
        <div
          class="flex flex-col gap-4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md"
        >
          <div>
            <rich-select-input
              source="id_mdm"
              resource="residence-projects"
              searchable
              option-text="name"
              option-value="id_mdm"
              :min-chars="3"
              :hint="$t('Search a project or a city')"
            />
          </div>
          <div>
            <switch-input source="active" />
          </div>
          <div>
            <date-input
              source="delivery_date"
              :options="{
                enableTime: false,
                dateFormat: 'Y-m-d',
              }"
            />
          </div>
          <div class="mt-4">
            <text-input source="call_price" type="text" />
          </div>
          <div>
            <text-input source="law" type="text" />
          </div>
          <div class="mt-4">
            <text-input source="summary" multiline />
          </div>
          <div class="mt-4">
            <media-collection-input
              source="featured_image"
              name="featured_image"
              :accept="['image/png', 'image/jpeg']"
              :custom-properties="['description']"
              @uploading="onUpload"
            />
          </div>

          <div class="flex">
            <base-button
              type="submit"
              variant="success"
              :loading="processing"
              :disabled="uploading"
              class="ml-auto"
              @click="submit()"
            >
              {{ $t('Save') }}
            </base-button>
          </div>
        </div>
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md mt-6">
          <h3 class="mb-4 text-2xl font-medium">{{ $ta('coordinates') }}</h3>
          <div>
            <place-input
              source="address"
              placeholder="Rechercher une adresse"
            ></place-input>
          </div>
          <div class="mt-4">
            <text-input source="phone" type="text" />
          </div>
        </div>
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md mt-6">
          <div>
            <text-input source="meta_title" type="text" />
          </div>
          <div class="mt-4">
            <text-input source="meta_description" multiline />
          </div>
        </div>
      </div>
    </div>
  </base-form>
</template>

<script lang="ts" setup>
import { PropType, Ref, ref } from 'vue'
import { PageResidenceProject } from '@admin/types'
import { MapItem } from '@admin/types/page-residence-project'

defineProps({
  pageResidenceProject: Object as PropType<PageResidenceProject>,
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
const uploading = ref(false)

const onUpload = (value: boolean) => {
  uploading.value = value
}

const mapItem = new MapItem()

const submit = () => {
  if (form.value) {
    form.value.submit()
  }
}
</script>
