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
            { key: 'tab_gallery', text: $ta('tab_gallery') },
            { key: 'tab_assets', text: $ta('tab_assets') },
            { key: 'tab_city', text: $ta('tab_city') },
            { key: 'tab_service', text: $ta('tab_service') },
            { key: 'tab_team', text: $ta('tab_team') },
            { key: 'tab_menu', text: $ta('tab_menu') },
            { key: 'tab_apartment', text: $ta('tab_apartment') },
            { key: 'tab_opinion', text: $ta('tab_opinion') },
          ]"
          item-text="text"
          tab-key="key"
        >
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
          <template #panel-tab_assets>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <collection-input
                source="assets"
                :label="$ta('assets_list')"
                item-text="title"
                :new-item="asset"
              >
                <template #default="{ index }">
                  <div class="flex flex-col gap-4">
                    <div>
                      <text-input
                        :source="`assets.${index}.title`"
                        type="text"
                      />
                    </div>
                    <div>
                      <rich-select-input
                        :source="`assets.${index}.icon`"
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
          <template #panel-tab_city>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <h3 class="font-bold text-2xl mb-3">Ville</h3>
              <div>
                <text-input
                  source="city_title"
                  :label="$ta('title')"
                  type="text"
                />
              </div>
              <div class="mt-4">
                <editor-input
                  source="city_text"
                  :label="$ta('description')"
                  :height="400"
                />
              </div>
              <div class="mt-4">
                <media-collection-input
                  source="city_image"
                  name="city_image"
                  :accept="['image/png', 'image/jpeg']"
                  :custom-properties="['description']"
                  @uploading="onUpload"
                />
              </div>
              <div class="mt-8">
                <h3 class="font-bold text-2xl mb-3">Carte</h3>
                <div>
                  <editor-input
                    label="Votre quartier"
                    source="map_near"
                    :height="400"
                  />
                </div>
              </div>
            </div>
          </template>
          <template #panel-tab_service>
            <div class="px-4 py-5">
              <div>
                <text-input
                  source="services_text"
                  :label="$ta('description')"
                  multiline
                />
              </div>
              <div class="mt-4">
                <rich-select-input
                  source="services"
                  resource="services"
                  multiple
                  searchable
                  :min-chars="3"
                  option-value="id"
                  option-text="title"
                  :getter="
                    (pageResidence) => pageResidence.services.map((t) => t.id)
                  "
                />
              </div>
            </div>
          </template>
          <template #panel-tab_team>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <div class="flex gap-6">
                <div class="w-1/2">
                  <div>
                    <text-input source="leadership_identity" type="text" />
                  </div>
                  <div class="mt-4">
                    <text-input source="leadership_role" type="text" />
                  </div>
                  <div class="mt-4">
                    <text-input source="leadership_text" multiline />
                  </div>
                  <div class="mt-4">
                    <media-collection-input
                      source="director_image"
                      name="director_image"
                      :accept="['image/png', 'image/jpeg']"
                      :custom-properties="['description']"
                      @uploading="onUpload"
                    />
                  </div>
                </div>
                <div class="w-1/2">
                  <div>
                    <text-input source="team_text" multiline />
                  </div>
                  <div class="mt-4">
                    <media-collection-input
                      source="team_image"
                      name="team_image"
                      :accept="['image/png', 'image/jpeg']"
                      :custom-properties="['description']"
                      @uploading="onUpload"
                    />
                  </div>
                </div>
              </div>
            </div>
          </template>
          <template #panel-tab_menu>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <div>
                <text-input
                  source="menu_title"
                  :label="$ta('title')"
                  type="text"
                />
              </div>
              <div class="mt-4">
                <text-input
                  source="menu_text"
                  :label="$ta('description')"
                  multiline
                />
              </div>
              <div class="mt-4">
                <media-collection-input
                  source="menu_image"
                  name="menu_image"
                  :accept="['image/png', 'image/jpeg']"
                  :custom-properties="['description']"
                  @uploading="onUpload"
                />
              </div>
              <div class="flex gap-6 mt-4">
                <div class="xl:w-1/2">
                  <collection-input
                    :label="$ta('lunch')"
                    source="menus.lunch"
                    item-text="title"
                    :new-item="menuItem"
                  >
                    <template #default="{ index }">
                      <div class="flex flex-col gap-4">
                        <div>
                          <text-input
                            :source="`menus.lunch.${index}.title`"
                            type="text"
                          />
                        </div>
                        <div>
                          <text-input
                            :source="`menus.lunch.${index}.content`"
                            type="text"
                            multiline
                          />
                        </div>
                      </div>
                    </template>
                  </collection-input>
                </div>
                <div class="xl:w-1/2">
                  <collection-input
                    :label="$ta('diner')"
                    source="menus.diner"
                    item-text="title"
                    :new-item="menuItem"
                  >
                    <template #default="{ index }">
                      <div class="flex flex-col gap-4">
                        <div>
                          <text-input
                            :source="`menus.diner.${index}.title`"
                            type="text"
                          />
                        </div>
                        <div>
                          <text-input
                            :source="`menus.diner.${index}.content`"
                            type="text"
                            multiline
                          />
                        </div>
                      </div>
                    </template>
                  </collection-input>
                </div>
              </div>
            </div>
          </template>
          <template #panel-tab_apartment>
            <div class="px-4 py-5">
              <input-hint :message="$ta('empty')" class="mb-4" />
              <div class="mb-4">
                <text-input
                  source="apartment_text"
                  :label="$ta('description')"
                  multiline
                />
              </div>
              <div
                v-for="(type, key) in ['t1', 't2', 't3']"
                :key="key"
                class="mb-6"
              >
                <h3 class="font-bold text-2xl mb-3">
                  {{ $ta('apartment_' + type) }}
                </h3>
                <collection-input
                  :source="`apartments.${type}`"
                  item-text="title"
                  :new-item="apartmentSlide"
                >
                  <template #default="{ index }">
                    <div class="mt-4">
                      <text-input
                        :source="`apartments.${type}.${index}.title`"
                        type="text"
                        :label="$ta('title')"
                      />
                    </div>
                    <div class="mt-4">
                      <text-input
                        :source="`apartments.${type}.${index}.text`"
                        :label="$ta('description')"
                        multiline
                      />
                    </div>
                    <div class="mt-4">
                      <media-collection-input
                        :source="`apartments.${type}.${index}.apartment_image`"
                        name="apartment_image"
                        :accept="['image/png', 'image/jpeg']"
                        :custom-properties="['description']"
                        @uploading="onUpload"
                      />
                    </div>
                  </template>
                </collection-input>
              </div>
            </div>
          </template>
          <template #panel-tab_opinion>
            <div class="px-4 py-5">
              <div class="flex gap-2 mb-2">
                <div class="flex-1">
                  <text-input source="civiliz_id" type="text" />
                </div>
                <div class="flex-1">
                  <text-input source="partoo_id" type="text" />
                </div>
              </div>
              <div>
                <text-input source="opinions_legal_text" multiline />
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
              resource="residences"
              searchable
              option-text="name"
              option-value="id_mdm"
              :min-chars="3"
            />
          </div>
          <div>
            <switch-input source="active" />
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
            <text-input source="email" type="email" />
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
import { PageResidence } from '@admin/types'
import { Asset, MenuItem, ApartmentSlide } from '@admin/types/page-residence'

defineProps({
  pageResidence: Object as PropType<PageResidence>,
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

const asset = new Asset()
const menuItem = new MenuItem()
const apartmentSlide = new ApartmentSlide()

const submit = () => {
  if (form.value) {
    form.value.submit()
  }
}
</script>
