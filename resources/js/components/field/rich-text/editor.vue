<template>
  <client-only>
    <div class="editor relative">
      <div v-if="editor" class="editor__actions">
        <fields-rich-text-action
          v-for="button in buttons"
          :key="button.id"
          :editor="editor"
          :action="button.action"
          :method="button.method"
          :params="button.params"
        >
          {{ button.title }}
        </fields-rich-text-action>
      </div>
      <hr class="mx-4" />
      <editor-content :editor="editor" class="editor__body" />
    </div>
  </client-only>
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-2'
import StarterKit from '@tiptap/starter-kit'
import Highlight from '@tiptap/extension-highlight'
import Typography from '@tiptap/extension-typography'

export default {
  components: {
    EditorContent,
  },
  props: {
    value: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      editor: null,
      buttons: [
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
      ],
    }
  },
  mounted() {
    this.editor = new Editor({
      extensions: [StarterKit, Highlight, Typography],
      editorProps: {
        attributes: {
          spellcheck: 'false',
          class:
            'prose prose-sm sm:prose lg:prose-lg p-4 mx-auto focus:outline-none max-h-screen overflow-auto scrollbar-thin dark:prose-light',
        },
      },
      content: `
        <h2>
          Hi there,
        </h2>
        <p>
          this is a <em>basic</em> example of <strong>tiptap</strong>. Sure, there are all kind of basic text styles you’d probably expect from a text editor. But wait until you see the lists:
        </p>
        <ul>
          <li>
            That’s a bullet list with one …
          </li>
          <li>
            … or two list items.
          </li>
        </ul>
        <p>
          Isn’t that great? And all of that is editable. But wait, there’s more. Let’s try a code block:
        </p>
        <pre><code class="language-css">body {
  display: none;
}</code></pre>
        <p>
          I know, I know, this is impressive. It’s only the tip of the iceberg though. Give it a try and click a little bit around. Don’t forget to check the other examples too.
        </p>
        <blockquote>
          Wow, that’s amazing. Good work, boy! 👏
          <br />
          — Mom
        </blockquote>
      `,
    })
  },
  beforeUnmount() {
    this.editor.destroy()
  },
}
</script>

<style lang="postcss" scoped>
/* Basic editor styles */
.editor::v-deep {
  @apply shadow-sm focus:ring-primary-500 focus:border-primary-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md;
}
.editor__actions::v-deep {
  @apply p-2 sticky top-20;
}
.ProseMirror::v-deep {
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
