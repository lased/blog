<?
$navbar = [
    [
        'text' => 'Статьи',
        'href' => '/panel/article/list'
    ]
];
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="/static/panel/layout.css">
    <? if (!empty($this->params['styles'])) : ?>
        <? foreach ($this->params['styles'] as $value) : ?>
            <link rel="stylesheet" href="<?= $value['href'] ?>">
        <? endforeach; ?>
    <? endif; ?>
</head>

<body>
    <div class="loader">
        <div class="loader__blocks">
            <div class="loader__block-1"></div>
            <div class="loader__block-2"></div>
            <div class="loader__block-3"></div>
        </div>
    </div>
    <header class="header">
        <div class="header__wrapper">
            <a class="header__toggler" href="#navbar">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <div class="header__title">Панель управления</div>
            <nav class="nav header-nav" id="navbar">
                <ul class="nav__list header-nav__list">
                    <? foreach ($navbar as $nav) : ?>
                        <li class="nav__item header-nav__item">
                            <a class="nav__link header-nav__link <?= $nav['href'] !== rtrim($_SERVER['REQUEST_URI'], '/') ?: 'header-nav__link--active' ?>" href="<?= $nav['href'] ?>">
                                <?= $nav['text'] ?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </nav><a class="header__backdrop" href="#"></a>
        </div>
    </header>
    <main class="content">
        <?= $content ?>
    </main>
    <script defer="defer" src="/static/components/loader/loader.js"></script>
    <? if (!empty($this->params['scripts'])) : ?>
        <? foreach ($this->params['scripts'] as $value) : ?>
            <? if (!empty($value['text'])) : ?>
                <script>
                    <?= $value['text'] ?>
                </script>
            <? else : ?>
                <script defer="defer" src="<?= $value['src'] ?>"></script>
            <? endif; ?>
        <? endforeach; ?>
    <? endif; ?>
</body>

</html>