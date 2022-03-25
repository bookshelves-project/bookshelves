<template>
  <input-label :for="id" class="mb-1" :value="getLabel" />
  <div class="editor-text">
    <div class="editor relative">
      <div v-if="editor" class="editor__actions">
        <editor-input-action
          v-for="button in buttons"
          :key="button.action"
          :editor="editor"
          :action="button.action"
          :method="button.method"
          :params="button.params"
        >
          {{ button.title }}
        </editor-input-action>
      </div>
      <hr class="mx-4" />
      <editor-content
        v-model="formValue"
        :editor="editor"
        class="editor__body"
      />
      <div class="mx-4">
        <div
          class="p-2 border-t border-gray-300 text-gray-600 italic dark:border-gray-700 dark:text-gray-400"
        >
          Powered by
          <a
            href="https://tiptap.dev/"
            target="_blank"
            rel="noopener noreferrer"
            class="underline underline-gray-600 underline-offset-2"
            >Tiptap</a
          >, you can use
          <a
            href="https://www.markdownguide.org/cheat-sheet/"
            target="_blank"
            rel="noopener noreferrer"
            class="underline underline-gray-600 underline-offset-2"
            >Markdown</a
          >.
        </div>
      </div>
    </div>
    <input-error :message="getError" class="mt-2" />
    <input-hint :message="hint" class="mt-2" />
  </div>
</template>

<script lang="ts" setup>
  import { onMounted } from 'vue'
  import { inputProps, inputSetup } from '@admin/composables/input'
  import { getLocale, __ } from 'matice'
  import route from 'ziggy-js'
  import axios from 'axios'
  import { EditorContent, useEditor } from '@tiptap/vue-3'
  import StarterKit from '@tiptap/starter-kit'
  import Typography from '@tiptap/extension-typography'

  const props = defineProps({
    ...inputProps,
    modelValue: String,
    height: {
      type: Number,
      default: 500,
    },
    menubar: Boolean,
    statusbar: Boolean,
    inline: Boolean,
    plugins: Array,
    toolbar: String,
  })

  const emit = defineEmits(['update:modelValue'])
  const { getLabel, formValue, getError, id } = inputSetup(props, emit)

  const editor = useEditor({
    content: props.modelValue,
    extensions: [StarterKit, Typography],
    editorProps: {
      attributes: {
        spellcheck: 'false',
        class:
          'prose prose-lg max-w-full p-4 mx-auto focus:outline-none max-h-screen min-h-[50vh] overflow-auto scrollbar-thin',
      },
    },
    onUpdate: () => {
      formValue.value = editor.value?.getHTML()
    },
  })
  onMounted(() => {
    if (editor.value) {
      editor.value.commands.setContent(formValue.value)
    }
  })

  const buttons = [
    {
      title: 'Bold',
      action: 'bold',
      method: 'toggleBold',
    },
    {
      title: 'Italic',
      action: 'italic',
      method: 'toggleItalic',
    },
    {
      title: 'Strike',
      action: 'strike',
      method: 'toggleStrike',
    },
    {
      title: 'Code',
      action: 'code',
      method: 'toggleCode',
    },
    {
      title: 'Clear marks',
      method: 'unsetAllMarks',
    },
    {
      title: 'Clear nodes',
      method: 'clearNodes',
    },
    {
      title: 'Paragraph',
      action: 'paragraph',
      method: 'setParagraph',
    },
    {
      title: 'H1',
      action: 'heading',
      method: 'toggleHeading',
      params: { level: 1 },
    },
    {
      title: 'H2',
      action: 'heading',
      method: 'toggleHeading',
      params: { level: 2 },
    },
    {
      title: 'H3',
      action: 'heading',
      method: 'toggleHeading',
      params: { level: 3 },
    },
    {
      title: 'H4',
      action: 'heading',
      method: 'toggleHeading',
      params: { level: 4 },
    },
    {
      title: 'H5',
      action: 'heading',
      method: 'toggleHeading',
      params: { level: 5 },
    },
    {
      title: 'H6',
      action: 'heading',
      method: 'toggleHeading',
      params: { level: 6 },
    },
    {
      title: 'Bullet list',
      action: 'bulletList',
      method: 'toggleBulletList',
    },
    {
      title: 'Ordered list',
      action: 'orderedList',
      method: 'toggleOrderedList',
    },
    {
      title: 'Code block',
      action: 'codeBlock',
      method: 'toggleCodeBlock',
    },
    {
      title: 'Blockquote',
      action: 'blockquote',
      method: 'toggleBlockquote',
    },
    {
      title: 'Horizontal rule',
      method: 'setHorizontalRule',
    },
    {
      title: 'Break',
      method: 'setHardBreak',
    },
    {
      title: 'Undo',
      method: 'undo',
    },
    {
      title: 'Redo',
      method: 'redo',
    },
  ]

  // const init = computed(() => {
  //   return {
  //     language: getLocale() === 'fr' ? 'fr_FR' : null,
  //     menubar: props.menubar,
  //     statusbar: props.statusbar,
  //     inline: props.inline,
  //     plugins: props.plugins || [
  //       'advlist autolink lists link image charmap print preview anchor',
  //       'searchreplace visualblocks code fullscreen',
  //       'insertdatetime media paste code help wordcount table',
  //     ],
  //     toolbar:
  //       props.toolbar ||
  //       'undo redo | formatselect | bold italic | \
  //           bullist numlist | image media table | help',
  //     height: props.height,
  //     paste_data_images: true,
  //     images_upload_handler: async (
  //       blobInfo,
  //       success: (msg: string) => void,
  //       failure: (msg: string) => void
  //     ) => {
  //       try {
  //         let formData = new FormData()
  //         formData.append('file', blobInfo.blob(), blobInfo.filename())
  //         let { data } = await axios.post<
  //           FormData,
  //           { data: { location: string } }
  //         >(route('admin.upload'), formData)

  //         success(data.location)
  //       } catch (e: any) {
  //         failure('HTTP Error: ' + e.status)
  //       }
  //     },
  //     file_picker_callback: (
  //       callback: (url: string, meta?) => void,
  //       value,
  //       meta
  //     ) => {
  //       window.tinymce.activeEditor.windowManager.openUrl({
  //         title: __('File Manager'),
  //         url: route('elfinder.tinymce5'),
  //         /**
  //          * On message will be triggered by the child window
  //          *
  //          * @param dialogApi
  //          * @param details
  //          * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
  //          */
  //         onMessage: function (dialogApi, details) {
  //           if (details.mceAction === 'fileSelected') {
  //             const file = details.data.file

  //             // Make file info
  //             const info = file.name

  //             // Provide file and text for the link dialog
  //             if (meta.filetype === 'file') {
  //               callback(file.url, { text: info, title: info })
  //             }

  //             // Provide image and alt text for the image dialog
  //             if (meta.filetype === 'image') {
  //               callback(file.url, { alt: info })
  //             }

  //             // Provide alternative source and posted for the media dialog
  //             if (meta.filetype === 'media') {
  //               callback(file.url)
  //             }

  //             dialogApi.close()
  //           }
  //         },
  //       })
  //     },
  //   }
  // })
</script>

<style lang="css" scoped>
  /* Basic editor styles */
  .editor-text :deep(.editor) {
    @apply shadow-sm focus:ring-primary-500 focus:border-primary-500 mt-1 block w-full sm:text-base border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700;
  }
  .editor-text :deep(.editor__actions) {
    @apply p-2 sticky top-20;
  }
  .editor-text :deep(.ProseMirror) {
    > * + * {
      margin-top: 0.75em;
    }

    ul,
    ol {
      padding: 0 1rem;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      line-height: 1.1;
    }

    code {
      background-color: rgba(#616161, 0.1);
      color: #616161;
    }

    pre {
      background: #0d0d0d;
      color: #fff;
      font-family: 'JetBrainsMono', monospace;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;

      code {
        color: inherit;
        padding: 0;
        background: none;
        font-size: 0.8rem;
      }
    }

    img {
      max-width: 100%;
      height: auto;
    }

    blockquote {
      padding-left: 1rem;
      border-left: 2px solid rgba(#0d0d0d, 0.1);
    }

    hr {
      border: none;
      border-top: 2px solid rgba(#0d0d0d, 0.1);
      margin: 2rem 0;
    }
  }
</style>
