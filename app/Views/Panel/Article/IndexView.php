<?
$this->title .= "Панель управления | " . (isset($id) ? 'Редактировать' : 'Создать') . ' статью';
$this->params['styles'] = [
  ['href' => '/static/panel/article/index.css'],
];
$this->params['scripts'] = [
  ['src' => '/static/components/tinymce/tinymce.min.js'],
  ['text' => "var contentTinyMCE = `" . (isset($content) ? $content : '') . "`"],
  ['src' => '/static/panel/article/index.js']
];
?>

<div class="content__header">
  <div class="content__title">Статья</div>
</div>
<form class="form" method="post">
  <div class="form__group">
    <div class="form__title">Общие сведения</div>
    <div class="form__fields">
      <div class="form__field">
        <input class="input form__control" name="title" placeholder="Заголовок статьи" minlength="8" maxlength="64" value="<?= $title ?? '' ?>">
      </div>
      <div class="form__field">
        <textarea class="editor form__fontrol" id="content-form-editor" name="content" value="<?= $content ?>"></textarea>
      </div>
    </div>
  </div>
  <div class="form__footer content-form__footer">
    <a class="btn btn-text-warning content-form__footer-btn" href="/panel/article/delete/<?= $id ?? '' ?>">
      Удалить
    </a>
    <a class="btn btn-outline-secondary content-form__footer-btn" href="/panel/article/list">Отмена</a>
    <button class="btn btn-secondary content-form__footer-btn" type="submit" name="submit">
      <?= isset($id) ? 'Сохранить' : 'Создать' ?>
    </button>
  </div>
</form>