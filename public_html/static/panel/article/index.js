(function () {
  tinyMCE.init({
    selector: 'textarea#content-form-editor',
    height: 600,
    menubar: false,
    toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat',
    skin: 'oxide-dark',
    content_css: 'dark',
    font_css: '/static/components/fonts.css',
    setup: function (editor) {
      editor.on('init', function (e) {
        editor.setContent(contentTinyMCE);
      });
    }
  });
})()