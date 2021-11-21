export { buttons };

const buttons = [
  {
    title: "Bold",
    svg: "bold",
    action: "bold",
    method: "toggleBold",
  },
  {
    title: "Italic",
    svg: "italic",
    action: "italic",
    method: "toggleItalic",
  },
  {
    title: "Strike",
    svg: "strike",
    action: "strike",
    method: "toggleStrike",
  },
  {
    title: "Underline",
    svg: "underline",
    action: "underline",
    method: "toggleUnderline",
  },
  {
    space: true,
  },
  // {
  //   title: "Paragraph",
  //   // svg: "paragraph",
  //   action: "paragraph",
  //   method: "setParagraph",
  // },
  {
    title: "H1",
    svg: "h1",
    action: "heading",
    method: "toggleHeading",
    params: { level: 1 },
  },
  {
    title: "H2",
    svg: "h2",
    action: "heading",
    method: "toggleHeading",
    params: { level: 2 },
  },
  {
    title: "H3",
    svg: "h3",
    action: "heading",
    method: "toggleHeading",
    params: { level: 3 },
  },
  {
    space: true,
  },
  // {
  //   title: "H4",
  // svg: "h4",
  //   action: "heading",
  //   method: "toggleHeading",
  //   params: { level: 4 },
  // },
  // {
  //   title: "H5",
  // svg: "h5",
  //   action: "heading",
  //   method: "toggleHeading",
  //   params: { level: 5 },
  // },
  // {
  //   title: "H6",
  // svg: "h6",
  //   action: "heading",
  //   method: "toggleHeading",
  //   params: { level: 6 },
  // },
  {
    title: "Bullet list",
    svg: "bullet-list",
    action: "bulletList",
    method: "toggleBulletList",
  },
  {
    title: "Ordered list",
    svg: "ordered-list",
    action: "orderedList",
    method: "toggleOrderedList",
  },
  {
    title: "Task list",
    svg: "task-list",
    action: "taskList",
    method: "toggleTaskList",
  },
  {
    title: "Blockquote",
    svg: "blockquote",
    action: "blockquote",
    method: "toggleBlockquote",
  },
  {
    space: true,
  },
  {
    title: "Code",
    svg: "code",
    action: "code",
    method: "toggleCode",
  },
  {
    title: "Code block",
    svg: "code-block",
    action: "codeBlock",
    method: "toggleCodeBlock",
  },
  {
    space: true,
  },
  {
    title: "Divide",
    svg: "horizontal-rule",
    method: "setHorizontalRule",
  },
  // {
  //   title: "Break",
  //   svg: "break",
  //   method: "setHardBreak",
  // },

  {
    title: "Link",
    svg: "link",
    method: "setLink",
    custom: true,
  },

  {
    title: "Image",
    svg: "image",
    method: "addImage",
    custom: true,
  },
  {
    space: true,
  },
  {
    title: "Clear marks",
    svg: "clear-marks",
    method: "unsetAllMarks",
  },
  {
    title: "Clear styles",
    svg: "clear-nodes",
    method: "clearNodes",
  },
  {
    title: "Undo",
    svg: "undo",
    method: "undo",
  },
  {
    title: "Redo",
    svg: "redo",
    method: "redo",
  },
  {
    title: "Help",
    svg: "help",
    method: "help",
    custom: true,
  },
];
