<?
$this->params['styles'] = [
  ['href' => '/static/panel/article/list/index.css'],
];
?>

<div class="content__header">
  <div class="content__title">Articles</div><a class="btn btn-tertiary content__add-btn"><i class="fa fa-plus"></i>Добавить</a>
</div>
<div class="content__filter">
  <div class="content-seacher"><input class="input content-seacher__input" name="search" placeholder="Поиск по названию"><i class="content-seacher__icon fa fa-search"></i></div>
  <div class="select content-sort">
    <ul class="select__current content-sort__current" tabindex="0">
      <li class="select__value"><input class="select__input" id="sort-select-0" type="radio" name="sort" value="date|ASC" checked="checked">
        <div class="select__text content-sort__text">Дата публикации по возрастанию</div>
      </li>
      <li class="select__value"><input class="select__input" id="sort-select-1" type="radio" name="sort" value="date|DESC">
        <div class="select__text content-sort__text">Дата публикации по убывани</div>
      </li><i class="select__arrow fa fa-angle-down"></i>
    </ul>
    <ul class="select__list content-sort__list">
      <li><label class="select__label content-sort__label" for="sort-select-undefined">Дата публикации по
          возрастанию</label></li>
      <li><label class="select__label content-sort__label" for="sort-select-undefined">Дата публикации по
          убывани</label></li>
    </ul>
  </div>
</div>
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
              <li class="select__value"><input class="select__input" id="pagination-select-value-5" type="radio" name="rows-limit" value="5" checked="checked">
                <div class="select__text">5</div>
              </li>
              <li class="select__value"><input class="select__input" id="pagination-select-value-10" type="radio" name="rows-limit" value="10">
                <div class="select__text">10</div>
              </li>
              <li class="select__value"><input class="select__input" id="pagination-select-value-15" type="radio" name="rows-limit" value="15">
                <div class="select__text">15</div>
              </li><i class="select__arrow fa fa-angle-down"></i>
            </ul>
            <ul class="select__list">
              <li><label class="select__label" for="pagination-select-value-5">5</label></li>
              <li><label class="select__label" for="pagination-select-value-10">10</label></li>
              <li><label class="select__label" for="pagination-select-value-15">15</label></li>
            </ul>
          </div><span>1-3 из 3</span>
          <div class="content-pagination__arrows"><a class="btn content-pagination__arrow"><i class="fa fa-arrow-left"></i></a><a class="btn content-pagination__arrow"><i class="fa fa-arrow-right"></i></a></div>
        </div>
      </td>
    </tr>
  </tfoot>
  <tbody class="table__tbody">
    <tr class="table__tbody-tr">
      <td class="table__tbody-td content-table__tbody-td">27-11-2021 14:52</td>
      <td class="table__tbody-td content-table__tbody-td"><a class="table__link" href="#"><img class="table__image" src="../../../assets/images/plus.png"><span class="table__title" href="#">Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?</span></a></td>
      <td class="table__tbody-td content-table__tbody-td">
        <div class="content-table__group-btn"><a class="btn btn-secondary content-table__action"><i class="fa fa-pen"></i></a><a class="btn btn-warning content-table__action"><i class="fa fa-trash"></i></a></div>
      </td>
    </tr>
    <tr class="table__tbody-tr">
      <td class="table__tbody-td content-table__tbody-td">27-11-2021 14:52</td>
      <td class="table__tbody-td content-table__tbody-td"><a class="table__link" href="#"><img class="table__image" src="../../../assets/images/plus.png"><span class="table__title" href="#">Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?</span></a></td>
      <td class="table__tbody-td content-table__tbody-td">
        <div class="content-table__group-btn"><a class="btn btn-secondary content-table__action"><i class="fa fa-pen"></i></a><a class="btn btn-warning content-table__action"><i class="fa fa-trash"></i></a></div>
      </td>
    </tr>
    <tr class="table__tbody-tr">
      <td class="table__tbody-td content-table__tbody-td">27-11-2021 14:52</td>
      <td class="table__tbody-td content-table__tbody-td"><a class="table__link" href="#"><img class="table__image" src="../../../assets/images/plus.png"><span class="table__title" href="#">Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?Lorem ipsum dolor, sit amet
            consectetur adipisicing elit. Labore unde sapiente ducimus. Eaque vel dolorem autem fugiat sed amet
            consequuntur, nemo, rerum nam fuga est harum aliquid rem voluptatibus labore?</span></a></td>
      <td class="table__tbody-td content-table__tbody-td">
        <div class="content-table__group-btn"><a class="btn btn-secondary content-table__action"><i class="fa fa-pen"></i></a><a class="btn btn-warning content-table__action"><i class="fa fa-trash"></i></a></div>
      </td>
    </tr>
  </tbody>
</table>