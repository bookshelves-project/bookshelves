export { buttons };

const buttons = [
  {
    title: "Bold",
    action: "bold",
    method: "toggleBold",
  },
  {
    title: "Italic",
    action: "italic",
    method: "toggleItalic",
  },
  {
    title: "Strike",
    action: "strike",
    method: "toggleStrike",
  },
  {
    title: "Code",
    action: "code",
    method: "toggleCode",
  },
  {
    title: "Clear marks",
    method: "unsetAllMarks",
  },
  {
    title: "Clear nodes",
    method: "clearNodes",
  },
  {
    title: "Paragraph",
    action: "paragraph",
    method: "setParagraph",
  },
  {
    title: "H1",
    action: "heading",
    method: "toggleHeading",
    params: { level: 1 },
  },
  {
    title: "H2",
    action: "heading",
    method: "toggleHeading",
    params: { level: 2 },
  },
  {
    title: "H3",
    action: "heading",
    method: "toggleHeading",
    params: { level: 3 },
  },
  {
    title: "H4",
    action: "heading",
    method: "toggleHeading",
    params: { level: 4 },
  },
  {
    title: "H5",
    action: "heading",
    method: "toggleHeading",
    params: { level: 5 },
  },
  {
    title: "H6",
    action: "heading",
    method: "toggleHeading",
    params: { level: 6 },
  },
  {
    title: "Bullet list",
    action: "bulletList",
    method: "toggleBulletList",
  },
  {
    title: "Ordered list",
    action: "orderedList",
    method: "toggleOrderedList",
  },
  {
    title: "Code block",
    action: "codeBlock",
    method: "toggleCodeBlock",
  },
  {
    title: "Blockquote",
    action: "blockquote",
    method: "toggleBlockquote",
  },
  {
    title: "Horizontal rule",
    method: "setHorizontalRule",
  },
  {
    title: "Break",
    method: "setHardBreak",
  },
  {
    title: "Undo",
    method: "undo",
  },
  {
    title: "Redo",
    method: "redo",
  },
];
