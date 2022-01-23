<template>
  <div
    class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md flex flex-col lg:flex-row gap-8"
  >
    <div class="flex flex-col gap-4 lg:w-1/3">
      <div>
        <text-input source="template.slides_title" type="text" />
      </div>
      <div>
        <text-input source="template.slides_summary" multiline />
      </div>
      <div>
        <media-collection-input
          source="template.video_image"
          name="video_image"
          :accept="['image/png', 'image/jpeg']"
          :custom-properties="['description']"
          @uploading="$emit('uploading', $event)"
        />
      </div>
      <div>
        <text-input source="template.youtube_video_id" type="text" />
      </div>
      <div>
        <switch-input source="template.residences_search_block" />
      </div>
      <div>
        <switch-input source="template.testimonies_block" />
      </div>
      <div>
        <switch-input source="template.posts_block" />
      </div>
    </div>
    <div class="lg:w-2/3">
      <collection-input
        source="template.slides"
        item-text="title"
        :new-item="slide"
      >
        <template #default="{ index }">
          <div class="flex flex-col gap-4">
            <div>
              <text-input
                :source="`template.slides.${index}.title`"
                type="text"
              />
            </div>
            <div>
              <rich-select-input
                :source="`template.slides.${index}.icon`"
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
                      class="w-4 h-4 mr-2"
                    />
                    {{ value.text }}
                  </div>
                </template>
                <template #option="{ option }">
                  <div class="flex items-center">
                    <component
                      :is="`icon-${option.value.replaceAll('_', '-')}`"
                      class="w-4 h-4 mr-3"
                    />
                    {{ option.text }}
                  </div>
                </template>
              </rich-select-input>
            </div>
            <div>
              <text-input
                :source="`template.slides.${index}.content`"
                multiline
              />
            </div>
          </div>
        </template>
      </collection-input>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { PageTemplate01Slide } from '@admin/types/page'

defineEmits(['uploading'])

const slide = new PageTemplate01Slide()
</script>
