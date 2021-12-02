<?
$this->params = [
    'styles' => [
        ['href' => '/static/index.css']
    ]
];
$queryString = $this->route['queryString'];
?>

<div class="wrapper">
    <form class="content-seacher" method="GET">
        <input class="input content-seacher__input" name="search" placeholder="Поиск по названию" value="<?= $search ?>">
        <button class="btn btn-tertiary content-seacher__btn">
            <i class="fa fa-search"></i>
        </button>
        <a href="/" class="btn btn-secondary content-seacher__reset" type="reset">
            <i class="fa fa-times"></i>
            <span style="margin-left: 10px;">Сброс</span>
        </a>
    </form>

    <? if (count($articles)) : ?>
        <? foreach ($articles as $article) : ?>
            <div class="content__card">
                <a class="content-card__link" href="/article/<?= $article['id'] ?>">
                    <img class="content-card__image" src="<?= $article['image'] ?>">
                    <span class="content-card__text">
                        <span class="content-card__title"><?= $article['title'] ?></span>
                        <span class="content-card__date"><?= $article['created_at'] ?></span>
                        <span class="content-card__description">
                            <?
                            $dom = new DOMDocument();
                            $dom->loadHTML('<?xml charset="utf-8">' . $article['content']);
                            echo mb_substr($dom->textContent, 0, 255, 'UTF-8') . '...';
                            ?>
                        </span>
                    </span>
                </a>
            </div>
        <? endforeach; ?>

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
    <? else : ?>
        <h2 style="text-align: center;">Записей не найдено</h2>
    <? endif; ?>
</div>