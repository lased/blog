<?
$this->title .= "Панель управления | Статьи";
$this->params = [
  'styles' => [
    ['href' => '/static/panel/article/list/index.css']
  ],
  'scripts' => [
    ['src' => '/static/panel/article/list/index.js']
  ]
];
$limit = key(array_filter($rowlimits, function ($value) {
  return $value;
}));
$queryString = $this->route['queryString'];
?>

<div class="content__header">
  <div class="content__title">Статьи</div>
  <a class="btn btn-tertiary content__add-btn" href="/panel/article/create">
    <i class="fa fa-plus"></i>Добавить
  </a>
</div>
<div class="content__filter">
  <div class="content-seacher">
    <input class="input content-seacher__input" name="search" placeholder="Поиск по названию" value="<?= $search ?>">
    <i class="content-seacher__icon fa fa-search"></i>
  </div>
  <div class="select content-sort">
    <ul class="select__current content-sort__current" tabindex="0">
      <? foreach ($sortValues as $index => $sort) : ?>
        <li class="select__value">
          <input class="select__input" id="sort-select-<?= $index ?>" type="radio" name="sort" value="<?= $sort['value'] ?>" <?= !empty($sort['checked']) ? 'checked' : '' ?>>
          <div class="select__text content-sort__text"><?= $sort['text'] ?></div>
        </li>
      <? endforeach; ?>
      <i class="select__arrow fa fa-angle-down"></i>
    </ul>
    <ul class="select__list content-sort__list">
      <? foreach ($sortValues as $index => $sort) : ?>
        <li>
          <label class="select__label content-sort__label" for="sort-select-<?= $index ?>"><?= $sort['text'] ?></label>
        </li>
      <? endforeach; ?>
    </ul>
  </div>
</div>
<? if (count($articles)) : ?>
  <table class="table content-table">
    <thead class="table__thead">
      <tr class="table__thead-tr">
        <th class="table__thead-th content-table__th">Дата публикации</th>
        <th class="table__thead-th content-table__th">Заголовок</th>
        <th class="table__thead-th content-table__th">Действия</th>
      </tr>
    </thead>
    <tfoot class="table__tfoot">
      <tr>
        <td class="table__tfoot-td" colspan="3">
          <div class="content-pagination"><span>Записей на странице:</span>
            <div class="select content-pagination__select">
              <ul class="select__current" tabindex="0">
                <? foreach ($rowlimits as $value => $checked) : ?>
                  <li class="select__value">
                    <input class="select__input" id="pagination-select-value-<?= $value ?>" type="radio" name="limit" value="<?= $value ?>" <?= $checked ? 'checked' : '' ?>>
                    <div class="select__text"><?= $value ?></div>
                  </li>
                <? endforeach; ?>
                <i class="select__arrow fa fa-angle-down"></i>
              </ul>
              <ul class="select__list">
                <? foreach ($rowlimits as $value => $checked) : ?>
                  <li><label class="select__label" for="pagination-select-value-<?= $value ?>"><?= $value ?></label></li>
                <? endforeach; ?>
              </ul>
            </div>
            <span>
              <? $start = ($page - 1) * $limit + 1; ?>
              <?= count($articles) === 0 ? '0-0' : $start . '-' . ($start - 1 + count($articles)) ?>
              из <?= $rowsCount ?>
            </span>
            <div class="content-pagination__arrows">
              <?
              $pageString = $queryString->get('page');
              $queryString->set('page', $page - 1);
              ?>
              <button class="btn content-pagination__btn" <? if (!($page - 1)) : ?> disabled <? endif; ?>>
                <a class="content-pagination__link" href="<?= '?' . $queryString->toString() ?>">
                  <i class="fa fa-arrow-left"></i>
                </a>
              </button>
              <? $queryString->set('page', $page + 1); ?>
              <button class="btn content-pagination__btn" <? if (ceil($rowsCount / $limit) == $page) : ?> disabled <? endif; ?>>
                <a class="content-pagination__link" href="<?= '?' . $queryString->toString() ?>">
                  <i class="fa fa-arrow-right"></i>
                </a>
              </button>
              <? $pageString ?? $queryString->remove('page'); ?>
            </div>
          </div>
        </td>
      </tr>
    </tfoot>
    <tbody class="table__tbody">
      <? foreach ($articles as $article) : ?>
        <tr class="table__tbody-tr">
          <td class="table__tbody-td content-table__tbody-td"><?= $article['created_at'] ?></td>
          <td class="table__tbody-td content-table__tbody-td">
            <a class="table__link content-table__link" href="/panel/article/update/<?= $article['id'] ?>">
              <img class="content-table__image" src="<?= $article['image'] ?>">
              <span class="content-table__title"><?= $article['title'] ?></span>
            </a>
          </td>
          <td class="table__tbody-td content-table__tbody-td">
            <div class="content-table__group-btn">
              <a class="btn btn-secondary content-table__action" href="/panel/article/update/<?= $article['id'] ?>">
                <i class="fa fa-pen"></i>
              </a>
              <a class="btn btn-warning content-table__action" href="/panel/article/delete/<?= $article['id'] ?>">
                <i class="fa fa-trash"></i>
              </a>
            </div>
          </td>
        </tr>
      <? endforeach; ?>
    </tbody>
  </table>
<? else : ?>
  <h2 style="text-align: center;">Записей не найдено</h2>
<? endif; ?>