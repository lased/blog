<div class="content-seacher">
    <input class="input content-seacher__input" name="search" placeholder="Поиск по названию" value="<?= $search ?>">
    <i class="content-seacher__icon fa fa-search"></i>
</div>

<? foreach ($articles as $article) : ?>
    <?= $article['id'] ?>
    <div>
        <?= $article['created_at'] ?>
    </div>
    <img src="<?= $article['image'] ?>">
    <div>
        <?= $article['title'] ?>
    </div>
    <div>
        <?
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml charset="utf-8">' . $article['content']);
        echo mb_substr($dom->textContent, 0, 127, 'UTF-8') . '...';
        ?>
    </div>
<? endforeach; ?>

<div class="content-pagination__arrows">
    ?>
    <button class="btn content-pagination__btn" <? if (!($page - 1)) : ?> disabled <? endif; ?>>
        <a class="content-pagination__link" href="<?= "?page=" . ($page - 1) ?>">
            <i class="fa fa-arrow-left"></i>
        </a>
    </button>
    <button class="btn content-pagination__btn" <? if (ceil($rowsCount / $limit) == $page) : ?> disabled <? endif; ?>>
        <a class="content-pagination__link" href="<?= "?page=" . ($page + 1) ?>">
            <i class="fa fa-arrow-right"></i>
        </a>
    </button>
</div>