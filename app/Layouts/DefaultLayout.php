<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="/static/layout.css">
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
    <header class="content__header">
        <a href="/" class="content__logo">
            <i class="fa fa-edit"></i>
            <span>BLOG</span>
        </a>
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