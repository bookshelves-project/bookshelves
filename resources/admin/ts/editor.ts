import type { Alpine } from 'alpinejs'
import type { ChainedCommands } from '@tiptap/core'
import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Typography from '@tiptap/extension-typography'
import CharacterCount from '@tiptap/extension-character-count'
import Link from '@tiptap/extension-link'
import type { ActionButton } from './actions'
import { ExecuteCommand, Extras, Marks, Nodes } from './actions'
// import type { ChainedCommands, EditorT } from '../../../lib/dist'
// import { tiptap } from '../../../lib/dist'
// import { CharacterCount, Editor, Link, StarterKit, Typography } from '@/lib/dist'
// import type { ChainedCommands } from '@/lib/dist'

let refs: {
  editorReference: HTMLElement
}

let editor: Editor

/**
 * Tiptap editor
 *
 * Helped with: https://github.com/ueberdosis/tiptap/issues/1515#issuecomment-903095273
 */
export default (Alpine: Alpine) => {
  Alpine.data('editor', () => ({
    content: '<p>This is where the content goes</p>',
    actions: [] as ActionButton[],
    updatedAt: Date.now(),
    $wire: {
      content: '',
    },
    init() {
      // eslint-disable-next-line @typescript-eslint/prefer-ts-expect-error
      // @ts-ignore - this is a reference to the Alpine data object
      refs = this.$refs

      editor = new Editor({
        element: refs.editorReference,
        extensions: [
          StarterKit,
          Typography,
          // CharacterCount.configure({
          //   limit: this.limit,
          // }),
          CharacterCount,
          Link,
        ],
        content: this.content,
        onCreate: () => {
          this.updatedAt = Date.now()
          this.content = editor.getHTML()
          this.$wire.content = this.content
        },
        onUpdate: ({ editor }) => {
          this.updatedAt = Date.now()
          this.content = editor.getHTML()
          this.$wire.content = this.content
        },
        onTransaction: () => {
          this.updatedAt = Date.now()
        },
      })

      this.actions = [
        Marks.bold,
        Marks.italic,
        Marks.strike,
        Marks.code,
        Marks.link,
        Nodes.h1,
        Nodes.h2,
        Nodes.h3,
        Extras.separator,
        Nodes.codeBlock,
        Nodes.blockquote,
        Nodes.bulletList,
        Nodes.orderedList,
        Nodes.horizontalRule,
        Nodes.hardBreak,
        Extras.separator,
        Extras.clearNodes,
        Extras.redo,
        Extras.undo,
      ]
    },
    isActive(action: ActionButton) {
      return editor.isActive(action.command, action.params)
    },
    isChainedCommands(method: ChainedCommands): method is ChainedCommands {
      return (<ChainedCommands>method).run() !== undefined
    },
    command(action: ActionButton) {
      ExecuteCommand(editor, action)
    },
    countCharacters() {
      return editor.storage.characterCount.characters()
    },
    countWords() {
      return editor.storage.characterCount.words()
    },
  }))
}
