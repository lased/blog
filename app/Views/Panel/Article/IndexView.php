<?
$this->params['styles'] = [
  ['href' => '/static/panel/article/index.css'],
];
$this->params['scripts'] = [
  ['src' => '/static/components/tinymce/tinymce.min.js'],
  ['src' => '/static/panel/article/index.js']
];
?>

<div class="content__header">
  <div class="content__title">Article</div>
</div>
<form class="form" method="post">
  <div class="form__group">
    <div class="form__title">Общие сведения</div>
    <div class="form__fields">
      <div class="form__field">
        <input class="input form__control" name="title" placeholder="Заголовок статьи" minlength="8" maxlength="64">
      </div>
      <div class="form__field">
        <textarea class="editor form__fontrol" id="content-form-editor"></textarea>
      </div>
    </div>
  </div>
  <div class="form__footer content-form__footer"><button class="btn btn-text-warning content-form__footer-btn" type="submit" name="delete">Удалить</button><button class="btn btn-outline-secondary content-form__footer-btn" type="submit" name="cancel">Отмена</button><button class="btn btn-secondary content-form__footer-btn" type="submit" name="submit">Создать</button></div>
</form>