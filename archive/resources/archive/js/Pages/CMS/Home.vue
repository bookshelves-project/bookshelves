<template>
  <LayoutDefault>
    <section class="m-6 max-w-6xl mx-auto px-6">
      <div>
        <h2 class="text-lg font-semibold mb-3 text-primary-600">Editor</h2>
        <rich-text v-model="editor" />
      </div>
      <div class="mt-6">
        <h2 class="text-lg font-semibold mb-3 text-primary-600">Preview</h2>
        <div class="border border-gray-300 rounded-md p-6">
          <div v-html="editor" class="prose"></div>
        </div>
      </div>
    </section>
  </LayoutDefault>
</template>

<script setup>
import { ref, computed, watch } from "vue";

const editor = ref(`
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
        <ul data-type="taskList">
          <li data-type="taskItem" data-checked="true">A list item</li>
          <li data-type="taskItem" data-checked="false">And another one</li>
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
      `);
function onSubmit() {
  // submit to backend or whatever you like
  console.log(editor.value);
}
</script>
