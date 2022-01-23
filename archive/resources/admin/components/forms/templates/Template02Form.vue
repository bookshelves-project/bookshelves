<template>
  <div
    class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md flex flex-col lg:flex-row gap-8"
  >
    <div class="flex flex-col gap-4 lg:w-1/3">
      <div>
        <text-input source="template.title" type="text" />
      </div>
      <div>
        <switch-input source="template.residence_projects_block" />
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
        source="template.assets"
        item-text="text"
        :new-item="asset"
      >
        <template #default="{ index }">
          <div class="flex flex-col gap-4">
            <div>
              <select-input
                :source="`template.assets.${index}.icon`"
                choices="outlined_icons"
              />
            </div>
            <div>
              <text-input
                :source="`template.assets.${index}.text`"
                type="text"
              />
            </div>
          </div>
        </template>
      </collection-input>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { PageTemplate02Asset } from '@admin/types/page'

const asset = new PageTemplate02Asset()
</script>
