import { useElfinderStore } from '@admin/stores/elfinder'
import type { Editor } from '@tiptap/vue-3'
import { truncate } from 'lodash'
import route from 'ziggy-js'

export const useEditorInput = () => {
  const bold: EditorButton = {
    title: 'Bold',
    icon: 'bold',
    action: 'bold',
    method: 'toggleBold',
  }
  const italic: EditorButton = {
    title: 'Italic',
    icon: 'italic',
    action: 'italic',
    method: 'toggleItalic',
  }
  const strike: EditorButton = {
    title: 'Strike',
    icon: 'strike',
    action: 'strike',
    method: 'toggleStrike',
  }
  const code: EditorButton = {
    title: 'Code',
    icon: 'code',
    action: 'code',
    method: 'toggleCode',
  }
  const link: EditorButton = {
    title: 'Link',
    icon: 'link',
    custom: true,
    method: 'setLink',
  }
  const h1: EditorButton = {
    title: 'H1',
    icon: 'h1',
    action: 'heading',
    method: 'toggleHeading',
    params: { level: 1 },
  }
  const h2: EditorButton = {
    title: 'H2',
    icon: 'h2',
    action: 'heading',
    method: 'toggleHeading',
    params: { level: 2 },
  }
  const h3: EditorButton = {
    title: 'H3',
    icon: 'h3',
    action: 'heading',
    method: 'toggleHeading',
    params: { level: 3 },
  }
  const paragraph: EditorButton = {
    title: 'Paragraph',
    icon: 'paragraph',
    action: 'paragraph',
    method: 'setParagraph',
  }
  const listBullet: EditorButton = {
    title: 'Bullet list',
    icon: 'list-bullet',
    action: 'bulletList',
    method: 'toggleBulletList',
  }
  const listOrdered: EditorButton = {
    title: 'Ordered list',
    icon: 'list-ordered',
    action: 'orderedList',
    method: 'toggleOrderedList',
  }
  const listTask: EditorButton = {
    title: 'Task list',
    icon: 'list-task',
    action: 'bulletList',
    method: 'toggleTaskList',
  }
  const codeBlock: EditorButton = {
    title: 'Code block',
    icon: 'code-block',
    action: 'codeBlock',
    method: 'toggleCodeBlock',
  }
  const image: EditorButton = {
    title: 'Image',
    icon: 'image',
    custom: true,
    method: 'addImage',
  }
  const blockquote: EditorButton = {
    title: 'Blockquote',
    icon: 'blockquote',
    action: 'blockquote',
    method: 'toggleBlockquote',
  }
  const horizontalRule: EditorButton = {
    title: 'Horizontal rule',
    icon: 'horizontal-rule',
    method: 'setHorizontalRule',
  }
  const breakLine: EditorButton = {
    title: 'Break',
    icon: 'break',
    method: 'setHardBreak',
  }
  const clearText: EditorButton = {
    title: 'Clear',
    icon: 'clear-nodes',
    custom: true,
    method: 'clear',
  }
  const clearMarks: EditorButton = {
    title: 'Clear marks',
    icon: 'clear-nodes',
    method: 'unsetAllMarks',
  }
  const clearNodes: EditorButton = {
    title: 'Clear nodes',
    icon: 'clear-nodes',
    method: 'clearNodes',
  }
  const undo: EditorButton = {
    title: 'Undo',
    icon: 'undo',
    method: 'undo',
  }
  const redo: EditorButton = {
    title: 'Redo',
    icon: 'redo',
    method: 'redo',
  }
  const seperator: EditorButton = {
    seperator: true,
  }

  const elfinder = () => {
    window.open(route('elfinder.ckeditor'))
  }
  const callMethod = (name: string, params: any) => {
    const list: { [K: string]: any } = {
      addImage,
      clear,
      setLink,
    }

    if (list[name])
      return list[name](params)

    console.error(`Method '${name}' is not implemented.`)
  }

  const addImage = (editor: Editor) => {
    // const { toggleElfinderStatus } = useElfinderStore()
    // toggleElfinderStatus()
    const url = window.prompt('URL')

    if (url)
      editor.chain().focus().setImage({ src: url }).run()
  }

  const clear = (editor: Editor) => {
    editor.chain().focus().unsetAllMarks().run()
    editor.chain().focus().clearNodes().run()
  }

  const setLink = (editor: Editor) => {
    const previousUrl = editor.getAttributes('link').href
    const url = window.prompt('URL', previousUrl)

    // cancelled
    if (url === null)
      return

    // empty
    if (url === '') {
      editor.chain().focus().extendMarkRange('link').unsetLink().run()

      return
    }

    // update link
    editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
  }

  const buttonsBasic = (): EditorButton[] => {
    const buttons: EditorButton[] = [
      bold,
      italic,
      strike,
      seperator,
      breakLine,
      clearText,
      seperator,
      undo,
      redo,
    ]

    return buttons
  }
  const buttonsComplete = (): EditorButton[] => {
    const buttons: EditorButton[] = [
      bold,
      italic,
      strike,
      link,
      code,
      seperator,
      h2,
      h3,
      paragraph,
      listBullet,
      listOrdered,
      codeBlock,
      seperator,
      image,
      blockquote,
      horizontalRule,
      seperator,
      breakLine,
      clearText,
      seperator,
      undo,
      redo,
    ]

    return buttons
  }

  return {
    buttonsBasic,
    buttonsComplete,
    callMethod,
    elfinder,
  }
}
