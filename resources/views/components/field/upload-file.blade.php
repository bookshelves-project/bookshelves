<div
  id="drop_zone"
  class="py-12"
  ondrop="dropHandler(event);"
  ondragover="dragOverHandler(event);"
>
  <p>Drag one or more files to this <i>drop zone</i>.</p>
</div>

<script>
  function dropHandler(ev) {
    console.log('File(s) dropped');

    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();

    if (ev.dataTransfer.items) {
      // Use DataTransferItemList interface to access the file(s)
      [...ev.dataTransfer.items].forEach((item, i) => {
        // If dropped items aren't files, reject them
        if (item.kind === 'file') {
          const file = item.getAsFile();
          console.log(`… file[${i}].name = ${file.name}`);
        }
      });
    } else {
      // Use DataTransfer interface to access the file(s)
      [...ev.dataTransfer.files].forEach((file, i) => {
        console.log(`… file[${i}].name = ${file.name}`);
      });
    }
  }

  function dragOverHandler(ev) {
    console.log('File(s) in drop zone');

    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();
  }
</script>

<div
  x-data="media"
  x-cloak
>
  <div class="mb-3 flex flex-grow flex-col">
    <div
      x-data="{ files: null }"
      id="FileUpload"
      class="hover:shadow-outline-gray relative block w-full appearance-none rounded-md border-2 border-solid border-gray-300 bg-white py-2 px-3"
    >
      <input
        type="file"
        multiple
        class="absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none"
        x-on:change="files = $event.target.files; console.log($event.target.files);"
        x-on:dragover="$el.classList.add('active')"
        x-on:dragleave="$el.classList.remove('active')"
        x-on:drop="$el.classList.remove('active')"
      >
      <template x-if="files !== null">
        <div class="flex flex-col space-y-1">
          <template x-for="(_,index) in Array.from({ length: files.length })">
            <div class="flex flex-row items-center space-x-2">
              <template x-if="files[index].type.includes('audio/')"><i class="far fa-file-audio fa-fw"></i></template>
              <template x-if="files[index].type.includes('application/')"><i
                  class="far fa-file-alt fa-fw"></i></template>
              <template x-if="files[index].type.includes('image/')"><i class="far fa-file-image fa-fw"></i></template>
              <template x-if="files[index].type.includes('video/')"><i class="far fa-file-video fa-fw"></i></template>
              <span
                class="font-medium text-gray-900"
                x-text="files[index].name"
              >Uploading</span>
              <span
                class="self-end text-xs text-gray-500"
                x-text="filesize(files[index].size)"
              >...</span>
            </div>
          </template>
        </div>
      </template>
      <template x-if="files === null">
        <div class="flex flex-col items-center justify-center space-y-2">
          <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
          <p class="text-gray-700">Drag your files here or click in this area.</p>
          <a
            href="javascript:void(0)"
            class="mx-auto flex items-center rounded-md border border-transparent bg-red-700 py-2 px-4 text-center font-medium text-white outline-none"
          >Select a file</a>
        </div>
      </template>
    </div>
  </div>

  <input
    x-ref="mediaInput"
    {{ $attributes->whereStartsWith('wire:model') }}
    type="file"
    class="hidden"
    {{ $multiple ? 'multiple' : '' }}
    x-on:change.debounce="uploadFile(event)"
  >
  <div class="relative">
    <input
      type="file"
      multiple
      class="absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none"
      x-on:change="files = $event.target.files; console.log($event.target.files);"
      x-on:dragover="$el.classList.add('bg-gray-700')"
      x-on:dragleave="$el.classList.remove('bg-gray-700')"
      x-on:drop="$el.classList.remove('bg-gray-700')"
    >
    <div
      id="drop_zone"
      class="py-12"
    >
      <p>Drag one or more files to this <i>drop zone</i>.</p>
      <template x-for="file in files">
        <span x-text="file"></span>
      </template>
    </div>
  </div>
  @if ($multiple)
    <label class="block text-sm font-medium text-gray-700">
      {{ $label }}
    </label>
    <div class="mt-1 flex items-center">
      <span
        x-show="!media"
        class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100"
      >
        <svg
          class="h-full w-full text-gray-300"
          fill="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
          />
        </svg>
      </span>
      <img
        x-show="media && !preview"
        :src="media"
        class="h-12 w-12 rounded-full object-cover"
      >
      <img
        x-show="preview"
        :src="preview"
        class="h-12 w-12 rounded-full object-cover"
      >
      <button
        type="button"
        class="ml-5 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        @click="uploadEvent()"
      >
        Change
      </button>
      <span x-show="preview && file">
        <span x-text="file ? file.sizeDisplay : 0"></span>
      </span>
    </div>
  @else
    <div class="sm:pt-5">
      <label
        for="cover-photo"
        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
      >
        Cover photo
      </label>
      <div class="mt-2 sm:col-span-2">
        <div
          class="flex max-w-lg cursor-pointer justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6 transition-colors hover:bg-gray-50 hover:dark:bg-gray-800"
          @click="uploadEvent()"
        >
          <div class="space-y-1 text-center">
            <svg
              class="mx-auto h-12 w-12 text-gray-400"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 48 48"
              aria-hidden="true"
            >
              <path
                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            <div class="flex text-sm text-gray-600">
              <label
                for="file-upload"
                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
              >
                <span>Upload a file</span>
                <input
                  id="file-upload"
                  name="file-upload"
                  type="file"
                  class="sr-only"
                >
              </label>
              <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('media', () => ({
      files: undefined,
      file: undefined,
      media: undefined,
      preview: undefined,

      init() {
        console.log('init');
        // if (this.$refs.mediaInput) {
        //   let wire = this.$refs.mediaInput.getAttribute('wire:model')
        //   let wired = this.$wire.get(wire)
        //   let appUrl = this.$wire.get('app_url')
        //   this.media = `${appUrl}${wired}`
        // }
      },
      dropHandler(event) {
        console.log(event);
      },
      dragOverHandler(event) {
        console.log(event);
      },
      uploadEvent() {
        this.$refs.mediaInput.click()
      },
      uploadFile(event) {
        if (event.target.files && event.target.files[0]) {
          file = event.target.files[0]
          let src = URL.createObjectURL(file)
          this.preview = src

          this.file = {
            lastModified: file.lastModified,
            name: file.name,
            size: file.size,
            sizeDisplay: this.humanFileSize(file.size),
            type: file.type
          }
        }
      },
      //   /**
      //    * Format bytes as human-readable text.
      //    *
      //    * @param bytes Number of bytes.
      //    * @param si True to use metric (SI) units, aka powers of 1000. False to use
      //    *           binary (IEC), aka powers of 1024.
      //    * @param dp Number of decimal places to display.
      //    *
      //    * @return Formatted string.
      //    */
      //   humanFileSize(bytes, si = true, dp = 1) {
      //     const thresh = si ? 1000 : 1024;

      //     if (Math.abs(bytes) < thresh) {
      //       return bytes + ' B';
      //     }

      //     const units = si ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB',
      //       'PiB', 'EiB', 'ZiB', 'YiB'
      //     ];
      //     let u = -1;
      //     const r = 10 ** dp;

      //     do {
      //       bytes /= thresh;
      //       ++u;
      //     } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


      //     return bytes.toFixed(dp) + ' ' + units[u];
      //   },
    }))
  })
</script>
