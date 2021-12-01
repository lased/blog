(function () {
  tinyMCE.init({
    selector: 'textarea#content-form-editor',
    height: 600,
    menubar: false,
    toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'link | ' +
      'removeformat',
    plugins: 'link paste image',
    paste_data_images: true,
    skin: 'oxide-dark',
    content_css: 'dark',
    language: 'ru',
    font_css: '/static/components/fonts.css',
    setup: function (editor) {
      editor.on('init', function (e) {
        editor.setContent(contentTinyMCE);
      });
    }
  });

  document.getElementById('input-image-file').addEventListener('change', preview);

  function preview(event) {
    const input = this;
    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function () {
      const img = new Image()

      img.src = reader.result;
      img.classList.add('content-form__preview');
      input.nextElementSibling.insertAdjacentElement('afterbegin', img);
    }

    reader.readAsDataURL(file);
  }
})()