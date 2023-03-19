<!-- Include stylesheet -->
{{-- <link
  href="https://cdn.quilljs.com/1.3.6/quill.snow.css"
  rel="stylesheet"
> --}}
<style>
  .ql-link path {
    stroke: white !important;
  }

  div[class^="tocolor-"],
  div[class*=" tocolor-"] {
    color: white;
  }
</style>

<!-- Create the editor container -->
<div id="editor">
  <p>Hello World!</p>
  <p>Some initial <strong>bold</strong> text</p>
  <p><br></p>
</div>

<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
  var quill = new Quill('#editor', {
    theme: 'snow'
  });
</script>
