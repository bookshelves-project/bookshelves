<script setup lang="ts">
// from https://www.smashingmagazine.com/2022/03/drag-drop-file-uploader-vuejs-3/
import { useFileList } from '@admin/composables/file-list'
import { useUploader } from '@admin/composables/uploader'

const { files, addFiles, removeFile } = useFileList()
const { createUploader } = useUploader()
const onInputChange = (e) => {
  addFiles(e.target.files)
  e.target.value = null // reset so that selecting the same file again will still cause it to fire this change
}
const { uploadFiles } = createUploader('/admin/books/upload')
</script>

<template>
  <base-input>
    <drop-zone
      v-slot="{ dropZoneActive }"
      class="drop-area"
      @files-dropped="addFiles"
    >
      <div>
        <label
          for="cover-photo"
          class="block text-sm font-medium text-gray-700"
        >
          Cover photo
        </label>
        <div
          class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
        >
          <div class="space-y-1 text-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="mx-auto h-12 w-12 text-gray-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
              />
            </svg>
            <div class="flex text-sm text-gray-600">
              <label
                for="file-upload"
                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
              >
                <span v-if="dropZoneActive">
                  <span>Drop Them Here</span>
                  <span class="smaller">to add them</span>
                </span>
                <span v-else>
                  <span>Drag Your Files Here</span>
                  <span class="smaller">
                    or <strong><em>click here</em></strong> to select files
                  </span>
                </span>
                <input
                  id="file-upload"
                  name="file-upload"
                  type="file"
                  class="sr-only"
                  multiple
                  @change="onInputChange"
                />
              </label>
              <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
            <ul
              v-show="files.length"
              class="grid grid-cols-4 gap-4">
              <file-preview
                v-for="file of files"
                :key="file.id"
                :file="file"
                tag="li"
                @remove="removeFile"
              />
            </ul>
          </div>
        </div>
      </div>
      <button
        class="upload-button"
        @click.prevent="uploadFiles(files)">
        Upload
      </button>
    </drop-zone>
  </base-input>
</template>
