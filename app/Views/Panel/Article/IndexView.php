<?
$this->title .= "Панель управления | " . (isset($article['id']) ? 'Редактировать' : 'Создать') . ' статью';
$this->params['styles'] = [
  ['href' => '/static/panel/article/index.css'],
];
$this->params['scripts'] = [
  ['src' => '/static/components/tinymce/tinymce.min.js'],
  ['text' => "var contentTinyMCE = `" . (isset($article['content']) ? $article['content'] : '') . "`"],
  ['src' => '/static/panel/article/index.js']
];
?>

<div class="content__header">
  <div class="content__title">Статья</div>
</div>
<? if (isset($errors) && count($errors)) : ?>
  <div class="content-form__errors">
    <? foreach ($errors as $error) : ?>
      <div><?= $error ?></div>
    <? endforeach; ?>
  </div>
<? endif; ?>
<form class="form" method="post" enctype="multipart/form-data">
  <div class="form__group">
    <div class="form__title">Общие сведения</div>
    <div class="form__fields">
      <div class="form__field">
        <input class="input form__control" name="title" placeholder="Заголовок статьи" minlength="8" maxlength="64" value="<?= $article['title'] ?? '' ?>" required>
      </div>
      <div class="form__field">
        <textarea class="editor form__fontrol" id="content-form-editor" name="content"></textarea>
      </div>
    </div>
  </div>
  <div class="form__group">
    <div class="form__title">Изображение</div>
    <div class="form__fields">
      <div class="form__field">
        <input id="input-image-file" class="input form__control" type="file" accept="image/*" name="image">
        <label class="content-form__label" for="input-image-file">
          <? if (isset($article['id'])) : ?>
            <img src="<?= $article['image'] ?>" class="content-form__preview">
          <? endif; ?>
          <i class="fa fa-image fa-2x"></i>
          <span>Выберите изображение</span>
        </label>
      </div>
    </div>
  </div>
  <div class="form__footer content-form__footer">
    <a class="btn btn-text-warning content-form__footer-btn" href="/panel/article/delete/<?= $article['id'] ?? '' ?>">
      Удалить
    </a>
    <a class="btn btn-outline-secondary content-form__footer-btn" href="/panel/article/list">Отмена</a>
    <button class="btn btn-secondary content-form__footer-btn" type="submit" name="submit">
      <?= isset($article['id']) ? 'Сохранить' : 'Создать' ?>
    </button>
  </div>
</form>